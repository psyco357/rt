<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\TransaksiModel;
use App\Models\Master\KhasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Mengambil data pengguna yang sedang login
        // $user = Auth::user();

        // Mengambil data transaksiMTransaksiModel untuk pengguna yang sedang login
        $totalUangMasuk = TransaksiModel::where('jenistrans', 1)
            ->sum('jumlah');

        $totalUangKeluar = TransaksiModel::where('jenistrans', 2)
            ->sum('jumlah');

        $masuk = TransaksiModel::selectRaw('MONTH(created_at) AS bulan,SUM(jumlah) as total')
            ->whereYear('created_at', today()->year)
            ->where('jenistrans', 1)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');
        $chartData = collect(range(1, 12))->map(function ($bulan) use ($masuk) {
            return $masuk->get($bulan, 0);
        });
        $keluar = TransaksiModel::selectRaw('MONTH(created_at) AS bulan,SUM(jumlah) as total')
            ->whereYear('created_at', today()->year)
            ->where('jenistrans', 2)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');
        $chartKeluar = collect(range(1, 12))->map(function ($bulan) use ($keluar) {
            return $keluar->get($bulan, 0);
        });

        $khas = KhasModel::where('tahun', today()->year)->first();
        $khasSekarang = KhasModel::where('tahun', today()->year)->first();
        $khasLalu = KhasModel::where('tahun', today()->year - 1)->first();
        // var_dump($nilaiSekarang,$);
        $nilaiSekarang = $khasSekarang?->khas ?? 0; // Misalnya field yang dihitung bernama 'nilai'
        $nilaiLalu = $khasLalu?->khas ?? 0;

        // Hitung persentase kenaikan
        if ($nilaiLalu == 0) {
            $persentase = $nilaiSekarang > 0 ? 100 : 0; // anggap 100% jika ada kenaikan dari 0
        } else {
            $persentase = (($nilaiSekarang - $nilaiLalu) / $nilaiLalu) * 100;
        }

        // Format angka jika perlu
        $persentase = round($persentase, 2);

        // echo "Kenaikan: {$persentase}%";
        // die;
        // dd($khas);

        // Mengirim data ke view
        return view('konten.dashboard', [
            'chartData' => $chartData->values()->toJson(),
            'chartKeluar' => $chartKeluar->values()->toJson(),
            'totalUangMasuk' => $totalUangMasuk,
            'totalUangKeluar' => $totalUangKeluar,
            'khas' => $khas,
            'persentase' => $persentase,
        ]);
    }

    // Fungsi untuk menghitung persentase perubahan
    private function calculatePersentase($idanggota, $tipe)
    {
        $hariKemarin = TransaksiModel::where('idanggota', $idanggota)
            ->whereDate('created_at', today()->subDay())
            ->sum('jumlah');
        $hariIni = TransaksiModel::where('idanggota', $idanggota)
            ->whereDate('created_at', today())
            ->sum('jumlah');

        if ($tipe == 'masuk') {
            $hariKemarinMasuk = TransaksiModel::where('idanggota', $idanggota)
                ->where('jenistrans', 1)
                ->whereDate('created_at', today()->subDay())
                ->sum('jumlah');
            $hariIniMasuk = TransaksiModel::where('idanggota', $idanggota)
                ->where('jenistrans', 1)
                ->whereDate('created_at', today())
                ->sum('jumlah');
            return $this->calculatePersen($hariKemarinMasuk, $hariIniMasuk);
        }

        if ($tipe == 'keluar') {
            $hariKemarinKeluar = TransaksiModel::where('idanggota', $idanggota)
                ->where('jenistrans', 2)
                ->whereDate('created_at', today()->subDay())
                ->sum('jumlah');
            $hariIniKeluar = TransaksiModel::where('idanggota', $idanggota)
                ->where('jenistrans', 2)
                ->whereDate('created_at', today())
                ->sum('jumlah');
            return $this->calculatePersen($hariKemarinKeluar, $hariIniKeluar);
        }

        return 0;
    }

    // Fungsi untuk menghitung persentase perubahan
    private function calculatePersen($nilaiKemarin, $nilaiHariIni)
    {
        if ($nilaiKemarin == 0) {
            return $nilaiHariIni > 0 ? 100 : 0; // Jika sebelumnya tidak ada, dan ada di hari ini, maka 100%
        }

        $persen = (($nilaiHariIni - $nilaiKemarin) / $nilaiKemarin) * 100;
        return round($persen, 2);
    }
}
