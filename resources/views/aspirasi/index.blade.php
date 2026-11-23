@extends('layouts.public')

@section('title', 'Kirim Aspirasi')
@section('page', 'aspirasi')
@section('meta_description', 'Kirim ide, kritik, atau saran untuk OSIS SMK Pasim Plus Kota Sukabumi. Nama tidak wajib diisi.')

@section('content')
    <section class="page-hero" aria-labelledby="aspirasi-page-title">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li aria-current="page">Aspirasi</li>
                </ol>
            </nav>

            <div class="page-hero__grid">
                <div>
                    <p class="section-kicker">Kotak aspirasi</p>
                    <h1 id="aspirasi-page-title">Kirim aspirasi</h1>
                    <p class="page-lede">Sampaikan ide, kritik, atau saran untuk OSIS. Nama tidak wajib diisi.</p>
                </div>
                <p class="page-note">Pesan tidak ditampilkan ke publik. Aspirasi dibaca pengurus untuk ditindaklanjuti.</p>
            </div>
        </div>
    </section>

    <div class="container aspiration-layout">
        <div class="aspiration-main">
            @if (session('success'))
                <div class="success-card" role="status" tabindex="-1" data-success>
                    <span class="success-icon" aria-hidden="true">
                        <x-site-icon name="check" :size="26" />
                    </span>
                    <h2>Aspirasi terkirim.</h2>
                    <p>Terima kasih. Pesanmu sudah masuk ke kotak aspirasi pengurus.</p>
                    <div class="success-actions">
                        <a class="button button--sky" href="{{ route('aspirasi.index') }}">Kirim aspirasi lain</a>
                        <a class="text-link" href="{{ route('beranda') }}">Kembali ke beranda</a>
                    </div>
                </div>
            @else
                @if ($errors->any())
                    <div class="form-alert" role="alert" tabindex="-1" data-error-summary>
                        <strong>Ada isian yang perlu diperiksa.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-card" method="POST" action="{{ route('aspirasi.store') }}" data-aspiration-form>
                    @csrf

                    <div class="field">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" required
                                aria-describedby="kategori-hint @error('kategori') kategori-error @enderror"
                                @error('kategori') aria-invalid="true" @enderror>
                            <option value="" @selected(! old('kategori'))>Pilih kategori</option>
                            @foreach ($content['aspiration']['categories'] as $category)
                                <option value="{{ $category }}" @selected(old('kategori') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        <p class="field-hint" id="kategori-hint">Pilih yang paling dekat dengan isi pesanmu.</p>
                        @error('kategori')
                            <p class="field-error" id="kategori-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="pesan">Isi aspirasi</label>
                        <textarea id="pesan" name="pesan" rows="7" required minlength="20" maxlength="2000"
                                  aria-describedby="pesan-hint @error('pesan') pesan-error @enderror"
                                  @error('pesan') aria-invalid="true" @enderror>{{ old('pesan') }}</textarea>
                        <p class="field-hint" id="pesan-hint">Minimal 20 karakter. Tulis dengan jelas agar mudah ditindaklanjuti.</p>
                        @error('pesan')
                            <p class="field-error" id="pesan-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="nama">Nama <span class="label-optional">(opsional)</span></label>
                        <input id="nama" name="nama" type="text" maxlength="100" autocomplete="name"
                               value="{{ old('nama') }}"
                               aria-describedby="nama-hint @error('nama') nama-error @enderror"
                               @error('nama') aria-invalid="true" @enderror>
                        <p class="field-hint" id="nama-hint">Kosongkan jika ingin tetap anonim.</p>
                        @error('nama')
                            <p class="field-error" id="nama-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button class="button button--amber" type="submit" data-submit-button>
                            <span data-submit-label>Kirim aspirasi</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <aside class="aspiration-aside" aria-labelledby="before-send">
            <h2 id="before-send">Sebelum mengirim</h2>
            <ul class="aside-list">
                @foreach ($content['aspiration']['privacy_points'] as $point)
                    <li>
                        
                        <span>{{ $point }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="aside-note">
                <strong>Privasi</strong>
                <p>Aspirasi tidak ditampilkan ke publik. Pengurus membaca pesan untuk menindaklanjuti.</p>
            </div>
        </aside>
    </div>
@endsection
