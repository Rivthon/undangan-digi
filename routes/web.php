<?php

use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/rsvp', [InvitationController::class, 'rsvp'])->name('invitation.rsvp');
