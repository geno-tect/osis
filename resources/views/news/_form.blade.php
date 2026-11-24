@csrf
@if ($news)
    @method('PUT')
@endif

<div class="space-y-6">
    @if ($errors->any())
        <div class="rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/30 dark:text-red-200" role="alert">
            <p class="font-semibold">Ada isian yang perlu diperbaiki.</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul berita</label>
        <input id="title" name="title" type="text" required maxlength="180" value="{{ old('title', $news?->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug tautan</label>
        <input id="slug" name="slug" type="text" required readonly maxlength="180" pattern="[A-Za-z0-9_-]+" value="{{ old('slug', $news?->slug) }}" placeholder="Dibuat otomatis dari judul" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Alamat berita dibuat otomatis dari judul.</p>
        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
            <input id="category" name="category" type="text" required maxlength="80" value="{{ old('category', $news?->category) }}" placeholder="Kegiatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal berita</label>
            <input id="date" name="date" type="date" required value="{{ old('date', $news?->date?->toDateString()) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
            @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ringkasan</label>
        <textarea id="excerpt" name="excerpt" rows="3" required maxlength="2000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('excerpt', $news?->excerpt) }}</textarea>
        @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi berita</label>
        <textarea id="body" name="body" rows="10" required maxlength="20000" placeholder="Pisahkan setiap paragraf dengan satu baris kosong." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('body', $news ? implode("\n\n", $news->body ?? []) : '') }}</textarea>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pisahkan paragraf dengan satu baris kosong.</p>
        @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto dokumentasi (opsional)</label>
        @if ($news?->image)
            <div class="mt-2 flex items-center gap-3">
                <img src="{{ asset($news->image) }}" alt="Foto {{ $news->title }}" class="h-20 w-32 rounded-md border border-gray-200 object-cover dark:border-gray-700">
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))>
                    Hapus foto saat ini
                </label>
            </div>
        @endif
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:font-semibold dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-100">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Format JPG, PNG, atau WebP. Maksimal 5 MB.</p>
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<script>
    const newsTitle = document.getElementById('title');
    const newsSlug = document.getElementById('slug');
    const slugifyNewsTitle = (value) => value.toLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '').slice(0, 180);
    newsTitle?.addEventListener('input', () => {
        if (newsSlug) newsSlug.value = slugifyNewsTitle(newsTitle.value);
    });
</script>

<div class="mt-8 flex flex-wrap justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Batal</a>
    <button type="submit" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">{{ $news ? 'Simpan perubahan' : 'Tambah berita' }}</button>
</div>
