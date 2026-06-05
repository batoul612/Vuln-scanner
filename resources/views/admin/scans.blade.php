<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les scans — Admin VulnScanner</title>
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
        body::before { content: ''; position: fixed; inset: 0; background-image: linear-gradient(rgba(0,255,136,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(0,255,136,0.02) 1px, transparent 1px); background-size: 50px 50px; pointer-events: none; z-index: 0; }

        /* SIDEBAR */
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

        /* MAIN */
        .main { margin-left: 240px; flex: 1; position: relative; z-index: 1; padding: 40px; }

        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; }
        .page-label { font-family: var(--font-mono); font-size: 11px; color: var(--neon-purple); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 6px; }
        .page-title { font-family: var(--font-display); font-size: 32px; font-weight: 800; }
        .total-badge { font-family: var(--font-mono); font-size: 13px; color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2); padding: 8px 20px; border-radius: 2px; }

        /* FILTERS */
        .filter-box {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.08);
            border-radius: 4px; padding: 20px 24px;
            margin-bottom: 24px;
        }
        .filter-label { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 14px; }
        .filter-row { display: flex; gap: 12px; flex-wrap: wrap; }

        .filter-input {
            background: rgba(0,255,136,0.03);
            border: 1px solid rgba(0,255,136,0.1);
            border-radius: 2px; padding: 8px 14px;
            color: var(--text-primary); font-family: var(--font-mono);
            font-size: 12px; outline: none; transition: all 0.3s;
        }
        .filter-input:focus { border-color: var(--neon-green); }
        .filter-input::placeholder { color: var(--text-muted); }
        .filter-input option { background: var(--bg-card2); }

        .btn-filter {
            background: var(--neon-green); color: var(--bg-dark);
            border: none; padding: 8px 20px; font-family: var(--font-mono);
            font-size: 12px; font-weight: 700; border-radius: 2px;
            cursor: pointer; letter-spacing: 1px; transition: all 0.3s;
        }
        .btn-filter:hover { box-shadow: 0 0 20px rgba(0,255,136,0.4); }

        .btn-reset {
            background: none; color: var(--text-muted);
            border: 1px solid rgba(255,255,255,0.06);
            padding: 8px 16px; font-family: var(--font-mono);
            font-size: 12px; border-radius: 2px; cursor: pointer;
            transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center;
        }
        .btn-reset:hover { color: var(--neon-red); border-color: rgba(255,51,102,0.2); }

        /* TABLE */
        .table-wrap { background: var(--bg-card); border: 1px solid rgba(0,255,136,0.08); border-radius: 4px; overflow: hidden; }
        .table-head { display: grid; grid-template-columns: 50px 1fr 160px 100px 100px 160px 80px 80px; padding: 12px 20px; border-bottom: 1px solid rgba(0,255,136,0.06); background: rgba(0,255,136,0.02); }
        .th { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
        .table-row { display: grid; grid-template-columns: 50px 1fr 160px 100px 100px 160px 80px 80px; padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.02); align-items: center; text-decoration: none; color: var(--text-primary); transition: background 0.2s; }
        .table-row:last-child { border-bottom: none; }
        .table-row:hover { background: rgba(0,255,136,0.02); }

        .cell-id { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }
        .cell-target { font-family: var(--font-mono); font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .cell-user { font-family: var(--font-mono); font-size: 11px; color: var(--neon-blue); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .cell-date { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }

        .type-badge { font-family: var(--font-mono); font-size: 10px; padding: 2px 8px; border-radius: 2px; background: rgba(0,212,255,0.08); color: var(--neon-blue); border: 1px solid rgba(0,212,255,0.15); display: inline-block; }

        .status-wrap { display: flex; align-items: center; gap: 6px; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .dot-completed { background: var(--neon-green); box-shadow: 0 0 6px var(--neon-green); }
        .dot-running { background: var(--neon-blue); animation: blink 1.5s infinite; }
        .dot-pending { background: var(--neon-yellow); }
        .dot-failed { background: var(--neon-red); }
        @keyframes blink { 0%,100%{opacity:1}50%{opacity:0.3} }
        .status-text { font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); }

        .v-badge { font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; }
        .v-critical { background: rgba(255,51,102,0.12); color: #ff6688; }
        .v-high { background: rgba(255,140,0,0.12); color: #ffaa44; }
        .v-none { color: var(--text-muted); font-size: 11px; font-family: var(--font-mono); }

        .btn-view { font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2); padding: 4px 10px; border-radius: 2px; text-decoration: none; transition: all 0.3s; display: inline-block; }
        .btn-view:hover { background: rgba(0,255,136,0.08); }

        .empty-state { text-align: center; padding: 60px; }
        .empty-state p { font-family: var(--font-mono); font-size: 13px; color: var(--text-muted); }

        .pagination-wrap { display: flex; justify-content: center; gap: 6px; margin-top: 20px; }
        .page-link { font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.06); background: var(--bg-card); padding: 6px 12px; border-radius: 2px; text-decoration: none; transition: all 0.3s; }
        .page-link:hover { color: var(--neon-green); border-color: rgba(0,255,136,0.3); }
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="icon">📊</span> Dashboard</a>
        <a href="{{ route('admin.scans') }}" class="nav-item active"><span class="icon">🔍</span> Tous les scans</a>
        <a href="{{ route('admin.users') }}" class="nav-item"><span class="icon">👥</span> Utilisateurs</a>
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

<!-- MAIN -->
<main class="main">

    <div class="topbar">
        <div>
            <div class="page-label">// ADMIN PANEL</div>
            <div class="page-title">Tous les scans</div>
        </div>
        <div class="total-badge">{{ $scans->total() }} scan(s) au total</div>
    </div>

    <!-- FILTERS -->
    <div class="filter-box">
        <div class="filter-label">// FILTRER LES SCANS</div>
        <form method="GET" action="{{ route('admin.scans') }}">
            <div class="filter-row">
                <input type="text" name="search" class="filter-input" placeholder="Rechercher une cible..." value="{{ request('search') }}" style="flex:1;min-width:200px;">
                <select name="user_id" class="filter-input">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <select name="status" class="filter-input">
                    <option value="">Tous les statuts</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminé</option>
                    <option value="running"   {{ request('status') === 'running'   ? 'selected' : '' }}>En cours</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
                    <option value="failed"    {{ request('status') === 'failed'    ? 'selected' : '' }}>Échec</option>
                </select>
                <button type="submit" class="btn-filter">FILTRER</button>
                <a href="{{ route('admin.scans') }}" class="btn-reset">RESET</a>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="table-wrap">
        <div class="table-head">
            <div class="th">#</div>
            <div class="th">Cible</div>
            <div class="th">Utilisateur</div>
            <div class="th">Type</div>
            <div class="th">Statut</div>
            <div class="th">Vulnérabilités</div>
            <div class="th">Date</div>
            <div class="th"></div>
        </div>

        @forelse($scans as $scan)
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
            <div class="status-wrap">
                <div class="status-dot dot-{{ $scan->status }}"></div>
                <span class="status-text">
                    @if($scan->status==='completed') Terminé
                    @elseif($scan->status==='running') En cours
                    @elseif($scan->status==='pending') En attente
                    @else Échec @endif
                </span>
            </div>
            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                @if($c > 0)<span class="v-badge v-critical">{{ $c }} CRIT</span>@endif
                @if($h > 0)<span class="v-badge v-high">{{ $h }} HIGH</span>@endif
                @if($c+$h+$m+$l === 0)<span class="v-none">Aucune</span>@endif
            </div>
            <div class="cell-date">{{ $scan->created_at->format('d/m/y H:i') }}</div>
            <div><span class="btn-view">VOIR →</span></div>
        </a>
        @empty
        <div class="empty-state">
            <p>Aucun scan trouvé avec ces filtres.</p>
        </div>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $scans->appends(request()->query())->links() }}
    </div>

</main>
</body>
</html>