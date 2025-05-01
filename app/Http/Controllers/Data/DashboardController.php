<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $totalHariIni = TransaksiModel::where('idanggota', $user->id)
            ->whereDate('created_at', today())
            ->sum('jumlah');

        // Menghitung persentase perubahan (bisa disesuaikan dengan kebutuhan)
        $persentaseMasuk = $this->calculatePersentase($user->id, 'masuk');
        $persentaseKeluar = $this->calculatePersentase($user->id, 'keluar');

        // Mengirim data ke view
        return view('konten.dashboard', [
            'totalUangMasuk' => $totalUangMasuk,
            'totalUangKeluar' => $totalUangKeluar,
            'totalHariIni' => $totalHariIni,
            'persentaseMasuk' => $persentaseMasuk,
            'persentaseKeluar' => $persentaseKeluar
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
