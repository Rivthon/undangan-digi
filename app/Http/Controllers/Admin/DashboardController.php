<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        if ($request->user()->isSuperAdmin()) {
            return view('admin.super-dashboard', [
                'statistics' => [
                    'admins' => User::where('role', 'admin')->count(),
                    'activeAdmins' => User::where('role', 'admin')->where('is_active', true)->count(),
                    'paidAdmins' => User::where('role', 'admin')->where('payment_status', 'paid')->count(),
                ],
                'users' => User::query()->where('role', 'admin')->latest()->take(8)->get(),
            ]);
        }

        $invitation = $request->user()->invitation()->firstOrFail();

        return view('admin.dashboard', [
            'invitation' => $invitation,
            'statistics' => [
                'responses' => $invitation->guestMessages()->count(),
                'attending' => $invitation->guestMessages()->where('attendance', 'hadir')->sum('guest_count'),
                'notAttending' => $invitation->guestMessages()->where('attendance', 'tidak_hadir')->count(),
            ],
            'messages' => $invitation->guestMessages()->latest()->paginate(10),
        ]);
    }
}
