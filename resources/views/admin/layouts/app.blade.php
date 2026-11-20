<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Undangan Digi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-tenant.css') }}">
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="brand"><span>U</span><div>Undangan Digi<small>Admin Panel</small></div></a>
            <nav>
                <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>⌂ <span>Dashboard</span></a>
                @can('manage-admins')
                    <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])>♙ <span>Admin Pelanggan</span></a>
                @else
                    <a href="{{ route('admin.invitation.edit') }}" @class(['active' => request()->routeIs('admin.invitation.*')])>✎ <span>Atur Undangan</span></a>
                @endcan
                <a href="{{ auth()->user()->isSuperAdmin() ? route('invitation.demo') : route('invitation.show', auth()->user()->invitation) }}" target="_blank">↗ <span>Lihat Undangan</span></a>
            </nav>
            <div class="sidebar-user">
                <div class="avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
                <div><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Admin' }}</small></div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="logout" type="submit">Keluar</button></form>
        </aside>
        <main class="content">
            <header><div><span class="mobile-brand">Undangan Digi</span><h1>@yield('heading')</h1><p>@yield('subheading')</p></div>@yield('action')</header>
            @if (session('success'))<div class="alert success">{{ session('success') }}</div>@endif
            @yield('content')
        </main>
    </div>
</body>
</html>
