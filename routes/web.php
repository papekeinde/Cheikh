<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index'])->name('vitrine');

Route::get('/__health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'foliolara',
        'branch' => 'gpt',
        'timestamp' => now()->toDateTimeString(),
    ]);
});

Route::get('/__debug-render', function () {
    try {
        view('auth.login')->render();
        view('contact')->render();

        return response()->json([
            'status' => 'ok',
            'message' => 'login and contact views render correctly',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/projects/create', [DashboardProjectController::class, 'create'])->name('dashboard.projects.create');
    Route::post('/dashboard/projects', [DashboardProjectController::class, 'store'])->name('dashboard.projects.store');
    Route::patch('/dashboard/projects/{projet}/review', [DashboardProjectController::class, 'review'])->name('dashboard.projects.review');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
