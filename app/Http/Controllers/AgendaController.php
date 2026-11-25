<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AgendaController extends Controller
{
    public function create()
    {
        return view('agenda.buat');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('gambar')) {
            $data['gambar'] = 'storage/'.$request->file('gambar')->store('agenda', 'public');
        }
        Agenda::query()->create($data);

        return redirect()->route('dashboard')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('agenda.ubah', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('gambar')) {
            $this->deleteUploadedImage($agenda->gambar);
            $data['gambar'] = 'storage/'.$request->file('gambar')->store('agenda', 'public');
        } elseif ($request->boolean('remove_gambar')) {
            $this->deleteUploadedImage($agenda->gambar);
            $data['gambar'] = null;
        }
        $agenda->update($data);

        return redirect()->route('dashboard')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $this->deleteUploadedImage($agenda->gambar);
        $agenda->delete();

        return redirect()->route('dashboard')->with('success', 'Agenda berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'tanggal_mulai' => ['required', 'date'],
            'deskripsi' => ['required', 'string', 'max:5000'],
            'status' => ['required', 'string', 'max:50'],
            'warna_status' => ['required', Rule::in(['amber', 'sky', 'slate'])],
            'rincian' => ['nullable', 'string', 'max:5000'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'remove_gambar' => ['sometimes', 'boolean'],
        ]);

        unset($data['remove_gambar']);

        return $data;
    }

    private function deleteUploadedImage(?string $gambar): void
    {
        if ($gambar && str_starts_with($gambar, 'storage/agenda/')) {
            Storage::disk('public')->delete(substr($gambar, strlen('storage/')));
        }
    }
}
