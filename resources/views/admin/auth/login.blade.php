<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Undangan Digi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-page">
    <div class="login-card">
        <a href="{{ route('invitation.demo') }}" class="login-brand"><span>U</span> Undangan Digi</a>
        <p class="overline">Area pengelola</p><h1>Selamat datang kembali</h1><p>Masuk untuk mengelola RSVP dan akun pelanggan.</p>
        <form method="POST" action="{{ route('admin.login.store') }}" class="admin-form">
            @csrf
            <label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="admin@email.com"></label>
            <label>Kata sandi<input type="password" name="password" required autocomplete="current-password" placeholder="••••••••"></label>
            <label class="checkbox"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
            @if ($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
            <button class="primary-button" type="submit">Masuk ke Dashboard</button>
        </form>
        <small>Halaman ini hanya untuk pengguna yang memiliki akses.</small>
    </div>
</body>
</html>
