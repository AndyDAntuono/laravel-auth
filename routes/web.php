<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->group(function () {
    Route::resource('projects', ProjectController::class);
});

Route::middleware(['auth'])->group(function () {
    // Rotte accessibili solo dopo l'autenticazione
    Route::middleware('admin')->group(function () {
        // Rotte per l'amministratore
        Route::resource('admin/projects', ProjectController::class);
    });
});

// dal momento che ho avuto problemi di accesso lascio commentata la rotta per accedere alla pagina dei progetti, anche perché sospetto che dobbiamo implementare le rimanenti operazioni CRUD e le relative views.
//Route::middleware(['auth'])->group(function () {
//    Route::resource('projects', ProjectController::class);
//});

require __DIR__.'/auth.php';
