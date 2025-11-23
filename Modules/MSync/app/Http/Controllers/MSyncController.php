<?php

namespace Modules\MSync\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MSync\Models\IdentitasSync;

class MSyncController extends Controller
{
    public function index()
    {
        $msyncs = IdentitasSync::latest()->paginate(5);
        return view('msync::msyncs.index', compact('msyncs'));
    }

    public function create()
    {
        return view('msync::msyncs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'fakultas' => 'required',
            'universitas' => 'required',
        ]);

        IdentitasSync::create($request->all());

        return redirect()->route('msync.index')
                         ->with('success', 'Data berhasil disimpan.');
    }

    public function show(IdentitasSync $msync)
    {
        return view('msync::msyncs.show', compact('msync'));
    }

    public function edit(IdentitasSync $msync)
    {
        return view('msync::msyncs.edit', compact('msync'));
    }

    public function update(Request $request, IdentitasSync $msync)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'fakultas' => 'required',
            'universitas' => 'required',
        ]);

        $msync->update($request->all());

        return redirect()->route('msync.index')
                         ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(IdentitasSync $msync)
    {
        $msync->delete();

        return redirect()->route('msync.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}
