<?php

namespace App\Http\Controllers;

use App\Models\Osis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OsisController extends Controller
{
    public function create()
    {
        return view('osis.create', [
            'sekbidOptions' => $this->sekbidOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_osis' => 'required|string|max:50|unique:osis,id_osis',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'sekbid' => ['required', 'string', Rule::in($this->sekbidOptions())],
            'jabatan' => 'sometimes|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
        ], [
            'sekbid.required' => 'Sekbid wajib dipilih.',
            'sekbid.in' => 'Pilih sekbid dari daftar yang tersedia.',
        ]);

        $data = array_merge($validate, [
            'jabatan' => $request->filled('jabatan') ? $request->jabatan : 'Anggota',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = 'osis-' . Str::slug($request->nama) . '-' . time() . '.' . $extension;
            $file->storeAs('osis', $filename, 'public');
            $data['foto'] = $filename;
        } else {
            unset($data['foto']);
        }

        Osis::create($data);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data OSIS berhasil disimpan!');
    }

    public function edit($id)
    {
        $osis = Osis::findOrFail($id);

        return view('osis.edit', [
            'osis' => $osis,
            'sekbidOptions' => $this->sekbidOptions(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $osis = Osis::findOrFail($id);

        $validate = $request->validate([
            'id_osis' => 'required|string|max:50|unique:osis,id_osis,'.$osis->id,
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'sekbid' => ['required', 'string', Rule::in($this->sekbidOptions())],
            'jabatan' => 'sometimes|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
            'hapus_foto' => 'sometimes|boolean',
        ], [
            'sekbid.required' => 'Sekbid wajib dipilih.',
            'sekbid.in' => 'Pilih sekbid dari daftar yang tersedia.',
        ]);

        $data = array_merge($validate, [
            'jabatan' => $request->filled('jabatan') ? $request->jabatan : $osis->jabatan,
        ]);

        // Handle photo upload or removal
        if ($request->boolean('hapus_foto')) {
            if ($osis->foto) {
                Storage::disk('public')->delete('osis/' . $osis->foto);
            }
            $data['foto'] = null;
        } elseif ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($osis->foto) {
                Storage::disk('public')->delete('osis/' . $osis->foto);
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $filename = 'osis-' . Str::slug($request->nama) . '-' . time() . '.' . $extension;
            $file->storeAs('osis', $filename, 'public');
            $data['foto'] = $filename;
        } else {
            // Jangan timpa foto lama jika tidak ada file baru yang diunggah
            unset($data['foto']);
        }

        unset($data['hapus_foto']);

        $osis->update($data);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data OSIS berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $osis = Osis::findOrFail($id);

        // Hapus foto jika ada
        if ($osis->foto) {
            Storage::disk('public')->delete('osis/' . $osis->foto);
        }

        $osis->delete();

        return back(fallback: route('dashboard'))
            ->with('success', 'Data OSIS berhasil dihapus!');
    }

    private function sekbidOptions(): array
    {
        return array_column(config('beranda.sekbid'), 'name');
    }
}