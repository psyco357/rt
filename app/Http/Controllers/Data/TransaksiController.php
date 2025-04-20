<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\AnggotaModel;
use App\Models\Data\GambarModel;
use App\Models\Data\JenisTransModel;
use App\Models\Data\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class TransaksiController extends Controller
{
    //
    public function index()
    {
        $jenis = JenisTransModel::all();
        return view('konten.transaksi', compact('jenis'));
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'ktp' => 'required',                          // Validasi KTP
            'jenistransaksi' => 'required|integer',       // Validasi Jenis Transaksi
            'jumlah' => 'required|numeric',               // Validasi Jumlah (Hanya angka)
            'keterangan' => 'required|string',            // Validasi Keterangan
        ]);

        // Mencari anggota berdasarkan KTP
        $anggota = AnggotaModel::where('ktp', $validated['ktp'])->first();

        // Jika anggota tidak ditemukan, tampilkan pesan error
        if (!$anggota) {
            session()->flash('error', 'Nik tidak Valid!');
            return redirect()->back();  // Kembali ke halaman sebelumnya dengan pesan error
        }

        // Jika ada file gambar, simpan gambar ke storage
        $fileName = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '-' . 'bukti' . '.' . $file->getClientOriginalExtension();;

            // Simpan file gambar ke storage
            $file->storeAs('uploads', $fileName, 'public');  // Simpan di storage/public/uploads
            $gambar = GambarModel::create([
                'namagambar' => $fileName,  // Simpan nama file gambar ke database
            ]);

            // Ambil ID gambar yang baru disimpan
            $gambarId = $gambar->id;  // ID gambar yang baru disimpan
        }
        // dd($gambarId);
        // Simpan data transaksi ke database
        try {
            TransaksiModel::create([
                'idanggota' => $anggota->id,              // ID anggota yang ditemukan
                'jenistransaksi' => $validated['jenistransaksi'],  // Jenis transaksi
                'jumlah' => str_replace('.', '', $validated['jumlah']),         // Jumlah transaksi
                'idgambar' => $gambarId,                    // Nama file gambar (null jika tidak ada file)
                'keterangan' => $validated['keterangan'], // Keterangan transaksi
            ]);

            // Jika transaksi berhasil disimpan, tampilkan pesan sukses
            return redirect()->route('transaksi')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan transaksi, tampilkan pesan error
            return redirect()->route('transaksi')->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
        }
    }

    public function dataTrans(Request $request)
    {
        // dd($request->all());
        // $transaksi = TransaksiModel::with(['anggota', 'gambar', 'jenistransaksi'])->get();
        // return datatables()->of($transaksi)
        //     ->addIndexColumn()
        //     ->addColumn('action', function ($row) {
        //         return '<button class="btn btn-sm btn-danger" onclick="deleteData(' . $row->id . ')">Delete</button>';
        //     })
        //     ->rawColumns(['action'])
        //     ->make(true);
        $data = TransaksiModel::with(['anggota', 'gambar', 'jenistransaksi'])->get();
        return view('konten.datatrans', compact('data'));
    }
}
