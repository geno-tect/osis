@php
    $site = $content ?? config('beranda');
    $isBerita = request()->routeIs('berita.*');
    $isAspirasi = request()->routeIs('aspirasi.*');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0ea5e9">
    <meta name="description" content="@yield('meta_description', 'Informasi resmi OSIS SMK Pasim Plus Kota Sukabumi: agenda, program kerja, berita kegiatan, dan kotak aspirasi siswa.')">

    <title>@yield('title', 'Beranda') | OSKA PASIM</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo-osis-dikanan.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/beranda.css') }}">
    <script src="{{ asset('js/beranda.js') }}" defer></script>
</head>
<body data-page="@yield('page', 'site')">
    <a class="skip-link" href="#konten">Langsung ke konten</a>

    <header class="site-header" data-site-header>
        <div class="container header-bar">
            <a class="brand" href="{{ route('beranda') }}" aria-label="OSKA PASIM, kembali ke beranda">
                <span class="brand-logo">
                    <img src="{{ asset('img/logo-osis-dikanan.png') }}" alt="" width="44" height="44">
                </span>
                <span class="brand-copy">
                    <span class="brand-name">OSKA PASIM</span>
                    <span class="brand-sub">Kabinet {{ $site['cabinet'] }}</span>
                </span>
            </a>

            <nav class="desktop-nav" aria-label="Navigasi utama">
                <a href="{{ route('beranda') }}" data-nav-id="beranda">Beranda</a>
                <a href="{{ route('beranda') }}#tentang" data-nav-id="tentang">Tentang Kami</a>
                <a href="{{ route('beranda') }}#struktur" data-nav-id="anggota">Anggota OSIS</a>
                <a href="{{ route('beranda') }}#berita" data-nav-id="berita" @if ($isBerita) aria-current="page" @endif>Berita</a>
                <a href="{{ route('aspirasi.index') }}" data-nav-id="aspirasi" @if ($isAspirasi) aria-current="page" @endif>Aspirasi</a>
            </nav>

            <div class="header-actions">
                <a class="button button--sky button--small header-cta" href="{{ route('aspirasi.index') }}">Kirim aspirasi</a>

                <button class="nav-toggle" type="button"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="Buka menu navigasi"
                        data-nav-toggle>
                    <span class="nav-toggle__open"><x-site-icon name="menu" :size="22" /></span>
                    <span class="nav-toggle__close"><x-site-icon name="close" :size="22" /></span>
                </button>
            </div>
        </div>

        <div class="mobile-menu" id="mobile-menu" hidden data-mobile-menu>
            <nav class="container mobile-menu__nav" aria-label="Navigasi seluler">
                <a href="{{ route('beranda') }}" data-nav-id="beranda">Beranda</a>
                <a href="{{ route('beranda') }}#tentang" data-nav-id="tentang">Tentang Kami</a>
                <a href="{{ route('beranda') }}#struktur" data-nav-id="anggota">Anggota OSIS</a>
                <a href="{{ route('beranda') }}#berita" data-nav-id="berita" @if ($isBerita) aria-current="page" @endif>Berita</a>
                <a href="{{ route('aspirasi.index') }}" data-nav-id="aspirasi" @if ($isAspirasi) aria-current="page" @endif>Aspirasi</a>
                <a class="button button--sky mobile-menu__cta" href="{{ route('aspirasi.index') }}">Kirim aspirasi</a>
            </nav>
        </div>
    </header>

    <main id="konten" tabindex="-1">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <a class="footer-brand__link" href="{{ route('beranda') }}" aria-label="OSKA PASIM, kembali ke beranda">
                    <span class="footer-logo">
                        <img src="{{ asset('img/logo-osis-dikanan.png') }}" alt="" width="48" height="48">
                    </span>
                    <span>
                        <span class="footer-brand__name">OSKA PASIM</span>
                        <span class="footer-brand__sub">OSIS {{ $site['school'] }} {{ $site['city'] }}</span>
                    </span>
                </a>

                <p class="footer-brand__copy">Kanal informasi resmi OSIS {{ $site['school'] }} {{ $site['city'] }}.</p>

                <div class="social-row" aria-label="Media sosial OSIS">
                    @foreach ($site['social'] as $social)
                        @if ($social['url'])
                            <a class="social-link" href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }} OSIS, buka di tab baru">
                                <x-site-icon :name="$social['icon']" :size="20" />
                            </a>
                        @else
                            <span class="social-link is-disabled" aria-disabled="true">
                                <x-site-icon :name="$social['icon']" :size="20" />
                                <span class="sr-only">{{ $social['label'] }}, tautan belum tersedia</span>
                            </span>
                        @endif
                    @endforeach
                </div>
                <p class="footer-small">Tautan media sosial menyusul.</p>
            </div>

            <nav class="footer-nav" aria-label="Tautan cepat">
                <h2 class="footer-heading">Jelajahi</h2>
                <a href="{{ route('beranda') }}">Beranda</a>
                <a href="{{ route('beranda') }}#tentang">Tentang Kami</a>
                <a href="{{ route('beranda') }}#struktur">Anggota OSIS</a>
                <a href="{{ route('beranda') }}#berita">Berita</a>
                <a href="{{ route('aspirasi.index') }}">Kotak Aspirasi</a>
                <a href="{{ route('osis.index') }}">Data Lengkap Anggota</a>
            </nav>

            <div class="footer-contact">
                <h2 class="footer-heading">Sekretariat</h2>
                <address>
                    <span class="footer-address-line">
                        <x-site-icon name="map-pin" :size="18" />
                        <span class="footer-address-copy">
                            @foreach ($site['contact']['address_lines'] as $line)
                                <span>{{ $line }}</span>
                            @endforeach
                        </span>
                    </span>
                    @if ($site['contact']['email'])
                        <a class="footer-email" href="mailto:{{ $site['contact']['email'] }}">{{ $site['contact']['email'] }}</a>
                    @endif
                    <span class="footer-small">{{ $site['contact']['note'] }}</span>
                </address>
            </div>
        </div>

        <div class="container footer-bottom">
            <p>&copy; {{ now()->year }} OSKA PASIM. Semua hak dilindungi.</p>
            <p>{{ $site['preview_note'] }}</p>
        </div>
    </footer>
</body>
</html>
