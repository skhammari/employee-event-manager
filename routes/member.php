<?php

use App\Http\Controllers\Member\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Member\MemberController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:member'])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('member.login');
        
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('member.login.store');
});

Route::middleware(['auth:member'])->group(function () {
    Route::get('dashboard', [MemberController::class, 'dashboard'])
        ->name('member.dashboard');

    Route::get('events', [MemberController::class, 'events'])
        ->name('member.events');

    Route::post('events/{event}/participate', [MemberController::class, 'participate'])
        ->name('member.events.participate');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('member.logout');
}); 