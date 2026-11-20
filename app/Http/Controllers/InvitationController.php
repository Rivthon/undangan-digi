<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function demo(Request $request): View
    {
        return view('invitation', [
            'invitation' => config('invitation'),
            'invitationModel' => null,
            'guestName' => trim((string) $request->query('to', 'Tamu Undangan')),
            'messages' => collect(),
        ]);
    }

    public function show(Invitation $invitation, Request $request): View
    {
        return view('invitation', [
            'invitation' => $invitation->displayData(),
            'invitationModel' => $invitation,
            'guestName' => trim((string) $request->query('to', 'Tamu Undangan')),
            'messages' => $invitation->guestMessages()->latest()->take(20)->get(),
        ]);
    }

    public function rsvp(Invitation $invitation, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'attendance' => ['required', 'in:hadir,tidak_hadir,masih_ragu'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        $invitation->guestMessages()->create($data);

        return back()->with('success', 'Terima kasih, konfirmasi dan ucapan Anda sudah tersimpan.');
    }
}
