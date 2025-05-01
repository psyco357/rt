@extends('layouts.pages')
@section('title', 'Laporan Transaksi')
@push('styles')
    <!-- jQuery (harus paling atas) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables Core CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>

    <!-- File export plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>

    <!-- Optional: PDF (jika pakai PDF export) -->
    <script src="https://cdn.jsdelivr.net/npm/pdfmake@0.2.7/build/pdfmake.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfmake@0.2.7/build/vfs_fonts.js"></script> --}}
@endpush
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-3 ms-3 me-3">
            <button type="button" class="btn btn-info">
                Jumlah Khas Saat ini : Rp. {{ number_format($total, 2, '.', ',') }}
            </button>
            <div id="export-buttons"></div> <!-- Wadah tombol export -->
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="filter-status">Filter Status</label>
                    <select id="filter-status" class="form-control">
                        <option value="">Pilih Status</option>
                        <option value="Setuju">Setuju</option>
                        <option value="Tolak">Tolak</option>
                        <option value="Proses">Proses</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="filter-jenis-transaksi">Filter Jenis Transaksi</label>
                    <select id="filter-jenis-transaksi" class="form-control">
                        <option value="">Pilih Jenis Transaksi</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                        <!-- Tambahkan opsi jenis transaksi lain jika ada -->
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Uang</th>
                            <th>Nama Anggota</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aothor</th>
                            <th>Tanggal Verifikasi</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $key => $item)
                            {{-- @dd($item->penulis) --}}
                            <tr>
                                <td></td>
                                <td><span
                                        class="text-{{ $item->jenistransaksi->id == 1 ? 'success' : 'danger' }}">{{ $item->jenistransaksi->namajenis }}</span>
                                </td>
                                <td>{{ $item->anggota->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $item->status == 1 ? 'bg-info' : ($item->status == 2 ? 'bg-success' : 'bg-danger') }}">
                                        {{ $item->kategoristatus->namastatus }}</span>


                                </td>
                                <td>{{ $item->status == 2 || $item->status == 3 ? $item->penulis->nama : '-' }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <!-- View Button -->
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="View" data-id="{{ $item->id }}"
                                            onclick="viewToko({{ $item->id }})">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        {{-- <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit" data-id="{{ $item->id }}"
                                            onclick="editToko({{ $item->id }})">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Delete" data-id="{{ $item->id }}"
                                            onclick="confirmDelete({{ $item->id }})">
                                            <i class="bi bi-trash-fill"></i>
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('molekul.modallaporan')
@endsection
