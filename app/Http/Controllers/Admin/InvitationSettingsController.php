<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateInvitationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        abort_if($request->user()->isSuperAdmin(), 403);

        return view('admin.invitation.edit', [
            'invitation' => $request->user()->invitation()->firstOrFail(),
        ]);
    }

    public function update(UpdateInvitationRequest $request): RedirectResponse
    {
        $request->user()->invitation()->firstOrFail()->update($request->validated());

        return redirect()->route('admin.invitation.edit')->with('success', 'Undangan berhasil diperbarui.');
    }
}
