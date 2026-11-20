@extends('admin.layouts.app')
@section('title', 'Buat Admin')
@section('heading', 'Buat Admin Pelanggan')
@section('subheading', 'Pastikan pembayaran sudah diterima sebelum membuat akun.')
@section('content')
    <section class="form-panel"><div class="payment-note"><span>✓</span><div><strong>Status pembayaran: Lunas</strong><p>Akun yang dibuat dari halaman ini otomatis tercatat telah membayar.</p></div></div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="admin-form">@csrf
            @include('admin.users.partials.form', ['adminUser' => null])
            <div class="form-actions"><a href="{{ route('admin.users.index') }}">Batal</a><button class="primary-button" type="submit">Buat Akun Admin</button></div>
        </form>
    </section>
@endsection
