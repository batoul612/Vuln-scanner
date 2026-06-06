<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use App\Jobs\ScanTargetJob;
use Barryvdh\DomPDF\Facade\Pdf;

class ScanController extends Controller
{
   public function index()
{
    $recentScans = Scan::where('user_id', auth()->id())
                       ->with('findings')
                       ->latest()
                       ->take(5)
                       ->get();
    return view('scans.index', compact('recentScans'));
}

    public function store(Request $request)
{
    $request->validate([
        'target' => 'required|string|max:255',
    ]);

    $scan = Scan::create([
        'target' => $request->target,
        'type'   => $this->detectType($request->target),
        'status' => 'pending',
        'user_id' => auth()->id(),

    ]);

    ScanTargetJob::dispatch($scan);

    return redirect()->route('scan.show', $scan->id);
}

    public function show(Scan $scan)
    {
        $findings = $scan->findings()->orderBy('severity')->get();
        return view('scans.show', compact('scan', 'findings'));
    }

    private function detectType(string $target): string
    {
        if (filter_var($target, FILTER_VALIDATE_IP)) {
            return 'ip';
        }
        if (filter_var($target, FILTER_VALIDATE_URL)) {
            return 'url';
        }
        return 'domain';
    }

public function history()
{
    $scans = Scan::where('user_id', auth()->id())
                 ->with('findings')
                 ->latest()
                 ->paginate(10);
    return view('scans.history', compact('scans'));
}

public function exportPdf(Scan $scan)
{
    $findings = $scan->findings()->orderBy('severity')->get();

    $pdf = Pdf::loadView('scans.pdf', compact('scan', 'findings'));

    return $pdf->download("rapport-{$scan->target}-{$scan->id}.pdf");
}

}