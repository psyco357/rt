<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Data\AnggotaController;
use App\Http\Controllers\Data\DashboardController;
use App\Http\Controllers\Data\TransaksiController;
use Illuminate\Support\Facades\Route;
// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'formLogin'])->name('login');
Route::post('/auth', [UserController::class, 'auth']);


Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/anggota', [AnggotaController::class, 'anggotaView'])->name('anggota');
    Route::get('anggota/{id}', [AnggotaController::class, 'getAnggota'])->name('anggotabyid');
    Route::post('anggota/update/{id}', [AnggotaController::class, 'updateAnggota'])->name('updateanggota');
    Route::delete('anggota/delete/{id}', [AnggotaController::class, 'deleteAnggota'])->name('deleteanggota');
    Route::post('/anggota/create', [AnggotaController::class, 'create'])->name('saveanggota');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::Post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/datatrans', [TransaksiController::class, 'dataTrans'])->name('datatrans');
    Route::post('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('updatetransaksi');
    Route::delete('/transaksi/delete/{id}', [TransaksiController::class, 'destroy'])->name('deletetransaksi');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'getTransaksi'])->name('transaksibyid');

    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('laporan');
    Route::get('/perubahan', [TransaksiController::class, 'perubahan'])->name('perubahan');
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
});
