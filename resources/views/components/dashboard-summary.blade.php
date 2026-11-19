@props([
    'totalAnggota',
    'totalSekbid',
    'anggotaTerbaru',
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

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 px-5 py-4 dark:border-gray-700">
            <div>
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">Anggota terbaru</h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                    Lima data terakhir yang ditambahkan.
                </p>
            </div>

            <a href="{{ route('osis.index') }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                Lihat semua
            </a>
        </div>

        @if ($anggotaTerbaru->isEmpty())
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
                                Sekbid
                            </th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($anggotaTerbaru as $item)
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
                                    {{ $item->sekbid }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right text-sm">
                                    <a href="{{ route('osis.edit', $item->id) }}"
                                       class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
