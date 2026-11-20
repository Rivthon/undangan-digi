<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
        User::create([
            ...$request->safe()->only(['name', 'email', 'password', 'is_active']),
            'role' => 'admin',
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

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
