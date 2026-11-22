<?php

namespace App\Http\Controllers;

use App\Models\Osis;
use Illuminate\Http\Request;

class OsisController extends Controller
{
    public function create()
    {
        return view('osis.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_osis' => 'required|string|max:50|unique:osis,id_osis',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'sekbid' => 'required|string|max:100',
        ]);

        Osis::create($validate);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data OSIS berhasil disimpan!');
    }

    public function edit($id)
    {
        $osis = Osis::findOrFail($id);

        return view('osis.edit', compact('osis'));
    }

    public function update(Request $request, $id)
    {
        $osis = Osis::findOrFail($id);

        $validate = $request->validate([
            'id_osis' => 'required|string|max:50|unique:osis,id_osis,'.$osis->id,
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'sekbid' => 'required|string|max:100',
        ]);

        $osis->update($validate);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data OSIS berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $osis = Osis::findOrFail($id);

        $osis->delete();

        return back(fallback: route('dashboard'))
            ->with('success', 'Data OSIS berhasil dihapus!');
    }
}
