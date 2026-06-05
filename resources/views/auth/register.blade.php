<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — VulnScanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #00ff88; --neon-blue: #00d4ff; --neon-red: #ff3366;
            --bg-dark: #050a0e; --bg-card: #0a1520;
            --text-primary: #e8f4f8; --text-muted: #5a7a8a;
            --font-mono: 'Share Tech Mono', monospace;
            --font-display: 'Exo 2', sans-serif;
            --font-body: 'Rajdhani', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: var(--bg-dark); color: var(--text-primary);
            font-family: var(--font-body); min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        body::after {
            content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                linear-gradient(rgba(0,255,136,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,255,136,0.03) 1px, transparent 1px);
            background-size: 50px 50px; pointer-events: none; z-index: 0;
        }
        body::before {
            content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,0.05) 2px, rgba(0,0,0,0.05) 4px);
            pointer-events: none; z-index: 9999;
        }
        .glow-orb { position: fixed; border-radius: 50%; filter: blur(120px); pointer-events: none; }
        .orb1 { width: 400px; height: 400px; background: rgba(0,255,136,0.05); top: -100px; right: -100px; }
        .orb2 { width: 300px; height: 300px; background: rgba(0,212,255,0.05); bottom: -50px; left: -50px; }

        .container { position: relative; z-index: 1; width: 100%; max-width: 480px; padding: 24px; animation: fadeIn 0.6s ease; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

        .logo { font-family: var(--font-mono); font-size: 22px; color: var(--neon-green); text-shadow: 0 0 20px rgba(0,255,136,0.5); letter-spacing: 2px; text-align: center; margin-bottom: 8px; text-decoration: none; display: block; }
        .logo span { color: var(--neon-blue); }
        .tagline { text-align: center; font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); letter-spacing: 2px; margin-bottom: 40px; }

        .card { background: var(--bg-card); border: 1px solid rgba(0,255,136,0.15); border-radius: 4px; padding: 40px; position: relative; overflow: hidden; }
        .card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, var(--neon-blue), var(--neon-green), transparent); }

        .card-title { font-family: var(--font-display); font-size: 24px; font-weight: 700; margin-bottom: 6px; }
        .card-sub { font-size: 14px; color: var(--text-muted); margin-bottom: 32px; }

        .form-group { margin-bottom: 18px; }
        label { display: block; font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; background: rgba(0,255,136,0.03); border: 1px solid rgba(0,255,136,0.15);
            border-radius: 2px; padding: 12px 16px; color: var(--text-primary);
            font-family: var(--font-mono); font-size: 14px; transition: all 0.3s; outline: none;
        }
        input:focus { border-color: var(--neon-green); box-shadow: 0 0 20px rgba(0,255,136,0.1); background: rgba(0,255,136,0.05); }
        input::placeholder { color: var(--text-muted); }

        .error-msg { background: rgba(255,51,102,0.1); border: 1px solid rgba(255,51,102,0.3); border-radius: 2px; padding: 10px 14px; margin-bottom: 20px; font-size: 13px; color: #ff6688; font-family: var(--font-mono); }

        .btn-submit {
            width: 100%; background: var(--neon-green); color: var(--bg-dark); border: none;
            padding: 14px; font-family: var(--font-mono); font-size: 14px; font-weight: 700;
            letter-spacing: 2px; border-radius: 2px; cursor: pointer; transition: all 0.3s;
            box-shadow: 0 0 30px rgba(0,255,136,0.3); position: relative; overflow: hidden;
        }
        .btn-submit:hover { box-shadow: 0 0 50px rgba(0,255,136,0.6); transform: translateY(-1px); }

        .divider-text { display: flex; align-items: center; gap: 16px; margin: 24px 0; }
        .divider-text::before, .divider-text::after { content: ''; flex: 1; height: 1px; background: rgba(0,255,136,0.1); }
        .divider-text span { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }

        .login-link { text-align: center; font-size: 14px; color: var(--text-muted); }
        .login-link a { color: var(--neon-green); text-decoration: none; font-weight: 600; transition: all 0.3s; }
        .login-link a:hover { text-shadow: 0 0 10px rgba(0,255,136,0.5); }

        .back-link { display: block; text-align: center; margin-top: 24px; font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: var(--neon-green); }

        .strength-bar { height: 4px; border-radius: 2px; background: rgba(255,255,255,0.05); margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 2px; width: 0%; transition: all 0.3s; }
        .strength-text { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); margin-top: 4px; }
    </style>
</head>
<body>
<div class="glow-orb orb1"></div>
<div class="glow-orb orb2"></div>

<div class="container">
    <a href="/" class="logo">VULN<span>SCANNER</span></a>
    <div class="tagline">// CRÉEZ VOTRE COMPTE SÉCURISÉ</div>

    <div class="card">
        <div class="card-title">Inscription</div>
        <div class="card-sub">Rejoignez VulnScanner et protégez votre présence en ligne</div>

        @if ($errors->any())
            <div class="error-msg">⚠ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" placeholder="Jean Dupont" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" id="passwordInput" placeholder="••••••••" required>
                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                <div class="strength-text" id="strengthText"></div>
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">[ CRÉER MON COMPTE ]</button>
        </form>

        <div class="divider-text"><span>ou</span></div>

        <div class="login-link">
            Déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>

    <a href="/" class="back-link">← Retour à l'accueil</a>
</div>

<script>
document.getElementById('passwordInput').addEventListener('input', function() {
    const val = this.value;
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const colors = ['#ff3366','#ff8c00','#ffcc00','#00ff88'];
    const labels = ['Faible','Moyen','Bien','Fort'];
    fill.style.width = (strength * 25) + '%';
    fill.style.background = colors[strength - 1] || '#333';
    text.textContent = val.length > 0 ? '// Force : ' + (labels[strength - 1] || '...') : '';
});
</script>
</body>
</html>