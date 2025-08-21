<?php

use App\Http\Controllers\Admin\BookLoanController as adminBookLoanController;
use App\Http\Controllers\Member\BookLoanController as memberBookLoanController;
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
use App\Http\Controllers\Member\CartController;
use App\Http\Controllers\Member\BookLoanReceiptController as memberBookLoanReceiptController;

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

Route::middleware(['auth', CheckRole::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [adminDashboard::class, 'index'])->name('dashboard');
        Route::get('/catalog', [adminBookController::class, 'index'])->name('catalog');
        Route::resource('books', adminBookController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('book-loans', adminBookLoanController::class);
    });

Route::middleware(['auth', CheckRole::class . ':member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', [memberDashboard::class, 'index'])->name('dashboard');
        Route::resource('books', memberBookController::class);

        Route::resource('book-loans', memberBookLoanController::class);
        Route::get('/book-loans/create/{bookItem}', [memberBookLoanController::class, 'create'])->name('book-loans.create');
        Route::post('/book-loans/store', [memberBookLoanController::class, 'store'])->name('book-loans.store');

        Route::post('/book-loans/{bookLoan}/upload-payment-proof', [memberBookLoanController::class, 'uploadPaymentProof'])
            ->name('book-loans.uploadPaymentProof');

        Route::put('/book-loans/{bookLoan}/return', [memberBookLoanController::class, 'returnLoan'])
            ->name('book-loans.return');
        Route::put('/book-loans/{bookLoan}/cancel', [memberBookLoanController::class, 'cancel'])
            ->name('book-loans.cancel');

        // Loan Detail + edit
        Route::get('/book-loans/{bookLoan}', [memberBookLoanController::class, 'show'])->name('book-loans.show');
        Route::get('/book-loans/{bookLoan}/edit', [memberBookLoanController::class, 'edit'])->name('book-loans.edit');
        Route::put('/book-loans/{bookLoan}', [memberBookLoanController::class, 'update'])->name('book-loans.update');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/remove/{index}', [CartController::class, 'remove'])->name('cart.remove');

        // Receipts (checkout)
        Route::post('/receipts', [memberBookLoanReceiptController::class, 'store'])->name('receipts.store');
    });


require __DIR__ . '/auth.php';
