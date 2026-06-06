<?php

namespace App\Jobs;

use App\Models\Scan;
use App\Models\ScanFinding;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ScanTargetJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Scan $scan) {}

   public function handle(): void
{
    $this->scan->update(['status' => 'running']);

    $target = parse_url($this->scan->target, PHP_URL_HOST) 
              ?? $this->scan->target;

    $this->scanPorts($target);

    $this->scan->update(['status' => 'completed']);
}

    // ── 1. PORTS ──────────────────────────────────────────
    private function scanPorts(string $target): void
{
    $t = escapeshellarg($target);
    $output = shell_exec("nmap -sV --open -T4 --top-ports 100 {$t} 2>&1");

    // Parser les ports ouverts
    preg_match_all('/(\d+)\/tcp\s+open\s+(\S+)\s*(.*)?/', $output, $matches);

    if (empty($matches[1])) {
        ScanFinding::create([
            'scan_id'     => $this->scan->id,
            'category'    => 'port',
            'title'       => 'Aucun port ouvert détecté',
            'description' => 'Tous les ports scannés sont fermés ou filtrés.',
            'severity'    => 'info',
        ]);
        return;
    }

    foreach ($matches[1] as $i => $port) {
        $service = $matches[2][$i];
        $version = trim($matches[3][$i]);

        // Ignorer les lignes de bannière inutiles
        if (str_contains($version, 'Directive') || str_contains($version, 'Nationale')) {
            $version = '';
        }

        ScanFinding::create([
            'scan_id'     => $this->scan->id,
            'category'    => 'port',
            'title'       => "Port {$port} ouvert — {$service}",
            'description' => $this->portDescription($port, $service, $version),
            'severity'    => $this->portSeverity($port),
        ]);
    }
}

    // ── Sévérité des ports ────────────────────────────────
    private function portSeverity(string $port): string
{
    return match(true) {
        in_array($port, ['23', '21', '69', '135', '137', '138', '139'])
            => 'critical',
        in_array($port, ['3306', '5432', '27017', '6379', '9200'])
            => 'high',
        in_array($port, ['22', '3389', '5900', '8080', '8443'])
            => 'medium',
        default => 'low',
    };
}

private function portDescription(string $port, string $service, string $version): string
{
    $descriptions = [
        '21'    => 'FTP — Transfert de fichiers non sécurisé, données en clair.',
        '22'    => 'SSH — Accès distant. Vérifiez que seules les IPs autorisées peuvent se connecter.',
        '23'    => 'Telnet — Protocole ancien et non sécurisé, tout le trafic est en clair.',
        '25'    => 'SMTP — Serveur email. Vérifiez qu\'il n\'est pas open relay.',
        '53'    => 'DNS — Vérifiez que le transfert de zone est désactivé.',
        '80'    => 'HTTP — Site web non chiffré. Pensez à forcer HTTPS.',
        '443'   => 'HTTPS — Site web chiffré. Port normal.',
        '3306'  => 'MySQL — Base de données exposée publiquement, risque critique.',
        '3389'  => 'RDP — Bureau à distance Windows, cible fréquente des attaquants.',
        '5432'  => 'PostgreSQL — Base de données exposée publiquement.',
        '5900'  => 'VNC — Bureau à distance, souvent mal sécurisé.',
        '6379'  => 'Redis — Base de données en mémoire, souvent sans authentification.',
        '8080'  => 'HTTP alternatif — Serveur web secondaire.',
        '27017' => 'MongoDB — Base de données exposée publiquement.',
    ];

    $base = $descriptions[$port] ?? "Service {$service} actif sur le port {$port}.";
    
    if (!empty($version)) {
        $base .= " Version détectée : {$version}.";
    }

    return $base;
}
}