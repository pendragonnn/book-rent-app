<?php

use App\Http\Controllers\Admin\BookLoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Admin\BookController as adminBookController;
use App\Http\Controllers\Member\BookController as memberBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as adminDashboard;
use App\Http\Controllers\Member\DashboardController as memberDashboard;

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
        Route::get('/dashboard', [adminDashboard::class, 'index'])->name('dashboard');
        Route::get('/catalog', [adminBookController::class, 'index'])->name('catalog');
        Route::resource('books', adminBookController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('book-loans', BookLoanController::class);
    });

Route::middleware(['auth', CheckRole::class.':member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', [memberDashboard::class, 'index'])->name('dashboard');
        Route::resource('books', memberBookController::class);
    });


require __DIR__.'/auth.php';
