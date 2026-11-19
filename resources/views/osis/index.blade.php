@extends('layouts.osis')

@section('title', 'Daftar Anggota OSIS')

@section('content')
    @php $isAdmin = auth()->user()->isAdmin(); @endphp

    <div class="page-head">
        <div class="page-head__text">
            <h1>Daftar Anggota OSIS</h1>
            @if ($isAdmin)
                <p class="lede">Data pengurus OSIS yang tercatat. Tambah atau ubah data lewat tombol di halaman ini.</p>
            @else
                <p class="lede">Data pengurus OSIS yang tercatat. Akun kamu hanya bisa melihat data.</p>
            @endif
        </div>

        @if ($isAdmin)
            <a class="btn btn--primary" href="{{ route('osis.create') }}">Tambah anggota</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert--success" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table class="data-table">
            <caption class="sr-only">Daftar anggota OSIS</caption>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">ID OSIS</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Sekbid</th>
                    @if ($isAdmin)
                        <th scope="col" class="actions">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($osisList as $item)
                    <tr>
                        <td class="num">{{ $loop->iteration }}</td>
                        <td class="id">{{ $item->id_osis }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->jurusan }}</td>
                        <td>{{ $item->sekbid }}</td>
                        @if ($isAdmin)
                            <td class="actions">
                                <div class="row-actions">
                                    <a href="{{ route('osis.edit', $item->id) }}">Edit</a>

                                    <form method="POST"
                                          action="{{ route('osis.destroy', $item->id) }}"
                                          onsubmit="return confirm('Hapus anggota ini? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Hapus {{ $item->nama }}">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 7 : 6 }}">
                            <div class="empty-state">
                                <strong>Belum ada data anggota.</strong>
                                @if ($isAdmin)
                                    <p>Tambahkan anggota pertama untuk mulai mengisi daftar.</p>
                                    <a class="btn btn--ghost" href="{{ route('osis.create') }}">Tambah anggota</a>
                                @else
                                    <p>Data akan muncul di sini setelah admin menambahkannya.</p>
                                @endif
                        </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($osisList->isNotEmpty())
        <p class="table-note">{{ $osisList->count() }} anggota terdaftar.</p>
    @endif
@endsection
