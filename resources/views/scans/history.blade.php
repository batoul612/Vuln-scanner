<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique — VulnScanner</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Exo+2:wght@300;400;600;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        body { background: var(--bg-dark); color: var(--text-primary); font-family: var(--font-body); min-height: 100vh; }
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
        .nav-link.active { color: var(--neon-green); }
        .user-badge { font-family: var(--font-mono); font-size: 12px; color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2); padding: 4px 12px; border-radius: 2px; }

        .main { position: relative; z-index: 1; max-width: 1100px; margin: 0 auto; padding: 50px 24px; }

        /* PAGE HEADER */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 40px; flex-wrap: wrap; gap: 16px;
        }
        .page-title-wrap .label { font-family: var(--font-mono); font-size: 11px; color: var(--neon-green); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 8px; }
        .page-title { font-family: var(--font-display); font-size: 36px; font-weight: 800; }

        .btn-new {
            font-family: var(--font-mono); font-size: 13px;
            background: var(--neon-green); color: var(--bg-dark);
            padding: 10px 24px; border-radius: 2px;
            text-decoration: none; font-weight: 700;
            letter-spacing: 1px; transition: all 0.3s;
            box-shadow: 0 0 20px rgba(0,255,136,0.3);
        }
        .btn-new:hover { box-shadow: 0 0 40px rgba(0,255,136,0.6); transform: translateY(-1px); }

        /* STATS ROW */
        .stats-row {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 12px; margin-bottom: 32px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.08);
            border-radius: 4px; padding: 16px 20px;
            display: flex; align-items: center; gap: 14px;
        }
        .stat-icon { font-size: 24px; }
        .stat-num { font-family: var(--font-mono); font-size: 24px; color: var(--neon-green); display: block; line-height: 1; }
        .stat-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

        /* FILTERS */
        .filters {
            display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .filter-btn {
            font-family: var(--font-mono); font-size: 11px;
            color: var(--text-muted); border: 1px solid rgba(255,255,255,0.06);
            background: var(--bg-card2); padding: 6px 14px; border-radius: 2px;
            cursor: pointer; transition: all 0.3s; letter-spacing: 1px;
        }
        .filter-btn:hover, .filter-btn.active { color: var(--neon-green); border-color: rgba(0,255,136,0.3); background: rgba(0,255,136,0.05); }

        /* TABLE */
        .table-wrap {
            background: var(--bg-card);
            border: 1px solid rgba(0,255,136,0.08);
            border-radius: 4px; overflow: hidden;
        }

        .table-head {
            display: grid;
            grid-template-columns: 60px 1fr 100px 120px 160px 100px 80px;
            gap: 0;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(0,255,136,0.08);
            background: rgba(0,255,136,0.02);
        }

        .th {
            font-family: var(--font-mono); font-size: 10px;
            color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table-row {
            display: grid;
            grid-template-columns: 60px 1fr 100px 120px 160px 100px 80px;
            gap: 0;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            align-items: center;
            text-decoration: none;
            color: var(--text-primary);
            transition: background 0.2s;
        }
        .table-row:last-child { border-bottom: none; }
        .table-row:hover { background: rgba(0,255,136,0.03); }

        .row-id { font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); }

        .row-target { font-family: var(--font-mono); font-size: 13px; color: var(--text-primary); }
        .row-target small { display: block; font-size: 10px; color: var(--text-muted); margin-top: 2px; text-transform: uppercase; }

        .type-badge {
            font-family: var(--font-mono); font-size: 10px;
            padding: 3px 8px; border-radius: 2px;
            background: rgba(0,212,255,0.08); color: var(--neon-blue);
            border: 1px solid rgba(0,212,255,0.15);
            display: inline-block;
        }

        .status-wrap { display: flex; align-items: center; gap: 8px; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .dot-completed { background: var(--neon-green); box-shadow: 0 0 6px var(--neon-green); }
        .dot-running   { background: var(--neon-blue); animation: blink 1.5s infinite; }
        .dot-pending   { background: var(--neon-yellow); }
        .dot-failed    { background: var(--neon-red); }
        @keyframes blink { 0%,100%{opacity:1}50%{opacity:0.3} }
        .status-text { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }

        .vulns-wrap { display: flex; gap: 4px; flex-wrap: wrap; }
        .v-badge { font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; }
        .v-critical { background: rgba(255,51,102,0.12); color: #ff6688; }
        .v-high     { background: rgba(255,140,0,0.12); color: #ffaa44; }
        .v-medium   { background: rgba(255,204,0,0.1);  color: #ffcc44; }
        .v-low      { background: rgba(0,255,136,0.08); color: var(--neon-green); }
        .v-none     { font-size: 11px; color: var(--text-muted); font-family: var(--font-mono); }

        .row-date { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); }

        .btn-view {
            font-family: var(--font-mono); font-size: 11px;
            color: var(--neon-green); border: 1px solid rgba(0,255,136,0.2);
            padding: 5px 12px; border-radius: 2px;
            text-decoration: none; transition: all 0.3s;
            display: inline-block;
        }
        .btn-view:hover { background: rgba(0,255,136,0.08); }

        /* EMPTY */
        .empty-state {
            text-align: center; padding: 80px 40px;
        }
        .empty-icon { font-size: 60px; margin-bottom: 20px; display: block; }
        .empty-title { font-family: var(--font-display); font-size: 24px; font-weight: 700; margin-bottom: 10px; }
        .empty-desc { font-size: 14px; color: var(--text-muted); margin-bottom: 30px; }

        /* PAGINATION */
        .pagination-wrap {
            display: flex; justify-content: center; gap: 6px;
            margin-top: 24px;
        }
        .pagination-wrap .page-link {
            font-family: var(--font-mono); font-size: 12px;
            color: var(--text-muted); border: 1px solid rgba(255,255,255,0.06);
            background: var(--bg-card); padding: 6px 12px; border-radius: 2px;
            text-decoration: none; transition: all 0.3s;
        }
        .pagination-wrap .page-link:hover,
        .pagination-wrap .page-link.active { color: var(--neon-green); border-color: rgba(0,255,136,0.3); }
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

    <div class="page-header">
        <div class="page-title-wrap">
            <div class="label">// HISTORIQUE</div>
            <div class="page-title">Vos scans passés</div>
        </div>
        <a href="{{ route('dashboard') }}" class="btn-new">+ NOUVEAU SCAN</a>
    </div>

    @php
        $totalScans    = $scans->total();
        $totalFindings = \App\Models\ScanFinding::whereIn('scan_id', \App\Models\Scan::where('user_id', auth()->id())->pluck('id'))->count();
        $criticalCount = \App\Models\ScanFinding::whereIn('scan_id', \App\Models\Scan::where('user_id', auth()->id())->pluck('id'))->where('severity','critical')->count();
        $completedCount= \App\Models\Scan::where('user_id', auth()->id())->where('status','completed')->count();
    @endphp

    <!-- STATS -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">🔍</div>
            <div>
                <span class="stat-num">{{ $totalScans }}</span>
                <span class="stat-label">Total scans</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div>
                <span class="stat-num" style="color:var(--neon-blue)">{{ $completedCount }}</span>
                <span class="stat-label">Terminés</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div>
                <span class="stat-num" style="color:#ffaa44">{{ $totalFindings }}</span>
                <span class="stat-label">Vulnérabilités</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔴</div>
            <div>
                <span class="stat-num" style="color:#ff6688">{{ $criticalCount }}</span>
                <span class="stat-label">Critiques</span>
            </div>
        </div>
    </div>

    @if($scans->count() > 0)

        <!-- TABLE -->
        <div class="table-wrap">
            <div class="table-head">
                <div class="th">#</div>
                <div class="th">Cible</div>
                <div class="th">Type</div>
                <div class="th">Statut</div>
                <div class="th">Vulnérabilités</div>
                <div class="th">Date</div>
                <div class="th"></div>
            </div>

            @foreach($scans as $scan)
            @php
                $c = $scan->findings->where('severity','critical')->count();
                $h = $scan->findings->where('severity','high')->count();
                $m = $scan->findings->where('severity','medium')->count();
                $l = $scan->findings->where('severity','low')->count();
            @endphp
            <a href="{{ route('scan.show', $scan->id) }}" class="table-row">
                <div class="row-id">#{{ $scan->id }}</div>
                <div class="row-target">
                    {{ $scan->target }}
                    <small>{{ $scan->type }}</small>
                </div>
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
                <div class="vulns-wrap">
                    @if($c > 0)<span class="v-badge v-critical">{{ $c }} CRIT</span>@endif
                    @if($h > 0)<span class="v-badge v-high">{{ $h }} HIGH</span>@endif
                    @if($m > 0)<span class="v-badge v-medium">{{ $m }} MED</span>@endif
                    @if($l > 0)<span class="v-badge v-low">{{ $l }} LOW</span>@endif
                    @if($c+$h+$m+$l === 0)<span class="v-none">Aucune</span>@endif
                </div>
                <div class="row-date">{{ $scan->created_at->format('d/m/y H:i') }}</div>
                <div><span class="btn-view">VOIR →</span></div>
            </a>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $scans->links() }}
        </div>

    @else
        <div class="table-wrap">
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <div class="empty-title">Aucun scan effectué</div>
                <div class="empty-desc">Lancez votre premier scan pour commencer à analyser des cibles.</div>
                <a href="{{ route('dashboard') }}" class="btn-new">LANCER UN SCAN</a>
            </div>
        </div>
    @endif

</div>
</body>
</html>