<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — VulnScanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #00ff88;
            --neon-blue: #00d4ff;
            --neon-red: #ff3366;
            --bg-dark: #050a0e;
            --bg-card: #0a1520;
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* grid bg */
        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                linear-gradient(rgba(0,255,136,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,255,136,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        /* scanline */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: repeating-linear-gradient(
                0deg, transparent, transparent 2px,
                rgba(0,0,0,0.05) 2px, rgba(0,0,0,0.05) 4px
            );
            pointer-events: none;
            z-index: 9999;
        }

        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
        }

        .orb1 {
            width: 400px; height: 400px;
            background: rgba(0,255,136,0.06);
            top: -100px; left: -100px;
        }

        .orb2 {
            width: 300px; height: 300px;
            background: rgba(0,212,255,0.06);
            bottom: -50px; right: -50px;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 24px;
        }

        .logo {
            font-family: var(--font-mono);
            font-size: 22px;
            color: var(--neon-green);
            text-shadow: 0 0 20px rgba(0,255,136,0.5);
            letter-spacing: 2px;
            text-align: center;
            margin-bottom: 8px;
            text-decoration: none;
            display: block;
        }

        .logo span { color: var(--neon-blue); }

        .tagline {
            text-align: center;
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 2px;
            margin-bottom: 40px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.15);
            border-radius: 4px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-green), var(--neon-blue), transparent);
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card-sub {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--neon-green);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: rgba(0,255,136,0.03);
            border: 1px solid rgba(0,255,136,0.15);
            border-radius: 2px;
            padding: 12px 16px;
            color: var(--text-primary);
            font-family: var(--font-mono);
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }

        input:focus {
            border-color: var(--neon-green);
            box-shadow: 0 0 20px rgba(0,255,136,0.1);
            background: rgba(0,255,136,0.05);
        }

        input::placeholder { color: var(--text-muted); }

        .checkbox-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
        }

        input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: var(--neon-green);
        }

        .forgot-link {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--neon-blue);
            text-decoration: none;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .forgot-link:hover { opacity: 1; }

        .btn-submit {
            width: 100%;
            background: var(--neon-green);
            color: var(--bg-dark);
            border: none;
            padding: 14px;
            font-family: var(--font-mono);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 0 30px rgba(0,255,136,0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover {
            box-shadow: 0 0 50px rgba(0,255,136,0.6);
            transform: translateY(-1px);
        }

        .btn-submit:hover::before { left: 100%; }

        .divider-text {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0,255,136,0.1);
        }

        .divider-text span {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text-muted);
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }

        .register-link a {
            color: var(--neon-green);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .register-link a:hover {
            text-shadow: 0 0 10px rgba(0,255,136,0.5);
        }

        .error-msg {
            background: rgba(255,51,102,0.1);
            border: 1px solid rgba(255,51,102,0.3);
            border-radius: 2px;
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #ff6688;
            font-family: var(--font-mono);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-link:hover { color: var(--neon-green); }

        /* animation */
        .container { animation: fadeIn 0.6s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="glow-orb orb1"></div>
<div class="glow-orb orb2"></div>

<div class="container">
    <a href="/" class="logo">VULN<span>SCANNER</span></a>
    <div class="tagline">// SYSTÈME D'ANALYSE DE VULNÉRABILITÉS</div>

    <div class="card">
        <div class="card-title">Connexion</div>
        <div class="card-sub">Accédez à votre espace de scan sécurisé</div>

        @if ($errors->any())
            <div class="error-msg">
                ⚠ {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="votre@email.com"
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="checkbox-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">[ CONNEXION ]</button>
        </form>

        <div class="divider-text"><span>ou</span></div>

        <div class="register-link">
            Pas encore de compte ?
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>

    <a href="/" class="back-link">← Retour à l'accueil</a>
</div>
</body>
</html>