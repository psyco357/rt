@extends('layouts.pages')
@section('title', 'Perubahan Transaksi')
@section('content')
    <div class="card">
        <div class="mb-3 mt-3 ms-3">
            <!-- Tombol Add New Toko -->
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAnggota">
                Add New Anggota
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Ktp</th>
                            <th>Nama Anggota</th>
                            <th>No Telp</th>
                            <th>Alamat Anggota</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td> <!-- Menampilkan nomor urut -->
                                <td>{{ $item->ktp }}</td> <!-- Menampilkan nama user -->
                                <td>{{ $item->nama }}</td> <!-- Menampilkan nama user -->
                                <td>{{ $item->no_telepon }}</td> <!-- Menampilkan posisi user -->
                                <td>{{ $item->alamat }}</td> <!-- Menampilkan posisi user -->
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <!-- View Button -->
                                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="View" data-id="{{ $item->id }}"
                                            onclick="viewToko({{ $item->id }})">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Edit" data-id="{{ $item->id }}"
                                            onclick="editToko({{ $item->id }})">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Delete" data-id="{{ $item->id }}"
                                            onclick="confirmDelete({{ $item->id }})">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('molekul.tableperubahan')
@endsection
