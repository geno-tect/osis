<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeritaAdminController extends Controller
{
    public function create()
    {
        return view('berita.buat');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('gambar')) {
            $data['gambar'] = 'storage/'.$request->file('gambar')->store('berita', 'public');
        }
        Berita::query()->create($data);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('berita.ubah', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validatedData($request, $berita);
        if ($request->hasFile('gambar')) {
            $newImage = 'storage/'.$request->file('gambar')->store('berita', 'public');
            $this->deleteUploadedImage($berita->gambar);
            $data['gambar'] = $newImage;
        } elseif ($request->boolean('remove_gambar')) {
            $this->deleteUploadedImage($berita->gambar);
            $data['gambar'] = null;
        }
        $berita->update($data);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $this->deleteUploadedImage($berita->gambar);
        $berita->delete();

        return redirect()->route('dashboard')->with('success', 'Berita berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Berita $berita = null): array
    {
        $judul = (string) $request->input('judul', '');
        $slug = trim((string) $request->input('slug', ''));
        if ($slug === '') {
            $slug = $berita && $judul === $berita->judul ? $berita->slug : Str::slug($judul);
            $baseSlug = $slug;
            $suffix = 2;
            while (Berita::query()->where('slug', $slug)->when($berita, fn ($query) => $query->whereKeyNot($berita->id))->exists()) {
                $slug = Str::limit($baseSlug, 175, '').'-'.$suffix++;
            }
            $request->merge(['slug' => $slug]);
        }

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180', 'alpha_dash', Rule::unique('berita', 'slug')->ignore($berita?->id)],
            'kategori' => ['required', 'string', 'max:80'],
            'tanggal' => ['required', 'date'],
            'ringkasan' => ['required', 'string', 'max:2000'],
            'isi' => ['required', 'string', 'max:20000'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'remove_gambar' => ['sometimes', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug']);
        $data['isi'] = collect(preg_split('/\R\s*\R/', trim($data['isi'])))
            ->map(fn (string $paragraph) => trim($paragraph))
            ->filter()
            ->values()
            ->all();
        unset($data['remove_gambar']);
        unset($data['gambar']);

        return $data;
    }

    private function deleteUploadedImage(?string $gambar): void
    {
        if ($gambar && str_starts_with($gambar, 'storage/berita/')) {
            Storage::disk('public')->delete(substr($gambar, strlen('storage/')));
        }
    }
}
