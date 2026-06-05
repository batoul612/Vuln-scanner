<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #ffffff;
            color: #1a1a2e;
            font-size: 12px;
            line-height: 1.5;
        }

        /* HEADER */
        .header {
            background: #050a0e;
            color: white;
            padding: 30px 36px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #00ff88, #00d4ff, #00ff88);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #00ff88;
            letter-spacing: 3px;
        }

        .logo-text span { color: #00d4ff; }

        .report-badge {
            background: rgba(0,255,136,0.1);
            border: 1px solid rgba(0,255,136,0.3);
            color: #00ff88;
            padding: 4px 12px;
            font-size: 10px;
            letter-spacing: 2px;
        }

        .header-target {
            margin-top: 16px;
        }

        .header-target .label {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .header-target .value {
            font-size: 20px;
            font-weight: bold;
            color: white;
            margin-top: 4px;
        }

        .header-meta {
            display: flex;
            gap: 40px;
            margin-top: 16px;
        }

        .meta-item .mlabel {
            font-size: 9px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .meta-item .mvalue {
            font-size: 12px;
            color: rgba(255,255,255,0.8);
            margin-top: 2px;
        }

        /* SUMMARY */
        .summary-section {
            padding: 24px 36px;
            background: #f8fafb;
            border-bottom: 1px solid #e8eef2;
        }

        .section-title {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 14px;
        }

        .summary-grid {
            display: flex;
            gap: 12px;
        }

        .summary-card {
            flex: 1;
            text-align: center;
            padding: 14px;
            border-radius: 4px;
            border: 1px solid #e8eef2;
        }

        .s-critical { border-color: #ffccd5; background: #fff5f7; }
        .s-high     { border-color: #ffd8b0; background: #fff8f0; }
        .s-medium   { border-color: #fff0a0; background: #fffdf0; }
        .s-low      { border-color: #b8f0d8; background: #f0fff8; }

        .s-count {
            font-size: 30px;
            font-weight: bold;
            display: block;
            line-height: 1;
            margin-bottom: 4px;
        }

        .c-critical { color: #cc2244; }
        .c-high     { color: #cc6600; }
        .c-medium   { color: #aa8800; }
        .c-low      { color: #008844; }

        .s-label { font-size: 9px; color: #888; letter-spacing: 1px; text-transform: uppercase; }

        /* CONTENT */
        .content { padding: 24px 36px; }

        /* FINDING */
        .finding {
            margin-bottom: 20px;
            border: 1px solid #e8eef2;
            border-radius: 4px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .finding-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .finding.critical .finding-header { border-left: 4px solid #cc2244; background: #fff5f7; }
        .finding.high     .finding-header { border-left: 4px solid #cc6600; background: #fff8f0; }
        .finding.medium   .finding-header { border-left: 4px solid #aa8800; background: #fffdf0; }
        .finding.low      .finding-header { border-left: 4px solid #008844; background: #f0fff8; }

        .finding-title {
            font-size: 13px;
            font-weight: bold;
            color: #1a1a2e;
        }

        .finding-cat {
            font-size: 10px;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .badge {
            font-size: 9px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 2px;
            letter-spacing: 1px;
        }

        .badge-critical { background: #ffccd5; color: #cc2244; }
        .badge-high     { background: #ffd8b0; color: #cc6600; }
        .badge-medium   { background: #fff0a0; color: #aa8800; }
        .badge-low      { background: #b8f0d8; color: #008844; }

        .finding-desc {
            padding: 12px 16px;
            font-size: 12px;
            color: #444;
            background: white;
            border-bottom: 1px solid #f0f0f0;
        }

        .solutions {
            padding: 12px 16px;
            background: #f9fffe;
        }

        .sol-title {
            font-size: 9px;
            font-weight: bold;
            color: #008844;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .sol-list { list-style: none; }

        .sol-list li {
            font-size: 11px;
            color: #555;
            padding: 3px 0 3px 14px;
            position: relative;
            line-height: 1.5;
        }

        .sol-list li::before {
            content: '→';
            position: absolute; left: 0;
            color: #00aa66;
            font-weight: bold;
        }

        /* FOOTER */
        .footer {
            padding: 16px 36px;
            border-top: 1px solid #e8eef2;
            display: flex;
            justify-content: space-between;
            background: #f8fafb;
        }

        .footer-left { font-size: 10px; color: #aaa; }
        .footer-right { font-size: 10px; color: #aaa; }

        .no-findings {
            text-align: center;
            padding: 40px;
            background: #f0fff8;
            border: 1px solid #b8f0d8;
            border-radius: 4px;
            color: #008844;
            font-size: 14px;
            font-weight: bold;
        }

        .warning-box {
            background: #fff8f0;
            border: 1px solid #ffd8b0;
            border-radius: 4px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 11px;
            color: #885500;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div class="header-top">
        <div class="logo-text">VULN<span>SCANNER</span></div>
        <div class="report-badge">RAPPORT DE SÉCURITÉ</div>
    </div>

    <div class="header-target">
        <div class="label">// CIBLE ANALYSÉE</div>
        <div class="value">{{ $scan->target }}</div>
    </div>

    <div class="header-meta">
        <div class="meta-item">
            <div class="mlabel">Type</div>
            <div class="mvalue">{{ strtoupper($scan->type) }}</div>
        </div>
        <div class="meta-item">
            <div class="mlabel">Statut</div>
            <div class="mvalue">{{ ucfirst($scan->status) }}</div>
        </div>
        <div class="meta-item">
            <div class="mlabel">Date du scan</div>
            <div class="mvalue">{{ $scan->created_at->format('d/m/Y à H:i') }}</div>
        </div>
        <div class="meta-item">
            <div class="mlabel">Généré le</div>
            <div class="mvalue">{{ now()->format('d/m/Y à H:i') }}</div>
        </div>
    </div>
</div>

<!-- SUMMARY -->
@php
    $critical = $findings->where('severity','critical')->count();
    $high     = $findings->where('severity','high')->count();
    $medium   = $findings->where('severity','medium')->count();
    $low      = $findings->where('severity','low')->count();

    $solutions = [
        '21'    => ['Désactivez le service FTP si non nécessaire.', 'Remplacez FTP par SFTP (port 22) ou FTPS.', 'Limitez l\'accès par IP avec un pare-feu.'],
        '22'    => ['Utilisez des clés SSH plutôt que des mots de passe.', 'Changez le port SSH pour éviter les scans automatiques.', 'Activez Fail2Ban pour bloquer les brute force.'],
        '23'    => ['Désactivez Telnet immédiatement — protocole non sécurisé.', 'Remplacez Telnet par SSH.', 'Bloquez le port 23 dans votre pare-feu.'],
        '25'    => ['Vérifiez que SMTP n\'est pas un open relay.', 'Configurez SPF, DKIM et DMARC.'],
        '80'    => ['Redirigez HTTP vers HTTPS.', 'Configurez HSTS.', 'Obtenez un certificat SSL gratuit avec Let\'s Encrypt.'],
        '3306'  => ['Ne jamais exposer MySQL sur internet.', 'Liez MySQL à 127.0.0.1 dans my.cnf.', 'Utilisez SSH tunnel pour les accès distants.'],
        '3389'  => ['Désactivez RDP si non utilisé.', 'Activez l\'authentification à deux facteurs.', 'Utilisez un VPN pour accéder à RDP.'],
        '5432'  => ['Liez PostgreSQL à localhost uniquement.', 'Bloquez le port 5432 depuis internet via pare-feu.'],
        '5900'  => ['Désactivez VNC si non utilisé.', 'Utilisez VNC uniquement via tunnel SSH.'],
        '6379'  => ['Configurez un mot de passe Redis.', 'Liez Redis à 127.0.0.1.'],
        '27017' => ['Activez l\'authentification MongoDB.', 'Liez MongoDB à 127.0.0.1.'],
        'default' => ['Vérifiez si ce service est nécessaire.', 'Configurez votre pare-feu pour limiter l\'accès.', 'Maintenez le service à jour.'],
    ];
@endphp

<div class="summary-section">
    <div class="section-title">// RÉSUMÉ DES VULNÉRABILITÉS</div>
    <div class="summary-grid">
        <div class="summary-card s-critical">
            <span class="s-count c-critical">{{ $critical }}</span>
            <span class="s-label">Critical</span>
        </div>
        <div class="summary-card s-high">
            <span class="s-count c-high">{{ $high }}</span>
            <span class="s-label">High</span>
        </div>
        <div class="summary-card s-medium">
            <span class="s-count c-medium">{{ $medium }}</span>
            <span class="s-label">Medium</span>
        </div>
        <div class="summary-card s-low">
            <span class="s-count c-low">{{ $low }}</span>
            <span class="s-label">Low</span>
        </div>
    </div>
</div>

<!-- FINDINGS -->
<div class="content">
    <div class="section-title" style="margin-bottom:16px;">// DÉTAIL DES VULNÉRABILITÉS ET SOLUTIONS</div>

    @if($findings->count() > 0)

        <div class="warning-box">
            ⚠ Ce rapport est confidentiel. Les informations contenues doivent être utilisées uniquement pour corriger les vulnérabilités détectées sur vos propres systèmes.
        </div>

        @foreach($findings as $finding)
            @php
                preg_match('/Port (\d+)/', $finding->title, $portMatch);
                $port = $portMatch[1] ?? 'default';
                $sol = $solutions[$port] ?? $solutions['default'];
            @endphp

            <div class="finding {{ $finding->severity }}">
                <div class="finding-header">
                    <div>
                        <div class="finding-title">{{ $finding->title }}</div>
                        <div class="finding-cat">{{ strtoupper($finding->category) }}</div>
                    </div>
                    <span class="badge badge-{{ $finding->severity }}">{{ strtoupper($finding->severity) }}</span>
                </div>

                @if($finding->description)
                <div class="finding-desc">{{ $finding->description }}</div>
                @endif

                <div class="solutions">
                    <div class="sol-title">✓ SOLUTIONS RECOMMANDÉES</div>
                    <ul class="sol-list">
                        @foreach($sol as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach

    @else
        <div class="no-findings">
            ✓ Aucune vulnérabilité détectée — Les 100 ports les plus courants sont sécurisés.
        </div>
    @endif
</div>

<!-- FOOTER -->
<div class="footer">
    <div class="footer-left">VulnScanner — Rapport généré automatiquement</div>
    <div class="footer-right">Ce rapport est fourni à titre informatif. Utilisez-le de manière responsable et éthique.</div>
</div>

</body>
</html>