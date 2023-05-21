<?php

use App\Http\Controllers\{ProfileController};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/usuarios', \App\Http\Controllers\UsersController::class);
    /* PERMISSÕES */
    Route::get('permissoes/arvore', [\App\Http\Controllers\PermissionsController::class, 'getTree'])
        ->name('permissoes.tree');
    Route::get('/permissoes/all', [\App\Http\Controllers\PermissionsController::class, 'getAllPermissions'])
        ->name('permissoes.getPermissions');
    Route::resource('/permissoes', \App\Http\Controllers\PermissionsController::class);
    /* FUNÇÕES */
    Route::get('/funcoes/all', [\App\Http\Controllers\RolesController::class, 'getAllRoles'])
        ->name('funcoes.getAll');
    Route::resource('/funcoes', \App\Http\Controllers\RolesController::class);
});

require __DIR__ . '/auth.php';
