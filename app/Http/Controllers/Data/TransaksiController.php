<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\AnggotaModel;
use App\Models\Data\GambarModel;
use App\Models\Data\JenisTransModel;
use App\Models\Data\TransaksiModel;
use App\Models\Master\KhasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Js;

class TransaksiController extends Controller
{
    //
    public function index()
    {
        $jenis = JenisTransModel::all();
        $anggota = AnggotaModel::find(Auth::user()->idanggota);
        // dd($anggota);
        return view('konten.transaksi', compact(['jenis', 'anggota']));
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

            $tujuanPath = public_path('uploads');

            // Pindahkan file langsung ke folder public/uploads
            $file->move($tujuanPath, $fileName);
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
                'jenistrans' => $validated['jenistransaksi'],  // Jenis transaksi
                'jumlah' => str_replace('.', '', $validated['jumlah']),         // Jumlah transaksi
                'idgambar' => $gambarId,                    // Nama file gambar (null jika tidak ada file)
                'keterangan' => $validated['keterangan'], // Keterangan transaksi
                'status' => 1, // Keterangan transaksi
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
        $user = Auth::user();

        // Buat base query
        $queryMasuk = TransaksiModel::where('status', '1')->with(['anggota', 'gambar', 'jenistransaksi']);
        $querySetujui = TransaksiModel::where('status', '2')->with(['anggota', 'gambar', 'jenistransaksi']);
        $queryTolak = TransaksiModel::where('status', '3')->with(['anggota', 'gambar', 'jenistransaksi']);

        // Jika role 2, tambahkan filter berdasarkan user_id
        if ($user->role == 2) {
            $queryMasuk->where('idanggota', $user->id_anggota);
            $querySetujui->where('idanggota', $user->id_anggota);
            $queryTolak->where('idanggota', $user->id_anggota);
        }

        // Ambil data
        $dataMasuk = $queryMasuk->get();
        $dataSetujui = $querySetujui->get();
        $dataTolak = $queryTolak->get();
        return view('konten.datatrans', compact('dataMasuk', 'dataSetujui', 'dataTolak'));
        // return view('konten.datatrans', compact('data'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            // Validasi input
            $validated = $request->validate([
                'trans' => 'required|integer',  // Validasi status transaksi
                'status' => 'required|integer',  // Validasi status transaksi
                'alasan' => 'required|string',    // Validasi keterangan
                'author' => 'required',    // Validasi keterangan
            ]);

            // Temukan transaksi berdasarkan ID
            $transaksi = TransaksiModel::findOrFail($id);

            // Perbarui status transaksi dan keterangan
            $transaksi->status = $validated['status'];
            $transaksi->alasan = $validated['alasan'];
            $transaksi->author = $validated['author'];
            // $transaksi->save();
            // dd($transaksi);
            if ($transaksi->save()) {
                if ($validated['trans'] == 1) {
                    if ($validated['status'] == 2) {
                        $tahun = now()->year;
                        $khas = KhasModel::where('tahun', $tahun)->first();

                        if ($khas) {
                            $khas->khas += $transaksi->jumlah;
                            $khas->save();
                        } else {
                            KhasModel::create([
                                'tahun' => $tahun,
                                'khas' => $transaksi->jumlah,
                            ]);
                        }
                    }
                } else {
                    if ($validated['status'] == 2) {
                        $tahun = now()->year;
                        $khas = KhasModel::where('tahun', $tahun)->first();

                        if ($khas) {
                            $khas->khas -= $transaksi->jumlah;
                            $khas->save();
                        } else {
                            KhasModel::create([
                                'tahun' => $tahun,
                                'khas' => $transaksi->jumlah,
                            ]);
                        }
                    }
                }
            };


            // Jika update berhasil, kirimkan respons JSON sukses
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Tangani error jika transaksi tidak ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error jika validasi gagal
            return response()->json([
                'success' => false,
                'message' => 'Alasan Tidak Boleh Kosong!.',
                'errors' => $e->errors() // Menyertakan error validasi
            ], 422);
        } catch (\Exception $e) {
            // Tangani kesalahan umum lainnya
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses transaksi.',
                'error' => $e->getMessage() // Mengirim pesan error umum
            ], 500);
        }
    }
    public function destroy($id)
    {
        // Temukan transaksi berdasarkan ID
        $transaksi = TransaksiModel::findOrFail($id);

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('datatrans')->with('success', 'Transaksi berhasil dihapus.');
    }
    public function getTransaksi($id)
    {
        // Temukan transaksi berdasarkan ID
        $transaksi = TransaksiModel::findOrFail($id);

        // Kembalikan data transaksi dalam format JSON
        return response()->json($transaksi);
    }

    public  function laporan()
    {
        $user = Auth::user();

        $queryData = TransaksiModel::with(['anggota', 'gambar', 'jenistransaksi', 'penulis', 'kategoristatus']);
        if ($user->role == 2) {
            $queryData->where('idanggota', $user->id_anggota);
        }

        // Ambil data
        $data = $queryData->get();
        $jumlahkhas = KhasModel::all();
        $total = 0;
        foreach ($jumlahkhas as $khas) {
            $total += $khas->khas;
        }
        return view('konten.laporantrans', compact(['data', 'total']));
    }
    public function perubahan()
    {
        $data = TransaksiModel::with(['anggota', 'gambar', 'jenistransaksi', 'author'])->get();
        // dd($data);
        return view('konten.perubahantrans', compact('data'));
    }
    public function getDetails(Request $request, $id)
    {
        // Temukan transaksi berdasarkan ID
        $transaksi = TransaksiModel::with(['anggota', 'gambar', 'jenistransaksi', 'penulis', 'kategoristatus'])->findOrFail($id);
        $khas = KhasModel::where('tahun', now()->year)->first();
        $transaksi->total = $khas->khas;
        // dd($transaksi);
        // Kembalikan data transaksi dalam format JSON
        return response()->json($transaksi);
    }
}
