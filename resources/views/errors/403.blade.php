@extends('layouts.osis')

@section('title', 'Akses ditolak')

@section('content')
    <div class="page-head">
        <div class="page-head__text">
            <h1>Akses ditolak</h1>
            <p class="lede">
                Halaman ini hanya bisa dibuka oleh admin. Akun kamu hanya punya akses lihat.
            </p>
        </div>
    </div>

    <p>
        <a class="btn btn--primary" href="{{ route('beranda') }}">Kembali ke beranda</a>
    </p>
@endsection
