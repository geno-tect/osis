@extends('layouts.osis')

@section('title', 'Edit Anggota OSIS')

@section('content')
    <div class="page-head">
        <div class="page-head__text">
            <h1>Edit anggota</h1>
            <p class="lede">Perbarui data <strong>{{ $osis->nama }}</strong>.</p>
        </div>
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

    <form class="form-card" action="{{ route('osis.update', $osis->id) }}" method="POST" enctype="multipart/form-data" data-submit-once>
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
            <select
                id="sekbid"
                name="sekbid"
                class="select"
                required
                @if ($errors->has('sekbid')) aria-invalid="true" aria-describedby="sekbid-error" @endif
            >
                <option value="">-- Pilih sekbid --</option>
                @foreach ($sekbidOptions as $sekbid)
                    <option value="{{ $sekbid }}" @selected(old('sekbid', $osis->sekbid) === $sekbid)>{{ $sekbid }}</option>
                @endforeach
            </select>
            @error('sekbid')
                <p class="field-error" id="sekbid-error">{{ $message }}</p>
            @enderror
            @if ($osis->sekbid && !in_array($osis->sekbid, $sekbidOptions, true))
                <p class="hint">Sekbid lama: {{ $osis->sekbid }}. Pilih sekbid baru dari daftar.</p>
            @endif
        </div>

        <div class="field">
            <label for="jabatan">Jabatan</label>
            <select name="jabatan" id="jabatan" class="select">
                <option value="">-- Pilih jabatan (opsional) --</option>
                <option value="Ketua Umum" {{ $osis->jabatan == 'Ketua Umum' ? 'selected' : '' }}>Ketua Umum</option>
                <option value="Wakil Ketua" {{ $osis->jabatan == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                <option value="Sekretaris" {{ $osis->jabatan == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                <option value="Bendahara" {{ $osis->jabatan == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                <option value="Anggota" {{ $osis->jabatan == 'Anggota' ? 'selected' : '' }}>Anggota</option>
            </select>
        </div>

        <div class="field">
            <label for="foto">Foto</label>
            @if ($osis->foto)
                <div class="foto-preview" id="foto-preview-box">
                    <img src="{{ asset('storage/osis/' . $osis->foto) }}" alt="Foto {{$osis->nama}}" class="foto-preview-img">
                    <p class="foto-preview-desc">Foto saat ini</p>
                    <button type="button" class="btn btn--ghost btn--small hapus-foto" id="btn-hapus-foto" title="Hapus foto">Hapus</button>
                    <input type="hidden" name="hapus_foto" id="hapus_foto" value="0">
                </div>
            @endif
            <label class="foto-upload" for="foto" data-foto-dropzone>
                <img class="foto-upload-preview" data-foto-preview alt="Pratinjau foto baru" hidden>
                <span class="foto-upload-copy"><strong>Pilih gambar</strong> atau seret ke sini<br><small>JPG atau PNG, maksimal 5 MB</small></span>
                <input class="foto-upload-input" type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg" data-foto-input
                    @if ($errors->has('foto')) aria-invalid="true" aria-describedby="foto-error" @endif>
            </label>
            @error('foto')
                <p class="field-error" id="foto-error">{{ $message }}</p>
            @enderror
            <p class="hint">Pilih foto baru untuk mengganti foto saat ini. Biarkan kosong jika tidak ingin mengubahnya.</p>
        </div>

        <div class="form-actions">
            <button class="btn btn--primary" type="submit">Simpan perubahan</button>
            <a class="btn btn--ghost" href="{{ route('dashboard') }}">Batal</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnHapus = document.getElementById('btn-hapus-foto');
            if (btnHapus) {
                btnHapus.addEventListener('click', function() {
                    if (confirm('Yakin ingin menghapus foto ini?')) {
                        const hapusInput = document.getElementById('hapus_foto');
                        if (hapusInput) hapusInput.value = '1';
                        const previewBox = document.getElementById('foto-preview-box');
                        if (previewBox) previewBox.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
