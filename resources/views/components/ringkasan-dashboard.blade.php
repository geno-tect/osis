@props([
    'totalAnggota',
    'totalSekbid',
    'anggotaList',
    'agendaList',
    'totalAgendaMendatang',
    'beritaList',
    'aspirasiList',
])

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total anggota</p>
            <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                {{ number_format($totalAnggota, 0, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Anggota yang tercatat di database.
            </p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah sekbid</p>
            <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                {{ number_format($totalSekbid, 0, ',', '.') }}
            </p>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Bidang yang tercatat pada data anggota.
            </p>
        </div>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
            <div>
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">Agenda dan kegiatan</h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                    {{ number_format($totalAgendaMendatang, 0, ',', '.') }} agenda mendatang tampil di beranda.
                </p>
            </div>
            <a href="{{ route('agenda.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                Tambah agenda
            </a>
        </div>

        @if ($agendaList->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-medium text-gray-800 dark:text-gray-200">Belum ada agenda.</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tambahkan agenda agar tampil di beranda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Agenda</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($agendaList as $item)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->tanggal_mulai->locale('id')->translatedFormat('d M Y') }}
                                    @if ($item->tanggal_mulai->isPast() && ! $item->tanggal_mulai->isToday())
                                        <span class="ml-1 text-xs">(lewat)</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->judul }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $item->status }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-right text-sm">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('agenda.edit', $item) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Edit</a>
                                        <form method="POST" action="{{ route('agenda.destroy', $item) }}" onsubmit="return confirm('Hapus agenda ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <section class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800" aria-labelledby="dashboard-news-title">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
            <div>
                <h2 id="dashboard-news-title" class="font-semibold text-gray-800 dark:text-gray-200">Berita &amp; dokumentasi</h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ count($beritaList) }} liputan tampil di beranda.</p>
            </div>
            <a href="{{ route('berita.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Tambah berita</a>
        </div>

        @if ($beritaList->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-medium text-gray-800 dark:text-gray-200">Belum ada berita.</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Liputan kegiatan akan tampil di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Berita</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($beritaList as $article)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $article->tanggal->locale('id')->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $article->judul }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $article->kategori }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-right text-sm">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('berita.edit', $article) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Edit</a>
                                        <form method="POST" action="{{ route('berita.destroy', $article) }}" onsubmit="return confirm('Hapus berita ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <section class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800" aria-labelledby="dashboard-aspirations-title">
        <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
            <h2 id="dashboard-aspirations-title" class="font-semibold text-gray-800 dark:text-gray-200">Aspirasi masuk</h2>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ number_format($aspirasiList->count(), 0, ',', '.') }} aspirasi tersimpan. Pesan hanya terlihat di dashboard admin.</p>
        </div>

        @if ($aspirasiList->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-medium text-gray-800 dark:text-gray-200">Belum ada aspirasi masuk.</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aspirasi baru akan muncul di sini setelah dikirim.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal masuk</th>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Nama</th>
                            <th scope="col" class="min-w-[24rem] px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Isi aspirasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($aspirasiList as $aspiration)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-3 align-top text-sm text-gray-500 dark:text-gray-400">{{ $aspiration->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</td>
                                <td class="whitespace-nowrap px-5 py-3 align-top text-sm text-gray-500 dark:text-gray-400">{{ $aspiration->kategori }}</td>
                                <td class="whitespace-nowrap px-5 py-3 align-top text-sm text-gray-800 dark:text-gray-200">{{ $aspiration->nama ?: 'Anonim' }}</td>
                                <td class="px-5 py-3 align-top text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $aspiration->pesan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
            <div>
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">Data anggota</h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                    Semua anggota yang tercatat di database.
                </p>
            </div>
        </div>

        @if ($anggotaList->isEmpty())
            <div class="px-5 py-10 text-center">
                <p class="font-medium text-gray-800 dark:text-gray-200">Belum ada anggota.</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Tambahkan anggota pertama lewat tombol di atas.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                Nama
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                ID OSIS
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                Kelas
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                Jurusan
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                Jabatan
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                Foto
                            </th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($anggotaList as $item)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                    {{ $item->nama }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->id_osis }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->kelas }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->jurusan }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->jabatan ?? 'Anggota' }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/osis/' . $item->foto) }}" alt="Foto" class="dashboard-foto-thumb" width="40">
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right text-sm">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('osis.edit', $item->id) }}"
                                           class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('osis.destroy', $item->id) }}"
                                              onsubmit="return confirm('Hapus anggota ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    aria-label="Hapus {{ $item->nama }}"
                                                    class="font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
