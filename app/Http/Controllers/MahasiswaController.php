<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.index');
    }

    public function getData()
    {
        $mahasiswas = Mahasiswa::latest()->get();
        return response()->json(['data' => $mahasiswas]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'prodi' => 'required',
        ]);

        Mahasiswa::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        return response()->json($mahasiswa);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $id,
            'prodi' => 'required',
        ]);

        Mahasiswa::find($id)->update($request->all());

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function destroy($id)
    {
        Mahasiswa::destroy($id);
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
