<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Mengambil data pengguna yang sedang login
        $user = Auth::user();

        // Mengambil data transaksiMTransaksiModel untuk pengguna yang sedang login
        $totalUangMasuk = TransaksiModel::where('idanggota', $user->id)
            ->where('jenistrans', 1)
            ->sum('jumlah');

        $totalUangKeluar = TransaksiModel::where('idanggota', $user->id)
            ->where('jenistrans', 2)
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



        // Mengirim data ke view
        return view('konten.dashboard', [
            'chartData' => $chartData->values()->toJson(),
            'chartKeluar' => $chartKeluar->values()->toJson(),
            'totalUangMasuk' => $totalUangMasuk,
            'totalUangKeluar' => $totalUangKeluar,
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
