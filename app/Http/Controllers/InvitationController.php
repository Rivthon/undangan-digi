<?php

namespace App\Http\Controllers;

use App\Models\GuestMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(Request $request): View
    {
        return view('invitation', [
            'invitation' => config('invitation'),
            'guestName' => trim((string) $request->query('to', 'Tamu Undangan')),
            'messages' => GuestMessage::query()->latest()->take(20)->get(),
        ]);
    }

    public function rsvp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'attendance' => ['required', 'in:hadir,tidak_hadir,masih_ragu'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        GuestMessage::create($data);

        return back()->with('success', 'Terima kasih, konfirmasi dan ucapan Anda sudah tersimpan.');
    }
}
