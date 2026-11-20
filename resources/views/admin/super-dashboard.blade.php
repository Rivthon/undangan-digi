@extends('admin.layouts.app')
@section('title', 'Dashboard Bisnis')
@section('heading', 'Dashboard Bisnis')
@section('subheading', 'Kelola akun pelanggan tanpa mengakses RSVP pribadi mereka.')
@section('action')<a href="{{ route('admin.users.create') }}" class="primary-button">+ Buat Admin Baru</a>@endsection
@section('content')
    <section class="privacy-note"><span>◆</span><div><strong>Privasi pelanggan terlindungi</strong><p>RSVP dan ucapan hanya dapat dilihat oleh pemilik undangan masing-masing.</p></div></section>
    <section class="stats-grid stats-grid--three">
        <article><span>♙</span><div><small>Total Pelanggan</small><strong>{{ $statistics['admins'] }}</strong></div></article>
        <article><span>✓</span><div><small>Akun Aktif</small><strong>{{ $statistics['activeAdmins'] }}</strong></div></article>
        <article><span>Rp</span><div><small>Pembayaran Lunas</small><strong>{{ $statistics['paidAdmins'] }}</strong></div></article>
    </section>
    <section class="panel"><div class="panel-title"><div><h2>Pelanggan Terbaru</h2><p>Ringkasan akun, bukan data tamu undangan.</p></div><a href="{{ route('admin.users.index') }}">Lihat semua</a></div>
        <div class="table-wrap"><table><thead><tr><th>Pelanggan</th><th>Pembayaran</th><th>Akun</th><th>Terdaftar</th></tr></thead><tbody>
        @forelse($users as $adminUser)<tr><td><strong>{{ $adminUser->name }}</strong><small class="block">{{ $adminUser->email }}</small></td><td><span class="badge {{ $adminUser->payment_status }}">{{ $adminUser->payment_status === 'paid' ? 'Lunas' : 'Refund' }}</span></td><td><span class="badge {{ $adminUser->is_active ? 'active' : 'inactive' }}">{{ $adminUser->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td>{{ $adminUser->created_at->format('d M Y') }}</td></tr>@empty<tr><td colspan="4" class="empty">Belum ada pelanggan.</td></tr>@endforelse
        </tbody></table></div>
    </section>
@endsection
