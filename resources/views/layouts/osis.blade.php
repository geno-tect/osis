<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data OSIS')</title>
    <link rel="stylesheet" href="{{ asset('css/osis.css') }}">
</head>
<body>
    <a class="skip-link" href="#konten">Langsung ke konten</a>

    <header class="site-header">
        <div class="shell header-inner">
            <a class="brand" href="{{ route('osis.index') }}">
                <img class="brand-logo" src="{{ asset('img/logo-osis-dikanan.png') }}" alt="" width="50" height="50">
                <span class="brand-mark">OSKA PASIM</span>
                <span class="brand-sub">Sistem data anggota</span>
            </a>

            <nav class="site-nav" aria-label="Navigasi utama">
                @if (auth()->user()?->isAdmin())
                    <a href="{{ route('dashboard') }}"
                       @class(['is-active' => request()->routeIs('dashboard')])>
                        Dashboard
                    </a>
                @endif
                <a href="{{ route('osis.index') }}"
                   @class(['is-active' => request()->routeIs('osis.index') || request()->routeIs('osis.edit')])>
                    Daftar Anggota OSIS
                </a>
                @if (auth()->user()?->isAdmin())
                    <a href="{{ route('osis.create') }}"
                       @class(['is-active' => request()->routeIs('osis.create')])>
                        Tambah anggota
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="shell main" id="konten">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="shell">
            <p>Sistem data anggota OSIS</p>
        </div>
    </footer>

    <script src="{{ asset('js/osis.js') }}" defer></script>
</body>
</html>
