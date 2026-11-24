<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsAdminController extends Controller
{
    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            $data['image'] = 'storage/'.$request->file('image')->store('news', 'public');
        }
        News::query()->create($data);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $this->validatedData($request, $news);
        if ($request->hasFile('image')) {
            $newImage = 'storage/'.$request->file('image')->store('news', 'public');
            $this->deleteUploadedImage($news->image);
            $data['image'] = $newImage;
        } elseif ($request->boolean('remove_image')) {
            $this->deleteUploadedImage($news->image);
            $data['image'] = null;
        }
        $news->update($data);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $this->deleteUploadedImage($news->image);
        $news->delete();

        return redirect()->route('dashboard')->with('success', 'Berita berhasil dihapus.');
    }

    private function validatedData(Request $request, ?News $news = null): array
    {
        $title = (string) $request->input('title', '');
        $slug = trim((string) $request->input('slug', ''));
        if ($slug === '') {
            $slug = $news && $title === $news->title ? $news->slug : Str::slug($title);
            $baseSlug = $slug;
            $suffix = 2;
            while (News::query()->where('slug', $slug)->when($news, fn ($query) => $query->whereKeyNot($news->id))->exists()) {
                $slug = Str::limit($baseSlug, 175, '').'-'.$suffix++;
            }
            $request->merge(['slug' => $slug]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180', 'alpha_dash', Rule::unique('news', 'slug')->ignore($news?->id)],
            'category' => ['required', 'string', 'max:80'],
            'date' => ['required', 'date'],
            'excerpt' => ['required', 'string', 'max:2000'],
            'body' => ['required', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'remove_image' => ['sometimes', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug']);
        $data['body'] = collect(preg_split('/\R\s*\R/', trim($data['body'])))
            ->map(fn (string $paragraph) => trim($paragraph))
            ->filter()
            ->values()
            ->all();
        unset($data['remove_image']);
        unset($data['image']);

        return $data;
    }

    private function deleteUploadedImage(?string $image): void
    {
        if ($image && str_starts_with($image, 'storage/news/')) {
            Storage::disk('public')->delete(substr($image, strlen('storage/')));
        }
    }
}
