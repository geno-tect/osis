<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard admin
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Ringkasan data anggota OSIS. Kamu bisa menambah dan mengubah data.
                </p>
            </div>

            <a href="{{ route('osis.create') }}"
               class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                Tambah anggota
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-dashboard-summary
                :total-anggota="$totalAnggota"
                :total-sekbid="$totalSekbid"
                :anggota-terbaru="$anggotaTerbaru"
            />
        </div>
    </div>
</x-app-layout>
