<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — VulnScanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #00ff88; --neon-blue: #00d4ff; --neon-red: #ff3366;
            --neon-yellow: #ffcc00; --neon-orange: #ff8c00; --neon-purple: #aa44ff;
            --bg-dark: #050a0e; --bg-card: #0a1520; --bg-card2: #0d1f2d;
            --text-primary: #e8f4f8; --text-muted: #5a7a8a;
            --font-mono: 'Share Tech Mono', monospace;
            --font-display: 'Exo 2', sans-serif;
            --font-body: 'Rajdhani', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--bg-dark); color: var(--text-primary); font-family: var(--font-body); min-height: 100vh; display: flex; }

        body::before {
            content: ''; position: fixed; inset: 0;
            background-image: linear-gradient(rgba(0,255,136,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(0,255,136,0.02) 1px, transparent 1px);
            background-size: 50px 50px; pointer-events: none; z-index: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px; min-height: 100vh;
            background: rgba(10,21,32,0.95);
            border-right: 1px solid rgba(0,255,136,0.08);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(0,255,136,0.08);
        }

        .logo-text { font-family: var(--font-mono); font-size: 16px; color: var(--neon-green); letter-spacing: 2px; text-decoration: none; display: block; }
        .logo-text span { color: var(--neon-blue); }
        .admin-badge { font-family: var(--font-mono); font-size: 10px; color: var(--neon-purple); border: 1px solid rgba(170,68,255,0.3); padding: 2px 8px; border-radius: 2px; margin-top: 6px; display: inline-block; letter-spacing: 1px; }

        .sidebar-nav { flex: 1; padding: 20px 0; }

        .nav-section { font-family: var(--font-mono); font-size: 9px; color: var(--text-muted); letter-spacing: 3px; text-transform: uppercase; padding: 0 20px; margin: 16px 0 8px; }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px; font-family: var(--font-mono);
            font-size: 12px; color: var(--text-muted);
            text-decoration: none; transition: all 0.2s;
            border-left: 2px solid transparent;
        }
        .nav-item:hover { color: var(--neon-green); background: rgba(0,255,136,0.03); border-left-color: rgba(0,255,136,0.3); }
        .nav-item.active { color: var(--neon-green); background: rgba(0,255,136,0.05); border-left-color: var(--neon-green); }
        .nav-item .icon { font-size: 14px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(0,255,136,0.08);
        }

        .user-info { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); margin-bottom: 10px; }
        .user-info strong { color: var(--neon-green); display: block; font-size: 12px; }

        .btn-logout { width: 100%; background: none; border: 1px solid rgba(255,51,102,0.2); color: var(--neon-red); font-family: var(--font-mono); font-size: 11px; padding: 7px; border-radius: 2px; cursor: pointer; transition: all 0.3s; letter-spacing: 1px; }
        .btn-logout:hover { background: rgba(255,51,102,0.08); }

        /* MAIN */
        .main { margin-left: 240px; flex: 1; position: relative; z-index: 1; padding: 40px; }

        /* TOP BAR */
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; }
        .page-label { font-family: var(--font-mono); font-size: 11px; color: var(--neon-purple); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 6px; }
        .page-title { font-family: var(--font-display); font-size: 32px; font-weight: 800; }

        .live-badge { display: flex; align-items: center; gap: 8px; font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2); padding: 6px 14px; border-radius: 2px; background: rgba(0,255,136,0.03); }
        .pulse { width: 8px; height: 8px; border-radius: 50%; background: var(--neon-green); box-shadow: 0 0 8px var(--neon-green); animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.8)} }

        /* STATS */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 4px; padding: 24px;
            position: relative; overflow: hidden;
            transition: all 0.3s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
        .stat-card.s1::before { background: linear-gradient(90deg, var(--neon-blue), transparent); }
        .stat-card.s2::before { background: linear-gradient(90deg, var(--neon-green), transparent); }
        .stat-card.s3::before { background: linear-gradient(90deg, var(--neon-orange), transparent); }
        .stat-card.s4::before { background: linear-gradient(90deg, var(--neon-red), transparent); }

        .stat-icon { font-size: 28px; margin-bottom: 12px; display: block; }
        .stat-num { font-family: var(--font-mono); font-size: 36px; display: block; line-height: 1; margin-bottom: 6px; }
        .s1 .stat-num { color: var(--neon-blue); text-shadow: 0 0 20px rgba(0,212,255,0.4); }
        .s2 .stat-num { color: var(--neon-green); text-shadow: 0 0 20px rgba(0,255,136,0.4); }
        .s3 .stat-num { color: var(--neon-orange); text-shadow: 0 0 20px rgba(255,140,0,0.4); }
        .s4 .stat-num { color: var(--neon-red); text-shadow: 0 0 20px rgba(255,51,102,0.4); }
        .stat-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

        /* GRID 2 COL */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px; }

        /* CARD */
        .card { background: var(--bg-card); border: 1px solid rgba(0,255,136,0.08); border-radius: 4px; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid rgba(0,255,136,0.06); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase; }
        .card-link { font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); text-decoration: none; transition: opacity 0.3s; }
        .card-link:hover { opacity: 0.7; }
        .card-body { padding: 20px; }

        /* RECENT SCANS TABLE */
        .scan-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.03); gap: 12px; }
        .scan-row:last-child { border-bottom: none; }

        .scan-user { font-family: var(--font-mono); font-size: 11px; color: var(--neon-blue); }
        .scan-target { font-family: var(--font-mono); font-size: 12px; color: var(--text-primary); }
        .scan-time { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); }

        .status-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .dot-completed { background: var(--neon-green); box-shadow: 0 0 6px var(--neon-green); }
        .dot-running { background: var(--neon-blue); animation: blink 1.5s infinite; }
        .dot-pending { background: var(--neon-yellow); }
        .dot-failed { background: var(--neon-red); }
        @keyframes blink { 0%,100%{opacity:1}50%{opacity:0.3} }

        .v-badge { font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; }
        .v-critical { background: rgba(255,51,102,0.12); color: #ff6688; }
        .v-high { background: rgba(255,140,0,0.12); color: #ffaa44; }
        .v-none { color: var(--text-muted); font-size: 11px; font-family: var(--font-mono); }

        /* TOP USERS */
        .user-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.03); }
        .user-row:last-child { border-bottom: none; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: rgba(0,255,136,0.1); border: 1px solid rgba(0,255,136,0.2); display: flex; align-items: center; justify-content: center; font-family: var(--font-mono); font-size: 12px; color: var(--neon-green); flex-shrink: 0; }
        .user-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .user-email { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); }
        .user-scans { font-family: var(--font-mono); font-size: 12px; color: var(--neon-blue); margin-left: auto; }

        /* FULL WIDTH TABLE */
        .full-card { background: var(--bg-card); border: 1px solid rgba(0,255,136,0.08); border-radius: 4px; overflow: hidden; }
        .table-head { display: grid; grid-template-columns: 50px 1fr 140px 100px 150px 80px 80px; padding: 12px 20px; border-bottom: 1px solid rgba(0,255,136,0.06); background: rgba(0,255,136,0.02); }
        .th { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
        .table-row { display: grid; grid-template-columns: 50px 1fr 140px 100px 150px 80px 80px; padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.02); align-items: center; text-decoration: none; color: var(--text-primary); transition: background 0.2s; }
        .table-row:hover { background: rgba(0,255,136,0.02); }
        .table-row:last-child { border-bottom: none; }
        .cell-id { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }
        .cell-target { font-family: var(--font-mono); font-size: 12px; }
        .cell-user { font-family: var(--font-mono); font-size: 11px; color: var(--neon-blue); }
        .cell-date { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }
        .btn-view { font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2); padding: 4px 10px; border-radius: 2px; text-decoration: none; transition: all 0.3s; display: inline-block; }
        .btn-view:hover { background: rgba(0,255,136,0.08); }

        .type-badge { font-family: var(--font-mono); font-size: 10px; padding: 2px 8px; border-radius: 2px; background: rgba(0,212,255,0.08); color: var(--neon-blue); border: 1px solid rgba(0,212,255,0.15); display: inline-block; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="/" class="logo-text">VULN<span>SCANNER</span></a>
        <span class="admin-badge">ADMIN PANEL</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">// ADMIN</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.scans') }}" class="nav-item">
            <span class="icon">🔍</span> Tous les scans
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item">
            <span class="icon">👥</span> Utilisateurs
        </a>

        <div class="nav-section">// UTILISATEUR</div>
        <a href="{{ route('dashboard') }}" class="nav-item">
            <span class="icon">⚡</span> Mon scanner
        </a>
        <a href="{{ route('scan.history') }}" class="nav-item">
            <span class="icon">📋</span> Mon historique
        </a>
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

<!-- MAIN -->
<main class="main">

    <div class="topbar">
        <div>
            <div class="page-label">// ADMIN PANEL</div>
            <div class="page-title">Vue d'ensemble</div>
        </div>
        <div class="live-badge">
            <div class="pulse"></div>
            SYSTÈME ACTIF
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card s1">
            <span class="stat-icon">👥</span>
            <span class="stat-num">{{ $totalUsers }}</span>
            <span class="stat-label">Utilisateurs</span>
        </div>
        <div class="stat-card s2">
            <span class="stat-icon">🔍</span>
            <span class="stat-num">{{ $totalScans }}</span>
            <span class="stat-label">Scans total</span>
        </div>
        <div class="stat-card s3">
            <span class="stat-icon">⚠️</span>
            <span class="stat-num">{{ $totalFindings }}</span>
            <span class="stat-label">Vulnérabilités</span>
        </div>
        <div class="stat-card s4">
            <span class="stat-icon">🔴</span>
            <span class="stat-num">{{ $criticalCount }}</span>
            <span class="stat-label">Critiques</span>
        </div>
    </div>

    <!-- 2 COL -->
    <div class="grid-2">
        <!-- RECENT SCANS -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">// Scans récents</span>
                <a href="{{ route('admin.scans') }}" class="card-link">Voir tout →</a>
            </div>
            <div class="card-body">
                @foreach($recentScans as $scan)
                @php
                    $c = $scan->findings->where('severity','critical')->count();
                    $h = $scan->findings->where('severity','high')->count();
                @endphp
                <div class="scan-row">
                    <div class="status-dot dot-{{ $scan->status }}"></div>
                    <div style="flex:1;min-width:0;">
                        <div class="scan-target" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $scan->target }}</div>
                        <div class="scan-user">{{ $scan->user->email ?? 'N/A' }}</div>
                    </div>
                    <div style="display:flex;gap:4px;flex-shrink:0;">
                        @if($c > 0)<span class="v-badge v-critical">{{ $c }} CRIT</span>@endif
                        @if($h > 0)<span class="v-badge v-high">{{ $h }} HIGH</span>@endif
                        @if($c+$h === 0)<span class="v-none">–</span>@endif
                    </div>
                    <div class="scan-time">{{ $scan->created_at->diffForHumans() }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TOP USERS -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">// Top utilisateurs</span>
                <a href="{{ route('admin.users') }}" class="card-link">Voir tout →</a>
            </div>
            <div class="card-body">
                @foreach(\App\Models\User::withCount('scans')->orderBy('scans_count','desc')->take(6)->get() as $user)
                <div class="user-row">
                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                    </div>
                    <div class="user-scans">{{ $user->scans_count }} scans</div>
                    @if($user->isAdmin())
                        <span style="font-family:var(--font-mono);font-size:9px;color:var(--neon-purple);border:1px solid rgba(170,68,255,0.3);padding:2px 6px;border-radius:2px;">ADMIN</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ALL RECENT SCANS TABLE -->
    <div class="full-card">
        <div class="card-header" style="padding:16px 20px;border-bottom:1px solid rgba(0,255,136,0.06);display:flex;align-items:center;justify-content:space-between;">
            <span class="card-title">// Derniers scans — tous utilisateurs</span>
            <a href="{{ route('admin.scans') }}" class="card-link">Voir tout →</a>
        </div>
        <div class="table-head">
            <div class="th">#</div>
            <div class="th">Cible</div>
            <div class="th">Utilisateur</div>
            <div class="th">Type</div>
            <div class="th">Vulnérabilités</div>
            <div class="th">Date</div>
            <div class="th"></div>
        </div>
        @foreach($recentScans as $scan)
        @php
            $c = $scan->findings->where('severity','critical')->count();
            $h = $scan->findings->where('severity','high')->count();
            $m = $scan->findings->where('severity','medium')->count();
            $l = $scan->findings->where('severity','low')->count();
        @endphp
        <a href="{{ route('scan.show', $scan->id) }}" class="table-row">
            <div class="cell-id">#{{ $scan->id }}</div>
            <div class="cell-target">{{ $scan->target }}</div>
            <div class="cell-user">{{ $scan->user->email ?? 'N/A' }}</div>
            <div><span class="type-badge">{{ strtoupper($scan->type) }}</span></div>
            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                @if($c > 0)<span class="v-badge v-critical">{{ $c }}C</span>@endif
                @if($h > 0)<span class="v-badge v-high">{{ $h }}H</span>@endif
                @if($c+$h+$m+$l === 0)<span class="v-none">–</span>@endif
            </div>
            <div class="cell-date">{{ $scan->created_at->format('d/m/y H:i') }}</div>
            <div><span class="btn-view">VOIR →</span></div>
        </a>
        @endforeach
    </div>

</main>

</body>
</html>