<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\DuesPaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {

    Route::resource('members', MemberController::class);
    Route::resource('events', EventController::class);
    Route::resource('finances', FinancialTransactionController::class);
    Route::resource('dues', DuesPaymentController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
