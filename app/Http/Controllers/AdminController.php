<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\User;
use App\Models\ScanFinding;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers    = User::count();
        $totalScans    = Scan::count();
        $totalFindings = ScanFinding::count();
        $criticalCount = ScanFinding::where('severity', 'critical')->count();

        $recentScans = Scan::with(['user', 'findings'])
                           ->latest()
                           ->take(5)
                           ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalScans',
            'totalFindings',
            'criticalCount',
            'recentScans'
        ));
    }

    public function scans(Request $request)
    {
        $query = Scan::with(['user', 'findings'])->latest();

        // Filtre par utilisateur
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filtre par statut
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Recherche par cible
        if ($request->search) {
            $query->where('target', 'like', '%' . $request->search . '%');
        }

        $scans = $query->with(['user', 'findings'])->latest()->paginate(15);
        $users = User::all();

        return view('admin.scans', compact('scans', 'users'));
    }

    public function users()
    {
        $users = User::withCount('scans')
                     ->with(['scans' => function($q) {
                         $q->latest()->take(1);
                     }])
                     ->latest()
                     ->paginate(15);

        return view('admin.users', compact('users'));
    }
}