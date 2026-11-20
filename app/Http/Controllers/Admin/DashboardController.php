<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestMessage;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'statistics' => [
                'responses' => GuestMessage::count(),
                'attending' => GuestMessage::where('attendance', 'hadir')->sum('guest_count'),
                'notAttending' => GuestMessage::where('attendance', 'tidak_hadir')->count(),
                'admins' => User::where('role', 'admin')->count(),
            ],
            'messages' => GuestMessage::query()->latest()->paginate(10),
        ]);
    }
}
