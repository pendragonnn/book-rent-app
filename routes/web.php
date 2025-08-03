<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', CheckRole::class.':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn () => view('dashboard.admin'))->name('dashboard');
        Route::get('/catalog', [BookController::class, 'index'])->name('catalog');
        Route::resource('books', BookController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
    });

Route::middleware(['auth', CheckRole::class.':member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', fn () => view('dashboard.member'))->name('dashboard');
        // Route::get('/catalog', [BookController::class, 'index'])->name('catalog');
    });


require __DIR__.'/auth.php';
