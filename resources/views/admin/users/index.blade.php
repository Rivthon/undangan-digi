@extends('admin.layouts.app')
@section('title', 'Admin Pelanggan')
@section('heading', 'Admin Pelanggan')
@section('subheading', 'Buat akun setelah pembayaran pelanggan dikonfirmasi.')
@section('action')<a href="{{ route('admin.users.create') }}" class="primary-button">+ Buat Admin Baru</a>@endsection
@section('content')
    <section class="panel">
        <div class="table-wrap"><table><thead><tr><th>Pelanggan</th><th>Status Bayar</th><th>Status Akun</th><th>Dibuat</th><th>Aksi</th></tr></thead><tbody>
        @forelse ($users as $adminUser)
            <tr><td><strong>{{ $adminUser->name }}</strong><small class="block">{{ $adminUser->email }}</small></td><td><span class="badge {{ $adminUser->payment_status }}">{{ $adminUser->payment_status === 'paid' ? 'Lunas' : 'Refund' }}</span>@if($adminUser->paid_at)<small class="block">{{ $adminUser->paid_at->format('d M Y') }}</small>@endif</td><td><span class="badge {{ $adminUser->is_active ? 'active' : 'inactive' }}">{{ $adminUser->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td>{{ $adminUser->created_at->format('d M Y') }}</td><td class="actions"><a href="{{ route('admin.users.edit', $adminUser) }}">Edit</a><form method="POST" action="{{ route('admin.users.destroy', $adminUser) }}" onsubmit="return confirm('Hapus akun admin ini?')">@csrf @method('DELETE')<button class="danger-link">Hapus</button></form></td></tr>
        @empty<tr><td colspan="5" class="empty">Belum ada akun admin pelanggan.</td></tr>@endforelse
        </tbody></table></div>
        {{ $users->links() }}
    </section>
@endsection
