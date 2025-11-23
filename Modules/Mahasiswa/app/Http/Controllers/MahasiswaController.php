<?php
namespace Modules\Mahasiswa\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Mahasiswa\Models\Identitas;
class MahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa::index');
    }
    public function getData()
    {
        $mahasiswas = Identitas::latest()->get();
        return response()->json($mahasiswas);
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
        Identitas::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );
        return response()->json(['success' => 'Data berhasil disimpan.']);
    }
    public function edit($id)
    {
        $mahasiswas = Identitas::find($id);
        return response()->json($mahasiswas);
    }
    public function destroy($id)
    {
        Identitas::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}