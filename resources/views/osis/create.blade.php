@extends('layouts.osis')

@section('title', 'Tambah Anggota OSIS')

@section('content')
    <div class="page-head">
        <div class="page-head__text">
            <h1>Tambah anggota</h1>
            <p class="lede">Catat anggota baru. Kolom bertanda <span class="req">*</span> wajib diisi.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert--success" role="status">
            {{ session('success') }}
        </div>
    @endif

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

    <form class="form-card" action="{{ route('osis.store') }}" method="POST" enctype="multipart/form-data" data-submit-once>
        @csrf

        <div class="field">
            <label for="id_osis">ID OSIS <span class="req" aria-hidden="true">*</span></label>
            <input
                type="text"
                id="id_osis"
                name="id_osis"
                value="{{ old('id_osis') }}"
                maxlength="50"
                placeholder="Contoh: OSIS-001"
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
                value="{{ old('nama') }}"
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
                    value="{{ old('kelas') }}"
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
                    value="{{ old('jurusan') }}"
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
            <select
                id="sekbid"
                name="sekbid"
                class="select"
                required
                @if ($errors->has('sekbid')) aria-invalid="true" aria-describedby="sekbid-error" @endif
            >
                <option value="">-- Pilih sekbid --</option>
                @foreach ($sekbidOptions as $sekbid)
                    <option value="{{ $sekbid }}" @selected(old('sekbid') === $sekbid)>{{ $sekbid }}</option>
                @endforeach
            </select>
            @error('sekbid')
                <p class="field-error" id="sekbid-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="jabatan">Jabatan</label>
            <select name="jabatan" id="jabatan" class="select">
                <option value="">-- Pilih jabatan (opsional) --</option>
                <option value="Ketua Umum">Ketua Umum</option>
                <option value="Wakil Ketua">Wakil Ketua</option>
                <option value="Sekretaris">Sekretaris</option>
                <option value="Bendahara">Bendahara</option>
                <option value="Anggota">Anggota</option>
            </select>
        </div>

        <div class="field">
            <label for="foto">Foto <span class="optional">(opsional)</span></label>
            <input
                type="file"
                id="foto"
                name="foto"
                accept="image/jpeg, image/png, image/jpg"
                @if ($errors->has('foto')) aria-invalid="true" aria-describedby="foto-error" @endif
            >
            @error('foto')
                <p class="field-error" id="foto-error">{{ $message }}</p>
            @enderror
            <p class="hint">Format: JPG, PNG. Maksimal 5MB. Foto akan di-resize otomatis.</p>
        </div>

        <div class="form-actions">
            <button class="btn btn--primary" type="submit">Simpan anggota</button>
            <a class="btn btn--ghost" href="{{ route('dashboard') }}">Batal</a>
        </div>
    </form>
@endsection