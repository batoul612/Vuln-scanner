<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

// Page d'accueil publique (landing page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes protégées — connexion obligatoire
Route::middleware('auth')->group(function () {

    // Dashboard / Scanner
    Route::get('/dashboard', [ScanController::class, 'index'])->name('dashboard');

    // Scan
    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');
    Route::get('/scan/{scan}', [ScanController::class, 'show'])->name('scan.show');
    Route::get('/history', [ScanController::class, 'history'])->name('scan.history');
    Route::get('/scan/{scan}/pdf', [ScanController::class, 'exportPdf'])->name('scan.pdf');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/scans', [AdminController::class, 'scans'])->name('scans');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});

require __DIR__.'/auth.php';