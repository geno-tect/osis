@extends('layouts.public')

@section('title', 'Beranda')
@section('page', 'beranda')
@section('meta_description', 'Informasi resmi OSIS SMK Pasim Plus Kota Sukabumi: profil pengurus, daftar anggota, berita kegiatan sekolah, dan kotak aspirasi siswa.')

@section('content')
    <section class="hero" id="beranda" aria-labelledby="hero-title" data-nav-match="beranda">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="hero-badge">Kabinet {{ $content['cabinet'] }} <span aria-hidden="true">·</span> Periode {{ $content['period'] }}</p>

                <h1 id="hero-title">
                    @foreach ($content['hero']['title_lines'] as $line)
                        <span class="hero-title__line{{ $loop->last ? ' hero-title__line--accent' : '' }}">{{ $line }}</span>
                    @endforeach
                </h1>

                <p class="hero-lede">{{ $content['hero']['lede'] }}</p>

                <div class="hero-actions">
                    <a class="button button--sky" href="#struktur">Lihat Anggota OSIS</a>
                    <a class="button button--outline" href="{{ route('aspirasi.index') }}">
                        <x-site-icon name="check" :size="18" />
                        Kirim aspirasi
                    </a>
                </div>

                <p class="hero-note">
                    <x-site-icon name="check" :size="17" />
                    {{ $content['hero']['note'] }}
                </p>
            </div>

            <figure class="hero-figure">
                <span class="hero-orbit" aria-hidden="true"></span>

                <div class="hero-frame">
                    <div class="hero-frame__inner">
                        <img class="hero-frame__logo" src="{{ asset('img/logo-osis-dikanan.png') }}" alt="" width="76" height="76">
                        <p class="hero-frame__title">Contoh foto kegiatan</p>
                        <p class="hero-frame__hint">Ganti dengan dokumentasi 4:5</p>
                    </div>

                    <figcaption class="hero-caption">
                        <span class="hero-caption__kicker">Sekretariat OSIS</span>
                        <span>{{ $content['school'] }}, {{ $content['city'] }}</span>
                    </figcaption>
                </div>
            </figure>
        </div>
    </section>

    <section class="section section--sky" id="tentang" aria-labelledby="tentang-title" data-nav-match="tentang">
        <div class="container about-grid">
            <div class="about-copy">
                <p class="section-kicker">Tentang kami</p>
                <h2 id="tentang-title">{{ $content['about']['title'] }}</h2>

                @foreach ($content['about']['paragraphs'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            <div class="vision-panel">
                <h3 class="sr-only">Visi dan misi</h3>

                <p class="panel-label">Visi</p>
                <p class="vision-quote">{{ $content['about']['vision'] }}</p>

                <p class="panel-label panel-label--spaced">Misi</p>
                <ul class="mission-list">
                    @foreach ($content['about']['missions'] as $mission)
                        <li>
                            <x-site-icon name="check" :size="18" />
                            <span>{{ $mission }}</span>
                        </li>
                    @endforeach
                </ul>

                <p class="content-note">Draf redaksi. Ganti dengan rumusan resmi kabinet.</p>
            </div>
        </div>
    </section>

    <section class="section" id="struktur" aria-labelledby="struktur-title" data-nav-match="anggota">
        <div class="container">
            <div class="section-head section-head--stacked">
                <div>
                    <p class="section-kicker">Struktur pengurus</p>
                    <h2 id="struktur-title">Pengurus &amp; Anggota OSIS</h2>
                </div>
                <p class="section-lede">Badan Pengurus Harian dan seluruh anggota OSIS yang menjalankan kerja kabinet.</p>
            </div>

            <div class="bph-block">
                <h3 class="subheading">Badan Pengurus Harian (BPH)</h3>

                @if (count($content['bph']))
                    <div class="bph-grid">
                        @foreach ($content['bph'] as $person)
                            <article class="bph-card{{ $person['is_lead'] ? ' bph-card--lead' : '' }}">
                                <span class="bph-avatar" aria-hidden="true">{{ $person['initial'] }}</span>
                                <div>
                                    <p class="bph-role">{{ $person['role'] }}</p>
                                    <p class="bph-name">{{ $person['name'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <strong>Data pengurus belum tersedia.</strong>
                        <p>Nama dan jabatan akan tampil di sini setelah ditambahkan.</p>
                    </div>
                @endif
            </div>

            <div class="members-block" id="anggota">
                <div class="section-head section-head--stacked members-head">
                    <div class="members-head-row">
                        <div>
                            <p class="section-kicker">Data Terdaftar</p>
                            <h3 class="subheading">Daftar Anggota OSIS</h3>
                            <p class="section-lede">Anggota resmi yang tercatat di dalam sistem database OSIS.</p>
                        </div>
                    </div>
                </div>

                @if (isset($osisList) && $osisList->isNotEmpty())
                    <div class="members-grid">
                        @foreach ($osisList as $item)
                            <article class="member-card">
                                <span class="member-avatar" aria-hidden="true">{{ mb_substr($item->nama, 0, 1) }}</span>
                                <div class="member-info">
                                    <span class="member-sekbid">{{ $item->sekbid }}</span>
                                    <h4 class="member-name">{{ $item->nama }}</h4>
                                    <p class="member-meta">ID {{ $item->id_osis }} &middot; {{ $item->kelas }} &middot; {{ $item->jurusan }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <strong>Belum ada anggota di database.</strong>
                        <p>Anggota OSIS yang ditambahkan melalui panel admin akan langsung tampil di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="section section--soft" id="berita" aria-labelledby="berita-title" data-nav-match="berita">
        <div class="container">
            <div class="section-head">
                <div>
                    <p class="section-kicker">Berita &amp; dokumentasi</p>
                    <h2 id="berita-title">Catatan kegiatan terbaru</h2>
                </div>
                <p class="section-lede">Liputan singkat dari kegiatan sekolah, lengkap dengan kategori dan tanggal terbit.</p>
            </div>

            <div class="news-grid">
                @forelse ($content['news'] as $article)
                    <article class="news-card">
                        <a class="news-card__link" href="{{ route('berita.show', $article['slug']) }}" aria-label="Baca liputan: {{ $article['title'] }}">
                            <div class="news-media" aria-hidden="true">
                                <span class="news-media__ring"></span>
                                <span class="news-media__label">Foto liputan</span>
                            </div>

                            <div class="news-card__body">
                                <div class="news-meta">
                                    <span class="chip">{{ $article['category'] }}</span>
                                    <span class="sample-tag">Contoh</span>
                                    <time datetime="{{ $article['date'] }}">{{ $article['date_label'] }}</time>
                                </div>

                                <h3>{{ $article['title'] }}</h3>
                                <p>{{ $article['excerpt'] }}</p>
                                <span class="news-card__cta">Baca liputan</span>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="empty-state">
                        <strong>Belum ada berita.</strong>
                        <p>Liputan kegiatan akan tampil di sini setelah ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="aspiration-section" id="aspirasi" aria-labelledby="aspirasi-title" data-nav-match="aspirasi">
        <div class="container">
            <div class="aspiration-band">
                <span class="aspiration-orbit" aria-hidden="true"></span>

                <div class="aspiration-copy">
                    <p class="section-kicker section-kicker--dark">Kotak aspirasi</p>
                    <h2 id="aspirasi-title">{{ $content['aspiration']['title'] }}</h2>
                    <p>{{ $content['aspiration']['lede'] }}</p>
                    <a class="button button--white" href="{{ route('aspirasi.index') }}">Tulis aspirasi</a>
                </div>

                <ul class="aspiration-facts">
                    @foreach ($content['aspiration']['facts'] as $fact)
                        <li>
                            <x-site-icon name="check" :size="18" />
                            <span>{{ $fact }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endsection
