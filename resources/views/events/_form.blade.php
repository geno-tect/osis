@csrf
@if ($event)
    @method('PUT')
@endif

<div class="space-y-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama kegiatan</label>
        <input id="title" name="title" type="text" required maxlength="150" value="{{ old('title', $event?->title) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal kegiatan</label>
        <input id="start_date" name="start_date" type="date" required value="{{ old('start_date', $event?->start_date?->toDateString()) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ringkasan</label>
        <textarea id="description" name="description" rows="3" required maxlength="5000"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('description', $event?->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Label status</label>
            <input id="status" name="status" type="text" required maxlength="50" placeholder="Contoh: Pendaftaran dibuka"
                   value="{{ old('status', $event?->status) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="status_tone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Warna status</label>
            <select id="status_tone" name="status_tone" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                <option value="sky" @selected(old('status_tone', $event?->status_tone ?? 'sky') === 'sky')>Biru</option>
                <option value="amber" @selected(old('status_tone', $event?->status_tone) === 'amber')>Amber</option>
                <option value="slate" @selected(old('status_tone', $event?->status_tone) === 'slate')>Abu-abu</option>
            </select>
            @error('status_tone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="detail" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detail tambahan (opsional)</label>
        <textarea id="detail" name="detail" rows="2" maxlength="5000"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('detail', $event?->detail) }}</textarea>
        @error('detail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto kegiatan (opsional)</label>
        @if ($event?->image)
            <div id="event-current-image" class="mt-2 flex items-center gap-3">
                <img src="{{ asset($event->image) }}" alt="Foto {{ $event->title }}" class="h-20 w-32 rounded-md border border-gray-200 object-cover dark:border-gray-700">
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))>
                    Hapus foto saat ini
                </label>
            </div>
        @endif
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:font-semibold dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-100">
        <img id="event-image-preview" alt="Pratinjau foto kegiatan" class="mt-3 hidden h-36 w-64 rounded-md border border-gray-200 object-cover dark:border-gray-700">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pilih JPG, PNG, atau WebP. Maksimal 5 MB. Foto akan tampil di kartu agenda beranda.</p>
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <script>
        document.getElementById('image')?.addEventListener('change', function () {
            const preview = document.getElementById('event-image-preview');
            const file = this.files?.[0];
            if (!preview || !file) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('event-current-image')?.classList.add('hidden');
        });
    </script>
</div>

<div class="mt-8 flex flex-wrap justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Batal</a>
    <button type="submit" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">{{ $event ? 'Simpan perubahan' : 'Tambah agenda' }}</button>
</div>
