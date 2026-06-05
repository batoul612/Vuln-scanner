<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs — Admin VulnScanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #00ff88; --neon-blue: #00d4ff; --neon-red: #ff3366;
            --neon-yellow: #ffcc00; --neon-purple: #aa44ff;
            --bg-dark: #050a0e; --bg-card: #0a1520; --bg-card2: #0d1f2d;
            --text-primary: #e8f4f8; --text-muted: #5a7a8a;
            --font-mono: 'Share Tech Mono', monospace;
            --font-display: 'Exo 2', sans-serif;
            --font-body: 'Rajdhani', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--bg-dark); color: var(--text-primary); font-family: var(--font-body); min-height: 100vh; display: flex; }
        body::before { content: ''; position: fixed; inset: 0; background-image: linear-gradient(rgba(0,255,136,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(0,255,136,0.02) 1px, transparent 1px); background-size: 50px 50px; pointer-events: none; z-index: 0; }

        .sidebar { width: 240px; min-height: 100vh; background: rgba(10,21,32,0.95); border-right: 1px solid rgba(0,255,136,0.08); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(0,255,136,0.08); }
        .logo-text { font-family: var(--font-mono); font-size: 16px; color: var(--neon-green); letter-spacing: 2px; text-decoration: none; display: block; }
        .logo-text span { color: var(--neon-blue); }
        .admin-badge { font-family: var(--font-mono); font-size: 10px; color: var(--neon-purple); border: 1px solid rgba(170,68,255,0.3); padding: 2px 8px; border-radius: 2px; margin-top: 6px; display: inline-block; letter-spacing: 1px; }
        .sidebar-nav { flex: 1; padding: 20px 0; }
        .nav-section { font-family: var(--font-mono); font-size: 9px; color: var(--text-muted); letter-spacing: 3px; text-transform: uppercase; padding: 0 20px; margin: 16px 0 8px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); text-decoration: none; transition: all 0.2s; border-left: 2px solid transparent; }
        .nav-item:hover { color: var(--neon-green); background: rgba(0,255,136,0.03); border-left-color: rgba(0,255,136,0.3); }
        .nav-item.active { color: var(--neon-green); background: rgba(0,255,136,0.05); border-left-color: var(--neon-green); }
        .nav-item .icon { font-size: 14px; width: 20px; text-align: center; }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(0,255,136,0.08); }
        .user-info { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); margin-bottom: 10px; }
        .user-info strong { color: var(--neon-green); display: block; font-size: 12px; }
        .btn-logout { width: 100%; background: none; border: 1px solid rgba(255,51,102,0.2); color: var(--neon-red); font-family: var(--font-mono); font-size: 11px; padding: 7px; border-radius: 2px; cursor: pointer; transition: all 0.3s; letter-spacing: 1px; }
        .btn-logout:hover { background: rgba(255,51,102,0.08); }

        .main { margin-left: 240px; flex: 1; position: relative; z-index: 1; padding: 40px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; }
        .page-label { font-family: var(--font-mono); font-size: 11px; color: var(--neon-purple); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 6px; }
        .page-title { font-family: var(--font-display); font-size: 32px; font-weight: 800; }
        .total-badge { font-family: var(--font-mono); font-size: 13px; color: var(--neon-blue); border: 1px solid rgba(0,212,255,0.2); padding: 8px 20px; border-radius: 2px; }

        /* USERS GRID */
        .users-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; margin-bottom: 40px; }

        .user-card {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.08);
            border-radius: 4px; padding: 24px;
            transition: all 0.3s; position: relative; overflow: hidden;
        }
        .user-card:hover { border-color: rgba(0,255,136,0.2); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .user-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, var(--neon-green), transparent); opacity: 0; transition: opacity 0.3s; }
        .user-card:hover::before { opacity: 1; }

        .user-card-header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
        .avatar { width: 44px; height: 44px; border-radius: 50%; background: rgba(0,255,136,0.08); border: 2px solid rgba(0,255,136,0.2); display: flex; align-items: center; justify-content: center; font-family: var(--font-mono); font-size: 18px; color: var(--neon-green); flex-shrink: 0; }
        .avatar.admin-av { background: rgba(170,68,255,0.08); border-color: rgba(170,68,255,0.3); color: var(--neon-purple); }

        .user-name-wrap { flex: 1; min-width: 0; }
        .uname { font-family: var(--font-display); font-size: 16px; font-weight: 700; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .uemail { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .role-badge { font-family: var(--font-mono); font-size: 10px; padding: 3px 8px; border-radius: 2px; flex-shrink: 0; }
        .role-admin { background: rgba(170,68,255,0.12); color: var(--neon-purple); border: 1px solid rgba(170,68,255,0.3); }
        .role-user  { background: rgba(0,212,255,0.08); color: var(--neon-blue); border: 1px solid rgba(0,212,255,0.2); }

        .user-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 16px; }
        .ustat { background: var(--bg-card2); border-radius: 2px; padding: 10px; text-align: center; }
        .ustat-num { font-family: var(--font-mono); font-size: 18px; color: var(--neon-green); display: block; line-height: 1; }
        .ustat-label { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

        .user-footer { display: flex; align-items: center; justify-content: space-between; }
        .joined { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); }

        .btn-view-scans { font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2); padding: 5px 12px; border-radius: 2px; text-decoration: none; transition: all 0.3s; }
        .btn-view-scans:hover { background: rgba(0,255,136,0.08); }

        .last-scan { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); margin-top: 8px; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.04); }
        .last-scan span { color: var(--neon-blue); }

        .pagination-wrap { display: flex; justify-content: center; gap: 6px; margin-top: 20px; }
        .page-link { font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.06); background: var(--bg-card); padding: 6px 12px; border-radius: 2px; text-decoration: none; transition: all 0.3s; }
        .page-link:hover { color: var(--neon-green); border-color: rgba(0,255,136,0.3); }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="/" class="logo-text">VULN<span>SCANNER</span></a>
        <span class="admin-badge">ADMIN PANEL</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">// ADMIN</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="icon">📊</span> Dashboard</a>
        <a href="{{ route('admin.scans') }}" class="nav-item"><span class="icon">🔍</span> Tous les scans</a>
        <a href="{{ route('admin.users') }}" class="nav-item active"><span class="icon">👥</span> Utilisateurs</a>
        <div class="nav-section">// UTILISATEUR</div>
        <a href="{{ route('dashboard') }}" class="nav-item"><span class="icon">⚡</span> Mon scanner</a>
        <a href="{{ route('scan.history') }}" class="nav-item"><span class="icon">📋</span> Mon historique</a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <strong>{{ auth()->user()->name }}</strong>
            {{ auth()->user()->email }}
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">[ DÉCONNEXION ]</button>
        </form>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <div class="page-label">// ADMIN PANEL</div>
            <div class="page-title">Utilisateurs</div>
        </div>
        <div class="total-badge">{{ $users->total() }} utilisateur(s)</div>
    </div>

    <div class="users-grid">
        @foreach($users as $user)
        @php
            $userFindings = \App\Models\ScanFinding::whereIn('scan_id', $user->scans->pluck('id'))->count();
            $userCritical = \App\Models\ScanFinding::whereIn('scan_id', $user->scans->pluck('id'))->where('severity','critical')->count();
            $lastScan = $user->scans->first();
        @endphp
        <div class="user-card">
            <div class="user-card-header">
                <div class="avatar {{ $user->isAdmin() ? 'admin-av' : '' }}">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-name-wrap">
                    <div class="uname">{{ $user->name }}</div>
                    <div class="uemail">{{ $user->email }}</div>
                </div>
                <span class="role-badge {{ $user->isAdmin() ? 'role-admin' : 'role-user' }}">
                    {{ $user->isAdmin() ? 'ADMIN' : 'USER' }}
                </span>
            </div>

            <div class="user-stats">
                <div class="ustat">
                    <span class="ustat-num">{{ $user->scans_count }}</span>
                    <span class="ustat-label">Scans</span>
                </div>
                <div class="ustat">
                    <span class="ustat-num" style="color:#ffaa44">{{ $userFindings }}</span>
                    <span class="ustat-label">Vulnér.</span>
                </div>
                <div class="ustat">
                    <span class="ustat-num" style="color:#ff6688">{{ $userCritical }}</span>
                    <span class="ustat-label">Critiques</span>
                </div>
            </div>

            @if($lastScan)
            <div class="last-scan">
                Dernier scan : <span>{{ $lastScan->target }}</span> — {{ $lastScan->created_at->diffForHumans() }}
            </div>
            @endif

            <div class="user-footer" style="margin-top:12px;">
                <div class="joined">Inscrit {{ $user->created_at->diffForHumans() }}</div>
                <a href="{{ route('admin.scans') }}?user_id={{ $user->id }}" class="btn-view-scans">VOIR SCANS →</a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>
</main>

</body>
</html>