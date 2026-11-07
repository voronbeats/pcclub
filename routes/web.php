<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/zones', 'zones')->name('zones');
Route::view('/prices', 'prices')->name('prices');
Route::view('/promo', 'promo')->name('promo');
Route::view('/events', 'events')->name('events');
Route::view('/contacts', 'contacts')->name('contacts');
Route::view('/rules', 'rules')->name('rules');
Route::view('/privacy', 'privacy')->name('privacy');

// Бронирование
Route::get('/book', [BookingController::class, 'create'])->name('book');
Route::post('/book', [BookingController::class, 'store'])->middleware('throttle:6,1')->name('book.store');

// Вход и регистрация по номеру телефона
Route::get('/enter', [AuthController::class, 'enter'])->name('login');
Route::post('/enter', [AuthController::class, 'check'])->middleware('throttle:20,1')->name('enter.check');
Route::get('/enter/login', [AuthController::class, 'loginForm'])->name('enter.login');
Route::get('/enter/register', [AuthController::class, 'registerForm'])->name('enter.register');
Route::post('/enter/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.post');
Route::post('/enter/register', [AuthController::class, 'register'])->middleware('throttle:10,1')->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Личный кабинет
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/account/receipts/{purchase}', [AccountController::class, 'receipt'])->name('account.receipt');
});

// Админка
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('index');
});
