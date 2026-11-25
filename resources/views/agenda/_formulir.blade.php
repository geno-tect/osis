@csrf
@if ($event)
    @method('PUT')
@endif

<div class="space-y-6">
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama kegiatan</label>
        <input id="judul" name="judul" type="text" required maxlength="150" value="{{ old('judul', $event?->judul) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        @error('judul') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal kegiatan</label>
        <input id="tanggal_mulai" name="tanggal_mulai" type="date" required value="{{ old('tanggal_mulai', $event?->tanggal_mulai?->toDateString()) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        @error('tanggal_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ringkasan</label>
        <textarea id="deskripsi" name="deskripsi" rows="3" required maxlength="5000"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('deskripsi', $event?->deskripsi) }}</textarea>
        @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
            <label for="warna_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Warna status</label>
            <select id="warna_status" name="warna_status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                <option value="sky" @selected(old('warna_status', $event?->warna_status ?? 'sky') === 'sky')>Biru</option>
                <option value="amber" @selected(old('warna_status', $event?->warna_status) === 'amber')>Amber</option>
                <option value="slate" @selected(old('warna_status', $event?->warna_status) === 'slate')>Abu-abu</option>
            </select>
            @error('warna_status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="rincian" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detail tambahan (opsional)</label>
        <textarea id="rincian" name="rincian" rows="2" maxlength="5000"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('rincian', $event?->rincian) }}</textarea>
        @error('rincian') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="gambar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto kegiatan (opsional)</label>
        @if ($event?->gambar)
            <div id="event-current-gambar" class="mt-2 flex items-center gap-3">
                <img src="{{ asset($event->gambar) }}" alt="Foto {{ $event->judul }}" class="h-20 w-32 rounded-md border border-gray-200 object-cover dark:border-gray-700">
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <input type="checkbox" name="remove_gambar" value="1" @checked(old('remove_gambar'))>
                    Hapus foto saat ini
                </label>
            </div>
        @endif
        <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:font-semibold dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-100">
        <img id="event-gambar-preview" alt="Pratinjau foto kegiatan" class="mt-3 hidden h-36 w-64 rounded-md border border-gray-200 object-cover dark:border-gray-700">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pilih JPG, PNG, atau WebP. Maksimal 5 MB. Foto akan tampil di kartu agenda beranda.</p>
        @error('gambar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <script>
        document.getElementById('gambar')?.addEventListener('change', function () {
            const preview = document.getElementById('event-gambar-preview');
            const file = this.files?.[0];
            if (!preview || !file) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('event-current-gambar')?.classList.add('hidden');
        });
    </script>
</div>

<div class="mt-8 flex flex-wrap justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Batal</a>
    <button type="submit" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">{{ $event ? 'Simpan perubahan' : 'Tambah agenda' }}</button>
</div>
