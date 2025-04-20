<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\AnggotaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AnggotaController extends Controller
{
    //
    public function anggotaView()
    {
        $columns = Schema::getColumnListing('anggota');
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);
        // dd($columns);
        $data = AnggotaModel::all();
        return view('konten.anggota', compact(['data', 'columns']));
    }
    public function getAnggota($id)
    {
        // Implement your logic to get anggota data by ID
        // For example, return a JSON response with the anggota data
        $data = AnggotaModel::find($id);
        return response()->json($data);
        // return response()->json(['id' => $id]);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'ktp' => 'required',
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required',
            'alamat' => 'required|string|max:255',
        ]);
        $anggota = new AnggotaModel();
        $anggota->ktp = $validatedData['ktp'];
        $anggota->nama = $validatedData['nama'];
        $anggota->no_telepon = $validatedData['no_telepon'];
        $anggota->alamat = $validatedData['alamat'];
        $anggota->tanggal_masuk = date('Y-m-d');
        $anggota->save();
        return response()->json(['success' => 'Anggota berhasil ditambahkan']);
    }

    public function updateAnggota(Request $request, $id)
    {
        // Validasi data
        // dd($request->all());
        $validated = $request->validate([
            'ktp' => 'required',
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required',
            'alamat' => 'required|string|max:255',
        ]);
        // dd($validated);
        // Temukan anggota berdasarkan ID
        $anggota = AnggotaModel::find($id);
        $anggota->ktp = $validated['ktp'];
        $anggota->nama = $validated['nama'];
        $anggota->no_telepon = $validated['no_telepon'];
        $anggota->alamat = $validated['alamat'];

        $anggota->save();

        return response()->json(['success' => 'Data berhasil diperbarui']);

        // return response()->json(['success' => true]);
    }

    public function deleteAnggota($id)
    {
        // Temukan anggota berdasarkan ID
        $anggota = AnggotaModel::find($id);
        $anggota->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
