<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GuestMessageController extends Controller
{
    public function destroy(Request $request, GuestMessage $guestMessage): RedirectResponse
    {
        abort_unless($guestMessage->invitation?->user_id === $request->user()->id, 404);
        $guestMessage->delete();

        return back()->with('success', 'Data RSVP berhasil dihapus.');
    }
}
