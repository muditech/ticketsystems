<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\TicketController;
use \App\Http\Controllers\DashboardController;


Route::get('/', [AuthController::class, 'loginPage'])
    ->name('login-page')
    ->middleware('guest');

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->name('login')
        ->middleware('guest');
    Route::get('logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');
});

Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');


Route::prefix('ticket')->middleware('auth')->name('ticket.')->group(function () {
    Route::get('list', [TicketController::class, 'list'])
        ->name('list');
    Route::get('preview/{ticket}', [TicketController::class, 'preview'])
        ->name('preview');
    Route::get('create', [TicketController::class, 'create'])
        ->name('create');
    Route::post('store', [TicketController::class, 'store'])
        ->name('store');
    Route::post('close/{ticket}', [TicketController::class, 'setStatusClosed'])
        ->name('close');
});


