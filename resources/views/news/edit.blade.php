<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit berita</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui berita dan dokumentasinya.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" action="{{ route('news.update', $news) }}" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                @include('news._form', ['news' => $news])
            </form>
        </div>
    </div>
</x-app-layout>
