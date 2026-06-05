<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner — VulnScanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #00ff88;
            --neon-blue: #00d4ff;
            --neon-red: #ff3366;
            --neon-yellow: #ffcc00;
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

        /* NAV */
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

        .nav-link {
            font-family: var(--font-mono); font-size: 12px;
            color: var(--text-muted); text-decoration: none;
            letter-spacing: 1px; transition: color 0.3s;
        }
        .nav-link:hover { color: var(--neon-green); }

        .user-badge {
            font-family: var(--font-mono); font-size: 12px;
            color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2);
            padding: 4px 12px; border-radius: 2px;
        }

        /* MAIN */
        .main {
            position: relative; z-index: 1;
            max-width: 860px; margin: 0 auto;
            padding: 60px 24px;
        }

        /* HERO SCAN */
        .scan-hero {
            text-align: center;
            margin-bottom: 60px;
        }

        .scan-hero h1 {
            font-family: var(--font-display);
            font-size: 42px; font-weight: 800;
            margin-bottom: 12px;
        }

        .scan-hero p {
            font-size: 16px; color: var(--text-muted);
            line-height: 1.6;
        }

        /* SCAN FORM */
        .scan-form-box {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.15);
            border-radius: 4px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .scan-form-box::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-green), transparent);
        }

        .form-label {
            font-family: var(--font-mono);
            font-size: 11px; color: var(--neon-green);
            letter-spacing: 2px; text-transform: uppercase;
            margin-bottom: 12px; display: block;
        }

        .input-row {
            display: flex; gap: 12px;
        }

        .scan-input {
            flex: 1;
            background: rgba(0,255,136,0.03);
            border: 1px solid rgba(0,255,136,0.15);
            border-radius: 2px;
            padding: 14px 20px;
            color: var(--text-primary);
            font-family: var(--font-mono);
            font-size: 15px;
            transition: all 0.3s;
            outline: none;
        }

        .scan-input:focus {
            border-color: var(--neon-green);
            box-shadow: 0 0 20px rgba(0,255,136,0.1);
        }

        .scan-input::placeholder { color: var(--text-muted); }

        .btn-scan {
            background: var(--neon-green);
            color: var(--bg-dark);
            border: none;
            padding: 14px 36px;
            font-family: var(--font-mono);
            font-size: 14px; font-weight: 700;
            letter-spacing: 1px;
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 0 30px rgba(0,255,136,0.3);
            white-space: nowrap;
        }

        .btn-scan:hover {
            box-shadow: 0 0 50px rgba(0,255,136,0.6);
            transform: translateY(-1px);
        }

        .form-hint {
            margin-top: 12px;
            font-family: var(--font-mono);
            font-size: 12px; color: var(--text-muted);
            display: flex; gap: 20px;
        }

        .form-hint span::before { content: '• '; color: var(--neon-green); }

        /* WAITING ANIMATION */
        .waiting-box {
            background: var(--bg-card);
            border: 1px solid rgba(0,212,255,0.2);
            border-radius: 4px;
            padding: 40px;
            margin-bottom: 40px;
            display: none;
        }

        .waiting-box.active { display: block; }

        .scan-target-display {
            font-family: var(--font-mono);
            font-size: 13px; color: var(--neon-blue);
            margin-bottom: 30px;
        }

        .scan-target-display span { color: var(--text-primary); font-size: 16px; }

        .progress-bar-wrap {
            background: rgba(0,212,255,0.05);
            border: 1px solid rgba(0,212,255,0.15);
            border-radius: 2px;
            height: 6px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--neon-green), var(--neon-blue));
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(0,255,136,0.5);
            transition: width 0.5s ease;
            width: 0%;
        }

        .terminal-output {
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(0,255,136,0.1);
            border-radius: 2px;
            padding: 20px;
            font-family: var(--font-mono);
            font-size: 12px;
            max-height: 180px;
            overflow-y: auto;
            line-height: 1.8;
        }

        .terminal-output .t-line {
            display: block;
            animation: slideIn 0.3s ease;
        }

        .terminal-output .t-line.green { color: var(--neon-green); }
        .terminal-output .t-line.blue { color: var(--neon-blue); }
        .terminal-output .t-line.yellow { color: var(--neon-yellow); }
        .terminal-output .t-line.muted { color: var(--text-muted); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .scan-status {
            display: flex; align-items: center; gap: 10px;
            margin-top: 16px;
            font-family: var(--font-mono);
            font-size: 13px; color: var(--neon-blue);
        }

        .spin {
            width: 16px; height: 16px;
            border: 2px solid rgba(0,212,255,0.2);
            border-top-color: var(--neon-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .fun-fact-box {
            background: rgba(0,255,136,0.03);
            border: 1px solid rgba(0,255,136,0.1);
            border-radius: 2px;
            padding: 16px 20px;
            margin-top: 20px;
            font-family: var(--font-mono);
            font-size: 12px; color: var(--text-muted);
        }

        .fun-fact-box .label {
            color: var(--neon-green);
            margin-bottom: 6px; display: block;
        }

        /* RECENT SCANS */
        .recent-title {
            font-family: var(--font-mono);
            font-size: 12px; color: var(--text-muted);
            letter-spacing: 2px; text-transform: uppercase;
            margin-bottom: 16px;
        }

        .recent-list {
            display: flex; flex-direction: column; gap: 8px;
        }

        .recent-item {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--bg-card2);
            border: 1px solid rgba(0,255,136,0.06);
            border-radius: 2px;
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .recent-item:hover {
            border-color: rgba(0,255,136,0.2);
            background: rgba(0,255,136,0.03);
        }

        .recent-target {
            font-family: var(--font-mono);
            font-size: 14px; color: var(--text-primary);
        }

        .recent-meta {
            font-size: 12px; color: var(--text-muted);
            display: flex; align-items: center; gap: 12px;
        }

        .sev-badge {
            padding: 2px 8px; border-radius: 2px;
            font-family: var(--font-mono); font-size: 10px; font-weight: 700;
        }

        .sev-critical { background: rgba(255,51,102,0.15); color: #ff6688; }
        .sev-high { background: rgba(255,140,0,0.15); color: #ffaa44; }
        .sev-medium { background: rgba(255,204,0,0.15); color: #ffcc44; }
        .sev-low { background: rgba(0,255,136,0.1); color: var(--neon-green); }
        .sev-none { background: rgba(0,212,255,0.1); color: var(--neon-blue); }

        .status-dot {
            width: 8px; height: 8px; border-radius: 50%;
        }

        .dot-completed { background: var(--neon-green); box-shadow: 0 0 6px var(--neon-green); }
        .dot-running { background: var(--neon-blue); animation: pulse 1.5s infinite; }
        .dot-pending { background: var(--neon-yellow); }
        .dot-failed { background: var(--neon-red); }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .empty-state {
            text-align: center; padding: 40px;
            background: var(--bg-card2);
            border: 1px dashed rgba(0,255,136,0.1);
            border-radius: 4px;
            font-family: var(--font-mono);
            font-size: 13px; color: var(--text-muted);
        }
    </style>
</head>
<body>

<nav>
    <a href="/" class="logo">VULN<span>SCANNER</span></a>
    <div class="nav-right">
    <a href="{{ route('scan.history') }}" class="nav-link">[ HISTORIQUE ]</a>

    {{-- Bouton admin visible uniquement pour les admins --}}
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-link" 
           style="color:var(--neon-purple);border:1px solid rgba(170,68,255,0.3);padding:4px 12px;border-radius:2px;">
            ⚡ ADMIN
        </a>
    @endif

    <div class="user-badge">{{ auth()->user()->name }}</div>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" style="background:none;border:none;cursor:pointer;font-family:var(--font-mono);font-size:12px;color:var(--text-muted);">
            DÉCONNEXION
        </button>
    </form>
</div>
</nav>

<div class="main">
    <div class="scan-hero">
        <h1>🔍 Lancez un scan</h1>
        <p>Entrez une URL, une adresse IP ou un nom de domaine.<br>Notre moteur analysera les ports exposés et détectera les risques.</p>
    </div>

    <!-- FORM -->
    <div class="scan-form-box">
        <label class="form-label">// CIBLE À ANALYSER</label>
        <form method="POST" action="{{ route('scan.store') }}" id="scanForm">
            @csrf
            <div class="input-row">
                <input
                    type="text"
                    name="target"
                    id="targetInput"
                    class="scan-input"
                    placeholder="ex: google.com — 192.168.1.1 — https://example.com"
                    value="{{ old('target') }}"
                    required
                    autocomplete="off"
                />
                <button type="submit" class="btn-scan" id="scanBtn">SCANNER →</button>
            </div>
            <div class="form-hint">
                <span>URL complète</span>
                <span>Adresse IP</span>
                <span>Nom de domaine</span>
            </div>
        </form>

        @error('target')
            <div style="margin-top:12px;font-family:var(--font-mono);font-size:12px;color:#ff6688;">
                ⚠ {{ $message }}
            </div>
        @enderror
    </div>

    <!-- WAITING ANIMATION (shown when form submitted) -->
    <div class="waiting-box" id="waitingBox">
        <div class="scan-target-display">
            ANALYSE EN COURS → <span id="targetDisplay"></span>
        </div>

        <div class="progress-bar-wrap">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        <div class="terminal-output" id="terminalOutput">
            <span class="t-line green">> Initialisation du scanner...</span>
        </div>

        <div class="scan-status">
            <div class="spin"></div>
            <span id="statusText">Connexion à la cible...</span>
        </div>

        <div class="fun-fact-box">
            <span class="label">// SAVIEZ-VOUS ?</span>
            <span id="funFact">Le port 80 est le port HTTP standard, ouvert sur presque tous les serveurs web.</span>
        </div>
    </div>

    <!-- RECENT SCANS -->
    <div class="recent-title">// SCANS RÉCENTS</div>

    @if(isset($recentScans) && $recentScans->count() > 0)
        <div class="recent-list">
            @foreach($recentScans as $scan)
            <a href="{{ route('scan.show', $scan->id) }}" class="recent-item">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="status-dot dot-{{ $scan->status }}"></div>
                    <div class="recent-target">{{ $scan->target }}</div>
                </div>
                <div class="recent-meta">
                    @php $critical = $scan->findings->where('severity','critical')->count(); @endphp
                    @if($critical > 0)
                        <span class="sev-badge sev-critical">{{ $critical }} CRITICAL</span>
                    @endif
                    <span>{{ $scan->created_at->diffForHumans() }}</span>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            Aucun scan effectué. Lancez votre premier scan ci-dessus !
        </div>
    @endif
</div>

<script>
const facts = [
    "Le port 80 est le port HTTP standard ouvert sur presque tous les serveurs web.",
    "Le port 22 (SSH) est la cible de millions de tentatives de brute force chaque jour.",
    "Nmap a été créé en 1997 et reste l'outil de scan de ports le plus utilisé au monde.",
    "Le port 3389 (RDP) est souvent exploité pour les attaques de ransomware.",
    "80% des cyberattaques réussies exploitent des failles déjà connues et non corrigées.",
    "Le port 21 (FTP) transmet les données en clair — évitez-le en faveur de SFTP.",
    "Un scan des 100 ports les plus courants couvre 99% des services exposés sur internet.",
    "Le port 443 est HTTPS — les données sont chiffrées, contrairement au port 80.",
];

const messages = [
    { text: "> Résolution DNS de la cible...", color: "green", progress: 10 },
    { text: "> Connexion établie. Initialisation Nmap...", color: "blue", progress: 20 },
    { text: "> Scan des 100 ports les plus courants...", color: "green", progress: 35 },
    { text: "> Analyse des services détectés...", color: "blue", progress: 55 },
    { text: "> Identification des versions...", color: "yellow", progress: 70 },
    { text: "> Évaluation des niveaux de risque...", color: "green", progress: 85 },
    { text: "> Génération du rapport...", color: "blue", progress: 95 },
];

let factIndex = 0;

document.getElementById('scanForm').addEventListener('submit', function(e) {
    const target = document.getElementById('targetInput').value;
    if (!target) return;

    document.getElementById('targetDisplay').textContent = target;
    document.getElementById('waitingBox').classList.add('active');
    document.getElementById('scanBtn').disabled = true;
    document.getElementById('scanBtn').textContent = 'EN COURS...';

    // progress & terminal animation
    let msgIndex = 0;
    const terminal = document.getElementById('terminalOutput');
    const progressBar = document.getElementById('progressBar');
    const statusText = document.getElementById('statusText');

    const interval = setInterval(() => {
        if (msgIndex < messages.length) {
            const msg = messages[msgIndex];
            const line = document.createElement('span');
            line.className = `t-line ${msg.color}`;
            line.textContent = msg.text;
            terminal.appendChild(line);
            terminal.scrollTop = terminal.scrollHeight;
            progressBar.style.width = msg.progress + '%';
            statusText.textContent = msg.text.replace('> ', '');
            msgIndex++;
        }
    }, 1800);

    // fun facts rotation
    const factInterval = setInterval(() => {
        factIndex = (factIndex + 1) % facts.length;
        document.getElementById('funFact').textContent = facts[factIndex];
    }, 4000);
});
</script>

</body>
</html>