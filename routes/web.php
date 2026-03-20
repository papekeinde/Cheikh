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

Route::get('/', [UserController::class, 'index'])->middleware('track')->name('vitrine');

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

Route::get('/__debug-db', function () {
    try {
        $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
        $driver = config('database.default');
        $tables = [];
        if ($driver === 'sqlite') {
            $raw = \Illuminate\Support\Facades\DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
            $tables = array_map(fn($t) => $t->name, $raw);
        } else {
            $raw = \Illuminate\Support\Facades\DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            $tables = array_map(fn($t) => $t->tablename, $raw);
        }
        $userCount = \Illuminate\Support\Facades\DB::table('users')->count();
        $projetCount = \Illuminate\Support\Facades\DB::table('projets')->count();
        return response()->json([
            'status' => 'ok',
            'driver' => $driver,
            'db_connection_env' => env('DB_CONNECTION'),
            'db_database_env' => env('DB_DATABASE'),
            'tables' => $tables,
            'user_count' => $userCount,
            'projet_count' => $projetCount,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'driver' => config('database.default'),
            'db_connection_env' => env('DB_CONNECTION'),
            'db_database_env' => env('DB_DATABASE'),
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
