<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\BookingForm::class)->name('booking.form');
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'store'])->name('auth.store');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => \App\Http\Middleware\IsAdminMiddleware::class], function () {
        Route::resource('tables', \App\Http\Controllers\Admin\TableController::class);
    });
});
