<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestMessageController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/rsvp', [InvitationController::class, 'rsvp'])->name('invitation.rsvp');

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::delete('/rsvp/{guestMessage}', [GuestMessageController::class, 'destroy'])->name('rsvp.destroy');

    Route::resource('users', AdminUserController::class)
        ->except(['show'])
        ->middleware('can:manage-admins');
});
