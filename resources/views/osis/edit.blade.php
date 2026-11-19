@extends('layouts.osis')

@section('title', 'Edit Anggota OSIS')

@section('content')
    <div class="page-head">
        <div class="page-head__text">
            <h1>Edit anggota</h1>
            <p class="lede">Perbarui data <strong>{{ $osis->nama }}</strong>.</p>
        </div>

        <a class="btn btn--ghost" href="{{ route('osis.index') }}">Kembali ke daftar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert--error" role="alert">
            <p class="alert__title">Ada {{ $errors->count() }} isian yang perlu diperbaiki.</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-card" action="{{ route('osis.update', $osis->id) }}" method="POST" data-submit-once>
        @csrf
        @method('PUT')

        <div class="field">
            <label for="id_osis">ID OSIS <span class="req" aria-hidden="true">*</span></label>
            <input
                type="text"
                id="id_osis"
                name="id_osis"
                value="{{ old('id_osis', $osis->id_osis) }}"
                maxlength="50"
                required
                @if ($errors->has('id_osis')) aria-invalid="true" aria-describedby="id_osis-error" @endif
            >
            @error('id_osis')
                <p class="field-error" id="id_osis-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="nama">Nama lengkap <span class="req" aria-hidden="true">*</span></label>
            <input
                type="text"
                id="nama"
                name="nama"
                value="{{ old('nama', $osis->nama) }}"
                maxlength="100"
                required
                @if ($errors->has('nama')) aria-invalid="true" aria-describedby="nama-error" @endif
            >
            @error('nama')
                <p class="field-error" id="nama-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field-row">
            <div class="field">
                <label for="kelas">Kelas <span class="req" aria-hidden="true">*</span></label>
                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    value="{{ old('kelas', $osis->kelas) }}"
                    maxlength="50"
                    required
                    @if ($errors->has('kelas')) aria-invalid="true" aria-describedby="kelas-error" @endif
                >
                @error('kelas')
                    <p class="field-error" id="kelas-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="jurusan">Jurusan <span class="req" aria-hidden="true">*</span></label>
                <input
                    type="text"
                    id="jurusan"
                    name="jurusan"
                    value="{{ old('jurusan', $osis->jurusan) }}"
                    maxlength="100"
                    required
                    @if ($errors->has('jurusan')) aria-invalid="true" aria-describedby="jurusan-error" @endif
                >
                @error('jurusan')
                    <p class="field-error" id="jurusan-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="field">
            <label for="sekbid">Sekbid <span class="req" aria-hidden="true">*</span></label>
            <input
                type="text"
                id="sekbid"
                name="sekbid"
                value="{{ old('sekbid', $osis->sekbid) }}"
                maxlength="100"
                required
                @if ($errors->has('sekbid')) aria-invalid="true" aria-describedby="sekbid-error" @endif
            >
            @error('sekbid')
                <p class="field-error" id="sekbid-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <button class="btn btn--primary" type="submit">Simpan perubahan</button>
            <a class="btn btn--ghost" href="{{ route('osis.index') }}">Batal</a>
        </div>
    </form>
@endsection
