<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VulnScanner — Protégez votre présence en ligne</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@400;500;600;700&family=Exo+2:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #00ff88;
            --neon-blue: #00d4ff;
            --neon-red: #ff3366;
            --bg-dark: #050a0e;
            --bg-card: #0a1520;
            --bg-card2: #0d1f2d;
            --border-glow: rgba(0,255,136,0.3);
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
            overflow-x: hidden;
            cursor: default;
        }

        /* ── SCANLINE OVERLAY ── */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,0,0,0.08) 2px,
                rgba(0,0,0,0.08) 4px
            );
            pointer-events: none;
            z-index: 9999;
        }

        /* ── GRID BACKGROUND ── */
        .grid-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                linear-gradient(rgba(0,255,136,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,255,136,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        /* ── NAV ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 48px;
            background: rgba(5,10,14,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,255,136,0.1);
        }

        .logo {
            font-family: var(--font-mono);
            font-size: 20px;
            color: var(--neon-green);
            text-shadow: 0 0 20px rgba(0,255,136,0.5);
            letter-spacing: 2px;
        }

        .logo span { color: var(--neon-blue); }

        .nav-links { display: flex; gap: 32px; align-items: center; }

        .nav-links a {
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            color: var(--text-muted);
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px; left: 0; right: 0;
            height: 1px;
            background: var(--neon-green);
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .nav-links a:hover { color: var(--neon-green); }
        .nav-links a:hover::after { transform: scaleX(1); }

        .btn-nav {
            font-family: var(--font-mono);
            font-size: 13px;
            color: var(--neon-green) !important;
            border: 1px solid var(--neon-green);
            padding: 8px 20px;
            border-radius: 2px;
            transition: all 0.3s !important;
        }

        .btn-nav:hover {
            background: rgba(0,255,136,0.1) !important;
            box-shadow: 0 0 20px rgba(0,255,136,0.3);
        }

        .btn-nav::after { display: none !important; }

        /* ── HERO ── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 24px 60px;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--neon-green);
            border: 1px solid rgba(0,255,136,0.3);
            padding: 6px 16px;
            border-radius: 2px;
            margin-bottom: 32px;
            background: rgba(0,255,136,0.05);
            animation: fadeInDown 0.8s ease;
        }

        .pulse-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--neon-green);
            box-shadow: 0 0 10px var(--neon-green);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero h1 {
            font-family: var(--font-display);
            font-size: clamp(48px, 8vw, 96px);
            font-weight: 800;
            line-height: 1;
            margin-bottom: 8px;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .hero h1 .line1 { color: var(--text-primary); }
        .hero h1 .line2 {
            color: transparent;
            -webkit-text-stroke: 1px var(--neon-green);
            text-shadow: none;
            filter: drop-shadow(0 0 20px rgba(0,255,136,0.4));
        }

        .hero-sub {
            font-size: 18px;
            font-weight: 400;
            color: var(--text-muted);
            max-width: 600px;
            margin: 24px auto 48px;
            line-height: 1.6;
            letter-spacing: 0.5px;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .hero-sub strong { color: var(--neon-blue); font-weight: 600; }

        .hero-cta {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .btn-primary {
            font-family: var(--font-mono);
            font-size: 14px;
            color: var(--bg-dark);
            background: var(--neon-green);
            padding: 14px 36px;
            border-radius: 2px;
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 0 30px rgba(0,255,136,0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover { box-shadow: 0 0 50px rgba(0,255,136,0.7); transform: translateY(-2px); }
        .btn-primary:hover::before { left: 100%; }

        .btn-secondary {
            font-family: var(--font-mono);
            font-size: 14px;
            color: var(--neon-blue);
            border: 1px solid rgba(0,212,255,0.4);
            padding: 14px 36px;
            border-radius: 2px;
            text-decoration: none;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: rgba(0,212,255,0.08);
            box-shadow: 0 0 30px rgba(0,212,255,0.2);
            transform: translateY(-2px);
        }

        /* ── STATS BAR ── */
        .stats-bar {
            display: flex;
            gap: 0;
            justify-content: center;
            margin-top: 80px;
            border: 1px solid rgba(0,255,136,0.15);
            border-radius: 4px;
            overflow: hidden;
            animation: fadeInUp 0.8s ease 0.8s both;
        }

        .stat-item {
            padding: 20px 40px;
            text-align: center;
            border-right: 1px solid rgba(0,255,136,0.1);
            flex: 1;
            background: rgba(0,255,136,0.02);
        }

        .stat-item:last-child { border-right: none; }

        .stat-num {
            font-family: var(--font-mono);
            font-size: 28px;
            color: var(--neon-green);
            text-shadow: 0 0 20px rgba(0,255,136,0.5);
            display: block;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* ── SECTION ── */
        section {
            position: relative;
            z-index: 1;
            padding: 100px 48px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-label {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--neon-green);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 16px;
        }

        .section-desc {
            font-size: 16px;
            color: var(--text-muted);
            max-width: 560px;
            line-height: 1.7;
        }

        /* ── FEATURES ── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 60px;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.1);
            border-radius: 4px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-green), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feature-card:hover {
            border-color: rgba(0,255,136,0.3);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3), 0 0 40px rgba(0,255,136,0.05);
        }

        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            font-size: 36px;
            margin-bottom: 20px;
            display: block;
        }

        .feature-title {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        .feature-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .feature-tag {
            display: inline-block;
            margin-top: 16px;
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--neon-green);
            border: 1px solid rgba(0,255,136,0.2);
            padding: 3px 10px;
            border-radius: 2px;
        }

        /* ── WARNING SECTION ── */
        .warning-section {
            background: rgba(255,51,102,0.03);
            border: 1px solid rgba(255,51,102,0.15);
            border-radius: 4px;
            padding: 60px;
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .warning-section::before {
            content: '⚠';
            position: absolute;
            right: 40px; top: 20px;
            font-size: 120px;
            opacity: 0.04;
            color: var(--neon-red);
        }

        .warning-title {
            font-family: var(--font-mono);
            font-size: 13px;
            color: var(--neon-red);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .warning-text {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.8;
            max-width: 700px;
        }

        .warning-text strong { color: var(--text-primary); }

        /* ── AWARENESS SECTION ── */
        .awareness-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }

        .awareness-card {
            background: var(--bg-card2);
            border: 1px solid rgba(0,212,255,0.1);
            border-radius: 4px;
            padding: 28px;
            transition: all 0.3s;
        }

        .awareness-card:hover {
            border-color: rgba(0,212,255,0.3);
            box-shadow: 0 0 30px rgba(0,212,255,0.05);
        }

        .awareness-num {
            font-family: var(--font-mono);
            font-size: 36px;
            color: rgba(0,212,255,0.2);
            line-height: 1;
            margin-bottom: 12px;
        }

        .awareness-title {
            font-family: var(--font-display);
            font-size: 17px;
            font-weight: 700;
            color: var(--neon-blue);
            margin-bottom: 10px;
        }

        .awareness-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ── CTA SECTION ── */
        .cta-section {
            text-align: center;
            padding: 100px 48px;
            position: relative;
            z-index: 1;
        }

        .cta-box {
            max-width: 700px;
            margin: 0 auto;
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.2);
            border-radius: 4px;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .cta-box::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(0,255,136,0.08), transparent 70%);
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .cta-box h2 {
            font-family: var(--font-display);
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .cta-box p {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 36px;
            line-height: 1.6;
        }

        /* ── FOOTER ── */
        footer {
            position: relative;
            z-index: 1;
            border-top: 1px solid rgba(0,255,136,0.08);
            padding: 40px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-logo {
            font-family: var(--font-mono);
            color: var(--neon-green);
            font-size: 16px;
            opacity: 0.6;
        }

        .footer-text {
            font-size: 13px;
            color: var(--text-muted);
            font-family: var(--font-mono);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .divider {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,255,136,0.2), transparent);
            margin: 0 48px;
        }

        /* terminal typing effect */
        .terminal-line {
            font-family: var(--font-mono);
            font-size: 13px;
            color: var(--neon-green);
            opacity: 0.6;
            margin-top: 40px;
            animation: fadeInUp 0.8s ease 1s both;
        }

        .terminal-line::before { content: '> '; }
        .cursor {
            display: inline-block;
            width: 8px; height: 14px;
            background: var(--neon-green);
            animation: blink 1s infinite;
            vertical-align: middle;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    </style>
</head>
<body>
<div class="grid-bg"></div>

<!-- NAV -->
<nav>
    <div class="logo">VULN<span>SCANNER</span></div>
    <div class="nav-links">
        <a href="#features">Features</a>
        <a href="#awareness">Sensibilisation</a>
        <a href="{{ route('login') }}" class="btn-nav">[ CONNEXION ]</a>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <div class="hero-badge">
        <div class="pulse-dot"></div>
        SYSTÈME ACTIF — PROTECTION EN TEMPS RÉEL
    </div>

    <h1>
        <div class="line1">ANALYSEZ.</div>
        <div class="line2">PROTÉGEZ.</div>
    </h1>

    <p class="hero-sub">
        Vous avez reçu un lien suspect ? Une IP douteuse ? Notre scanner détecte
        <strong>les ports exposés</strong> et les failles de sécurité avant qu'il ne soit trop tard.
    </p>

    <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn-primary">COMMENCER LE SCAN</a>
        <a href="#features" class="btn-secondary">EN SAVOIR PLUS</a>
    </div>

    <div class="terminal-line">
        scanning target... ports analyzed... vulnerabilities detected <span class="cursor"></span>
    </div>

    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-num">100+</span>
            <span class="stat-label">Ports analysés</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">4</span>
            <span class="stat-label">Types de checks</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">&lt;60s</span>
            <span class="stat-label">Temps de scan</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">100%</span>
            <span class="stat-label">Gratuit</span>
        </div>
    </div>
</div>

<div class="divider"></div>

<!-- FEATURES -->
<section id="features">
    <div class="section-label">// FONCTIONNALITÉS</div>
    <h2 class="section-title">Ce que notre scanner<br>détecte pour vous</h2>
    <p class="section-desc">Un outil puissant mais simple. Entrez une URL, une IP ou un domaine — le reste, c'est notre affaire.</p>

    <div class="features-grid">
        <div class="feature-card">
            <span class="feature-icon">🔍</span>
            <div class="feature-title">Scan de Ports</div>
            <div class="feature-desc">Détecte les 100 ports les plus courants. Identifie les services dangereux exposés comme FTP, Telnet, MySQL, RDP et bien d'autres.</div>
            <span class="feature-tag">NMAP ENGINE</span>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🛡️</span>
            <div class="feature-title">Niveau de Risque</div>
            <div class="feature-desc">Chaque vulnérabilité est classée par sévérité : CRITICAL, HIGH, MEDIUM, LOW. Avec une explication claire et une solution proposée.</div>
            <span class="feature-tag">CVSS SCORING</span>
        </div>
        <div class="feature-card">
            <span class="feature-icon">📊</span>
            <div class="feature-title">Rapport Détaillé</div>
            <div class="feature-desc">Téléchargez un rapport PDF professionnel avec toutes les vulnérabilités trouvées et les recommandations de correction.</div>
            <span class="feature-tag">PDF EXPORT</span>
        </div>
        <div class="feature-card">
            <span class="feature-icon">📋</span>
            <div class="feature-title">Historique Complet</div>
            <div class="feature-desc">Tous vos scans sont sauvegardés. Suivez l'évolution de la sécurité d'une cible dans le temps et comparez les résultats.</div>
            <span class="feature-tag">SCAN HISTORY</span>
        </div>
        <div class="feature-card">
            <span class="feature-icon">⚡</span>
            <div class="feature-title">Analyse Rapide</div>
            <div class="feature-desc">Résultats en moins de 60 secondes grâce à notre moteur de scan optimisé. Pas d'attente, pas d'installation requise.</div>
            <span class="feature-tag">FAST SCAN</span>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🔐</span>
            <div class="feature-title">Espace Sécurisé</div>
            <div class="feature-desc">Vos scans sont privés et liés à votre compte. Personne d'autre ne peut voir vos résultats.</div>
            <span class="feature-tag">AUTHENTICATED</span>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- AWARENESS -->
<section id="awareness">
    <div class="section-label">// SENSIBILISATION</div>
    <h2 class="section-title">Vous avez reçu un lien<br><span style="color:var(--neon-red)">suspect ?</span></h2>
    <p class="section-desc">Ne cliquez pas avant de scanner. Voici comment réagir face à une menace potentielle.</p>

    <div class="warning-section">
        <div class="warning-title">⚠ AVERTISSEMENT LÉGAL</div>
        <p class="warning-text">
            Ce scanner est conçu <strong>uniquement pour analyser des cibles que vous possédez ou pour lesquelles vous avez une autorisation explicite.</strong>
            Scanner un système sans permission est <strong>illégal</strong> dans la plupart des pays et peut entraîner des poursuites pénales.
            Utilisez cet outil de manière responsable et éthique.
        </p>
    </div>

    <div class="awareness-grid" style="margin-top:50px">
        <div class="awareness-card">
            <div class="awareness-num">01</div>
            <div class="awareness-title">Ne cliquez pas immédiatement</div>
            <div class="awareness-desc">Si vous recevez un lien inattendu, même d'un ami, ne cliquez pas. Copiez l'URL et analysez-la d'abord avec notre scanner.</div>
        </div>
        <div class="awareness-card">
            <div class="awareness-num">02</div>
            <div class="awareness-title">Vérifiez l'expéditeur</div>
            <div class="awareness-desc">Les attaques de phishing usurpent souvent des identités connues. Vérifiez l'adresse email complète, pas seulement le nom affiché.</div>
        </div>
        <div class="awareness-card">
            <div class="awareness-num">03</div>
            <div class="awareness-title">Virus détecté sur votre PC ?</div>
            <div class="awareness-desc">Déconnectez-vous immédiatement d'internet, ne payez aucune rançon, contactez un professionnel et signalez l'incident aux autorités.</div>
        </div>
        <div class="awareness-card">
            <div class="awareness-num">04</div>
            <div class="awareness-title">Attaque en cours ?</div>
            <div class="awareness-desc">Isolez la machine infectée, changez tous vos mots de passe depuis un autre appareil, activez l'authentification à deux facteurs.</div>
        </div>
        <div class="awareness-card">
            <div class="awareness-num">05</div>
            <div class="awareness-title">Signalez les menaces</div>
            <div class="awareness-desc">En France : cybermalveillance.gouv.fr. Signalez tout incident pour aider à protéger d'autres utilisateurs contre les mêmes attaques.</div>
        </div>
        <div class="awareness-card">
            <div class="awareness-num">06</div>
            <div class="awareness-title">Mises à jour régulières</div>
            <div class="awareness-desc">80% des attaques exploitent des failles connues. Maintenez votre système, navigateur et applications constamment à jour.</div>
        </div>
    </div>
</section>

<!-- CTA -->
<div class="cta-section">
    <div class="cta-box">
        <h2>Prêt à vérifier<br>votre sécurité ?</h2>
        <p>Créez un compte gratuit et lancez votre premier scan en moins de 2 minutes.</p>
        <a href="{{ route('register') }}" class="btn-primary">CRÉER UN COMPTE GRATUIT</a>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">VULN<span style="color:var(--neon-blue)">SCANNER</span></div>
    <div class="footer-text">// UTILISEZ CET OUTIL DE MANIÈRE RESPONSABLE</div>
</footer>

</body>
</html>