@extends('admin.layouts.app')
@section('title', 'Edit Admin')
@section('heading', 'Edit Admin Pelanggan')
@section('subheading', 'Kelola identitas, pembayaran, akses, atau kata sandi pelanggan.')
@section('content')
    <section class="form-panel"><form method="POST" action="{{ route('admin.users.update', $adminUser) }}" class="admin-form">@csrf @method('PUT')
        @include('admin.users.partials.form', ['adminUser' => $adminUser])
        <label>Status pembayaran<select name="payment_status" required><option value="paid" @selected(old('payment_status', $adminUser->payment_status) === 'paid')>Lunas</option><option value="refunded" @selected(old('payment_status', $adminUser->payment_status) === 'refunded')>Refund</option></select></label>
        <div class="form-actions"><a href="{{ route('admin.users.index') }}">Batal</a><button class="primary-button" type="submit">Simpan Perubahan</button></div>
    </form></section>
@endsection
