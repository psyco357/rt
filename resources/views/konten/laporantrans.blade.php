@extends('layouts.pages')
@section('title', 'Laporan Transaksi')
@section('content')
    <div class="card">
        <div class="mb-3 mt-3 ms-3">
            <button type="button" class="btn btn-info">Jumlah Khas Saat ini : Rp. {{ number_format($total, 2, '.', ',') }}
            </button>
            {{-- <span class="badge rounded-pill bg-info text-dark">Jumlah Khas Saat ini :
                {{ number_format($total, 2, ',', '.') }} </span> --}}
        </div>
        <div class="card-body">
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
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->jenistransaksi->namajenis }}</td>
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
