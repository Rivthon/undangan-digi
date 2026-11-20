<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->where('role', 'admin')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $user = User::create([
                ...$request->safe()->only(['name', 'email', 'password', 'is_active']),
                'role' => 'admin',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            $defaults = config('invitation');
            $user->invitation()->create([
                'slug' => Str::slug($request->string('name')).'-'.$user->id,
                'bride_name' => $defaults['bride']['name'], 'bride_short_name' => $defaults['bride']['short_name'],
                'bride_parents' => $defaults['bride']['parents'], 'bride_instagram' => $defaults['bride']['instagram'],
                'groom_name' => $defaults['groom']['name'], 'groom_short_name' => $defaults['groom']['short_name'],
                'groom_parents' => $defaults['groom']['parents'], 'groom_instagram' => $defaults['groom']['instagram'],
                'event_at' => $defaults['date'], 'display_date' => $defaults['display_date'],
                'akad_time' => $defaults['akad'], 'reception_time' => $defaults['reception'],
                'venue' => $defaults['venue'], 'address' => $defaults['address'],
                'maps_url' => $defaults['maps_url'], 'quote' => $defaults['quote'],
            ]);
        });

        return redirect()->route('admin.users.index')->with('success', 'Akun admin pelanggan berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        abort_unless($user->role === 'admin', 404);

        return view('admin.users.edit', ['adminUser' => $user]);
    }

    public function update(UpdateAdminUserRequest $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'admin', 404);

        $data = $request->safe()->only(['name', 'email', 'payment_status', 'is_active']);

        if ($request->filled('password')) {
            $data['password'] = $request->string('password')->toString();
        }

        $data['paid_at'] = $data['payment_status'] === 'paid' ? ($user->paid_at ?? now()) : null;
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->role === 'admin', 404);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}
