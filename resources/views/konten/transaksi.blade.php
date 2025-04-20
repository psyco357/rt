@extends('layouts.pages')
@section('title', 'Transaksi')
@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Menampilkan pesan error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="border p-4 rounded">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Transaksi Baru</h5>
                        </div>
                        <hr />

                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="ktp" class="col-sm-3 col-form-label">Masukan NIK</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="ktp" name="ktp"
                                        onkeyup="checkNumber(this)" placeholder="Masukan NIK">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jenistransaksi" class="col-sm-3 col-form-label">Jenis Transaksi</label>
                                <div class="col-sm-9">
                                    <select name="jenistransaksi" id="jenistransaksi" class="form-control">
                                        @foreach ($jenis as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->namajenis }}</option>)
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jumlah" class="col-sm-3 col-form-label">Nominal</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="text" class="form-control" id="jumlah" name="jumlah"
                                            onkeyup="formatAngka(this)" placeholder="Masukkan Nominal">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="gambar" class="col-sm-3 col-form-label">Bukti Tranfer</label>
                                <div class="col-sm-9">
                                    {{-- <input class="form-control" type="file" id="formFile"> --}}
                                    <input class="form-control" type="file" id="gambar" name="gambar"
                                        onchange="cekGambar(this)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukan Keterangan"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary px-5">Simpan Transaksi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
@endsection
@push('scripts')
    <script>
        function checkNumber(input) {
            const nilaiAwal = input.value;
            const angkaSaja = nilaiAwal.replace(/[^0-9]/g, '');

            if (nilaiAwal !== angkaSaja) {
                alert("Hanya angka yang diperbolehkan!");
                input.value = angkaSaja; // Hapus huruf/simbol dari input
            }
        }

        function formatAngka(input) {
            const nilaiAwal = input.value;

            // Boleh ada titik (karena formatting), jadi kita cek apakah ada karakter non-angka dan bukan titik
            const adaKarakterTidakValid = /[^0-9.]/.test(nilaiAwal);

            if (adaKarakterTidakValid) {
                alert("Hanya angka yang diperbolehkan!");
            }

            // Hilangkan semua karakter yang bukan angka untuk formatting
            const angkaBersih = nilaiAwal.replace(/[^0-9]/g, '');

            // Format angka ke ribuan
            input.value = angkaBersih.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function cekGambar(input) {
            const file = input.files[0];

            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert("Hanya file gambar yang diperbolehkan (JPG, PNG, GIF, WEBP)");
                    input.value = ""; // reset input
                }
            }
        }
    </script>
@endpush
