<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestMessage;
use Illuminate\Http\RedirectResponse;

class GuestMessageController extends Controller
{
    public function destroy(GuestMessage $guestMessage): RedirectResponse
    {
        $guestMessage->delete();

        return back()->with('success', 'Data RSVP berhasil dihapus.');
    }
}
