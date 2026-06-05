<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats — {{ $scan->target }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if($scan->status !== 'completed' && $scan->status !== 'failed')
        <meta http-equiv="refresh" content="5">
    @endif
    <style>
        :root {
            --neon-green: #00ff88;
            --neon-blue: #00d4ff;
            --neon-red: #ff3366;
            --neon-yellow: #ffcc00;
            --neon-orange: #ff8c00;
            --bg-dark: #050a0e;
            --bg-card: #0a1520;
            --bg-card2: #0d1f2d;
            --text-primary: #e8f4f8;
            --text-muted: #5a7a8a;
            --font-mono: 'Share Tech Mono', monospace;
            --font-display: 'Exo 2', sans-serif;
            --font-body: 'Rajdhani', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--bg-dark);
            color: var(--text-primary);
            font-family: var(--font-body);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                linear-gradient(rgba(0,255,136,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,255,136,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none; z-index: 0;
        }

        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 40px;
            background: rgba(5,10,14,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,255,136,0.08);
        }

        .logo { font-family: var(--font-mono); font-size: 18px; color: var(--neon-green); text-decoration: none; letter-spacing: 2px; }
        .logo span { color: var(--neon-blue); }

        .nav-right { display: flex; gap: 20px; align-items: center; }
        .nav-link { font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); text-decoration: none; transition: color 0.3s; }
        .nav-link:hover { color: var(--neon-green); }

        .main {
            position: relative; z-index: 1;
            max-width: 960px; margin: 0 auto;
            padding: 50px 24px;
        }

        /* HEADER */
        .result-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .back-btn {
            font-family: var(--font-mono);
            font-size: 12px; color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
            margin-bottom: 12px;
            display: inline-block;
        }

        .back-btn:hover { color: var(--neon-green); }

        .target-title {
            font-family: var(--font-display);
            font-size: 36px; font-weight: 800;
            word-break: break-all;
        }

        .status-pill {
            display: inline-flex; align-items: center; gap: 8px;
            font-family: var(--font-mono);
            font-size: 12px; font-weight: 700;
            padding: 6px 16px; border-radius: 2px;
            letter-spacing: 1px;
        }

        .status-completed { background: rgba(0,255,136,0.1); color: var(--neon-green); border: 1px solid rgba(0,255,136,0.3); }
        .status-running   { background: rgba(0,212,255,0.1); color: var(--neon-blue);  border: 1px solid rgba(0,212,255,0.3); }
        .status-pending   { background: rgba(255,204,0,0.1); color: var(--neon-yellow); border: 1px solid rgba(255,204,0,0.3); }
        .status-failed    { background: rgba(255,51,102,0.1); color: var(--neon-red);  border: 1px solid rgba(255,51,102,0.3); }

        .action-btns { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px; }

        .btn-pdf {
            font-family: var(--font-mono);
            font-size: 12px; color: var(--neon-red);
            border: 1px solid rgba(255,51,102,0.3);
            padding: 8px 20px; border-radius: 2px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-pdf:hover { background: rgba(255,51,102,0.08); box-shadow: 0 0 20px rgba(255,51,102,0.2); }

        .btn-rescan {
            font-family: var(--font-mono);
            font-size: 12px; color: var(--neon-green);
            border: 1px solid rgba(0,255,136,0.3);
            padding: 8px 20px; border-radius: 2px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-rescan:hover { background: rgba(0,255,136,0.08); }

        /* SUMMARY CARDS */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 40px;
        }

        .summary-card {
            background: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 4px;
            padding: 20px;
            text-align: center;
        }

        .summary-card .count {
            font-family: var(--font-mono);
            font-size: 36px;
            display: block; line-height: 1;
            margin-bottom: 6px;
        }

        .summary-card .label {
            font-size: 11px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 1px;
        }

        .s-critical { border-color: rgba(255,51,102,0.3); }
        .s-critical .count { color: var(--neon-red); text-shadow: 0 0 20px rgba(255,51,102,0.4); }

        .s-high { border-color: rgba(255,140,0,0.3); }
        .s-high .count { color: var(--neon-orange); text-shadow: 0 0 20px rgba(255,140,0,0.4); }

        .s-medium { border-color: rgba(255,204,0,0.3); }
        .s-medium .count { color: var(--neon-yellow); text-shadow: 0 0 20px rgba(255,204,0,0.4); }

        .s-low { border-color: rgba(0,255,136,0.2); }
        .s-low .count { color: var(--neon-green); text-shadow: 0 0 20px rgba(0,255,136,0.4); }

        /* WAITING STATE */
        .waiting-box {
            background: var(--bg-card);
            border: 1px solid rgba(0,212,255,0.2);
            border-radius: 4px;
            padding: 50px;
            text-align: center;
            margin-bottom: 40px;
        }

        .radar {
            width: 100px; height: 100px;
            border: 2px solid rgba(0,255,136,0.2);
            border-radius: 50%;
            margin: 0 auto 30px;
            position: relative;
        }

        .radar::before {
            content: '';
            position: absolute; top: 50%; left: 50%;
            width: 50%; height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-green));
            transform-origin: left center;
            animation: radar-spin 2s linear infinite;
        }

        .radar::after {
            content: '';
            position: absolute; inset: 8px;
            border: 1px solid rgba(0,255,136,0.1);
            border-radius: 50%;
        }

        @keyframes radar-spin { to { transform: rotate(360deg); } }

        .waiting-text {
            font-family: var(--font-mono);
            font-size: 14px; color: var(--neon-blue);
            margin-bottom: 8px;
        }

        .waiting-sub {
            font-size: 13px; color: var(--text-muted);
        }

        /* FINDINGS */
        .section-header {
            font-family: var(--font-mono);
            font-size: 12px; color: var(--text-muted);
            letter-spacing: 2px; text-transform: uppercase;
            margin-bottom: 16px;
            display: flex; align-items: center; gap: 12px;
        }

        .section-header::after {
            content: '';
            flex: 1; height: 1px;
            background: rgba(0,255,136,0.08);
        }

        .finding-card {
            background: var(--bg-card);
            border-radius: 4px;
            padding: 0;
            margin-bottom: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
        }

        .finding-card:hover {
            transform: translateX(4px);
        }

        .finding-card.critical { border-left: 4px solid var(--neon-red); }
        .finding-card.high     { border-left: 4px solid var(--neon-orange); }
        .finding-card.medium   { border-left: 4px solid var(--neon-yellow); }
        .finding-card.low      { border-left: 4px solid var(--neon-green); }
        .finding-card.info     { border-left: 4px solid var(--neon-blue); }

        .finding-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px;
            cursor: pointer;
        }

        .finding-left { display: flex; align-items: center; gap: 12px; }

        .sev-badge {
            font-family: var(--font-mono); font-size: 10px; font-weight: 700;
            padding: 3px 10px; border-radius: 2px; letter-spacing: 1px;
        }

        .badge-critical { background: rgba(255,51,102,0.15); color: #ff6688; }
        .badge-high     { background: rgba(255,140,0,0.15); color: #ffaa44; }
        .badge-medium   { background: rgba(255,204,0,0.12); color: #ffcc44; }
        .badge-low      { background: rgba(0,255,136,0.1); color: var(--neon-green); }
        .badge-info     { background: rgba(0,212,255,0.1); color: var(--neon-blue); }

        .finding-title {
            font-family: var(--font-display);
            font-size: 16px; font-weight: 600;
        }

        .finding-cat {
            font-family: var(--font-mono);
            font-size: 11px; color: var(--text-muted);
        }

        .chevron {
            color: var(--text-muted); font-size: 14px;
            transition: transform 0.3s;
        }

        .finding-body {
            display: none;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        .finding-body.open { display: block; }

        .finding-body .chevron.open { transform: rotate(180deg); }

        .finding-desc {
            padding: 16px 20px;
            font-size: 14px; color: var(--text-muted);
            line-height: 1.7;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .solution-box {
            padding: 16px 20px;
            background: rgba(0,255,136,0.02);
        }

        .solution-title {
            font-family: var(--font-mono);
            font-size: 11px; color: var(--neon-green);
            letter-spacing: 2px; text-transform: uppercase;
            margin-bottom: 10px;
        }

        .solution-steps {
            list-style: none;
            display: flex; flex-direction: column; gap: 6px;
        }

        .solution-steps li {
            font-size: 13px; color: var(--text-muted);
            padding-left: 16px;
            position: relative;
            line-height: 1.6;
        }

        .solution-steps li::before {
            content: '→';
            position: absolute; left: 0;
            color: var(--neon-green);
        }

        /* SUCCESS STATE */
        .success-box {
            text-align: center; padding: 60px;
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.2);
            border-radius: 4px;
        }

        .success-icon { font-size: 60px; margin-bottom: 20px; display: block; }

        .success-box h2 {
            font-family: var(--font-display);
            font-size: 28px; font-weight: 700;
            color: var(--neon-green);
            margin-bottom: 12px;
        }

        .success-box p { font-size: 15px; color: var(--text-muted); }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('dashboard') }}" class="logo">VULN<span>SCANNER</span></a>
    <div class="nav-right">
        <a href="{{ route('scan.history') }}" class="nav-link">[ HISTORIQUE ]</a>
        <a href="{{ route('dashboard') }}" class="nav-link">[ NOUVEAU SCAN ]</a>
    </div>
</nav>

<div class="main">

    <a href="{{ route('dashboard') }}" class="back-btn">← Retour au scanner</a>

    <div class="result-header">
        <div>
            <div class="target-title">{{ $scan->target }}</div>
            <div style="margin-top:12px;display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                <span class="status-pill status-{{ $scan->status }}">
                    @if($scan->status === 'completed') ✓ TERMINÉ
                    @elseif($scan->status === 'running') ⟳ EN COURS
                    @elseif($scan->status === 'pending') ◷ EN ATTENTE
                    @else ✗ ÉCHEC @endif
                </span>
                <span style="font-family:var(--font-mono);font-size:11px;color:var(--text-muted);">
                    {{ $scan->created_at->format('d/m/Y à H:i') }}
                </span>
            </div>
        </div>

        @if($scan->status === 'completed')
        <div class="action-btns">
            <a href="{{ route('scan.pdf', $scan->id) }}" class="btn-pdf">📄 RAPPORT PDF</a>
            <a href="{{ route('dashboard') }}" class="btn-rescan">+ NOUVEAU SCAN</a>
        </div>
        @endif
    </div>

    @if($scan->status !== 'completed' && $scan->status !== 'failed')
        <!-- WAITING -->
        <div class="waiting-box">
            <div class="radar"></div>
            <div class="waiting-text">Analyse en cours...</div>
            <div class="waiting-sub">La page se rafraîchit automatiquement toutes les 5 secondes</div>
        </div>
    @else

        @php
            $critical = $findings->where('severity','critical')->count();
            $high     = $findings->where('severity','high')->count();
            $medium   = $findings->where('severity','medium')->count();
            $low      = $findings->where('severity','low')->count();

            $solutions = [
                '21'    => ['Désactivez le service FTP si non nécessaire.', 'Remplacez FTP par SFTP (port 22) ou FTPS.', 'Si FTP est requis, limitez l\'accès par IP avec un pare-feu.'],
                '22'    => ['Désactivez l\'authentification par mot de passe, utilisez des clés SSH.', 'Changez le port SSH (ex: 2222) pour éviter les scans automatiques.', 'Limitez l\'accès SSH aux seules IP de confiance.', 'Activez Fail2Ban pour bloquer les tentatives de brute force.'],
                '23'    => ['Désactivez immédiatement Telnet — il est totalement non sécurisé.', 'Remplacez Telnet par SSH pour toute administration à distance.', 'Bloquez le port 23 dans votre pare-feu.'],
                '25'    => ['Vérifiez que votre serveur SMTP n\'est pas un "open relay".', 'Configurez SPF, DKIM et DMARC pour sécuriser votre messagerie.', 'Limitez l\'accès SMTP aux seuls serveurs autorisés.'],
                '80'    => ['Redirigez tout le trafic HTTP vers HTTPS.', 'Configurez HSTS pour forcer HTTPS côté navigateur.', 'Obtenez un certificat SSL gratuit avec Let\'s Encrypt.'],
                '3306'  => ['Ne jamais exposer MySQL sur internet — utilisez un pare-feu.', 'Liez MySQL uniquement à 127.0.0.1 dans my.cnf.', 'Utilisez un tunnel SSH ou VPN pour les accès distants.'],
                '3389'  => ['Désactivez RDP si non utilisé, ou limitez l\'accès par IP.', 'Activez l\'authentification à deux facteurs pour RDP.', 'Utilisez un VPN pour accéder à RDP depuis l\'extérieur.'],
                '5432'  => ['Liez PostgreSQL uniquement à localhost dans postgresql.conf.', 'Utilisez un pare-feu pour bloquer le port 5432 depuis internet.', 'Configurez pg_hba.conf pour n\'autoriser que les IP de confiance.'],
                '5900'  => ['Désactivez VNC si non utilisé.', 'Utilisez VNC uniquement via un tunnel SSH chiffré.', 'Configurez un mot de passe fort et limitez l\'accès par IP.'],
                '6379'  => ['Configurez un mot de passe Redis (requirepass dans redis.conf).', 'Liez Redis à 127.0.0.1 uniquement.', 'Utilisez un pare-feu pour bloquer le port 6379 depuis internet.'],
                '27017' => ['Activez l\'authentification MongoDB (--auth).', 'Liez MongoDB à 127.0.0.1 dans mongod.conf.', 'Ne jamais exposer MongoDB directement sur internet.'],
                'default' => ['Vérifiez si ce service est nécessaire et désactivez-le sinon.', 'Configurez votre pare-feu pour limiter l\'accès à ce port.', 'Maintenez le service à jour avec les derniers correctifs de sécurité.'],
            ];
        @endphp

        <!-- SUMMARY -->
        <div class="summary-grid">
            <div class="summary-card s-critical">
                <span class="count">{{ $critical }}</span>
                <span class="label">Critical</span>
            </div>
            <div class="summary-card s-high">
                <span class="count">{{ $high }}</span>
                <span class="label">High</span>
            </div>
            <div class="summary-card s-medium">
                <span class="count">{{ $medium }}</span>
                <span class="label">Medium</span>
            </div>
            <div class="summary-card s-low">
                <span class="count">{{ $low }}</span>
                <span class="label">Low</span>
            </div>
        </div>

        @if($findings->count() > 0)
            <div class="section-header">{{ $findings->count() }} VULNÉRABILITÉ(S) DÉTECTÉE(S)</div>

            @foreach($findings as $finding)
                @php
                    preg_match('/Port (\d+)/', $finding->title, $portMatch);
                    $port = $portMatch[1] ?? 'default';
                    $sol = $solutions[$port] ?? $solutions['default'];
                @endphp

                <div class="finding-card {{ $finding->severity }}" onclick="toggleFinding({{ $finding->id }})">
                    <div class="finding-header">
                        <div class="finding-left">
                            <span class="sev-badge badge-{{ $finding->severity }}">{{ strtoupper($finding->severity) }}</span>
                            <div>
                                <div class="finding-title">{{ $finding->title }}</div>
                                <div class="finding-cat">{{ strtoupper($finding->category) }}</div>
                            </div>
                        </div>
                        <span class="chevron" id="chevron-{{ $finding->id }}">▼</span>
                    </div>

                    <div class="finding-body" id="body-{{ $finding->id }}">
                        @if($finding->description)
                        <div class="finding-desc">
                            {{ $finding->description }}
                        </div>
                        @endif

                        <div class="solution-box">
                            <div class="solution-title">✓ SOLUTIONS RECOMMANDÉES</div>
                            <ul class="solution-steps">
                                @foreach($sol as $step)
                                    <li>{{ $step }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <div class="success-box">
                <span class="success-icon">🛡️</span>
                <h2>Aucune vulnérabilité détectée !</h2>
                <p>Les 100 ports les plus courants ont été analysés.<br>Aucun service dangereux n'a été trouvé sur cette cible.</p>
            </div>
        @endif

    @endif
</div>

<script>
function toggleFinding(id) {
    const body = document.getElementById('body-' + id);
    const chevron = document.getElementById('chevron-' + id);
    body.classList.toggle('open');
    chevron.style.transform = body.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
}
</script>

</body>
</html>