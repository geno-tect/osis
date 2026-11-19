<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data OSIS')</title>
    <link rel="stylesheet" href="{{ asset('css/osis.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
    <a class="skip-link" href="#konten">Langsung ke konten</a>

    <header class="site-header">
        <div class="header-inner">
            <div class="header-start">
                <a class="brand" href="{{ route('osis.index') }}">
                    <img class="brand-logo" src="{{ asset('img/logo-osis-dikanan.png') }}" alt="" width="50" height="50">
                    <span class="brand-mark">OSKA PASIM</span>
                    <span class="brand-sub">Sistem data anggota</span>
                </a>

                <div class="header-actions">
                    <a class="icon-btn icon-btn--account"
                       href="{{ route('profile.edit') }}"
                       aria-label="Profil saya"
                       title="Profil saya">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.2"></circle>
                            <path d="M5.6 19.4c.5-3.1 3-5.2 6.4-5.2s5.9 2.1 6.4 5.2"></path>
                        </svg>
                    </a>

                    @if (auth()->user()?->isAdmin())
                        <a class="icon-btn icon-btn--add"
                           href="{{ route('osis.create') }}"
                           aria-label="Tambah anggota"
                           title="Tambah anggota">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true">
                                <path d="M12 5.5v13M5.5 12h13"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <nav class="site-nav" aria-label="Navigasi utama">
                @if (auth()->user()?->isAdmin())
                    <a href="{{ route('dashboard') }}"
                       @class(['is-active' => request()->routeIs('dashboard')])>
                        Dashboard
                    </a>
                @endif
                <a href="{{ route('osis.index') }}"
                   @class(['is-active' => request()->routeIs('osis.*')])>
                    Anggota OSIS
                </a>
            </nav>

            <div class="header-auth">
                <a class="pill pill--ghost"
                   href="{{ route('profile.edit') }}"
                   title="Buka profil {{ auth()->user()?->name }}">
                    <span class="pill__label">{{ auth()->user()?->name }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="pill pill--solid">Keluar</button>
                </form>
            </div>
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
