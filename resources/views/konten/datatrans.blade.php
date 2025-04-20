@extends('layouts.pages')
@section('title', 'Data Transaksi')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Data Transaksi</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Jenis Transaksi</th>
                            <th>Jumlah</th>
                            <th>Bukti Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $key => $item)
                            {{-- @dd($item) --}}
                            <tr>
                                <td>{{ $key + 1 }}</td> <!-- Menampilkan nomor urut -->
                                <td>{{ $item->anggota->nama }}</td> <!-- Menampilkan nama user -->
                                <td>{{ $item->jenistransaksi->namajenis }}</td> <!-- Menampilkan nama user -->
                                <td>{{ 'Rp. ' . number_format($item->jumlah, 2, '.', ',') }}</td>
                                <!-- Menampilkan posisi user -->
                                <td>
                                    <!-- Thumbnail image -->
                                    <img src="{{ asset('storage/uploads/' . $item->gambar->namagambar) }}"
                                        class="product-img-2" alt="product img"
                                        onclick="ViewImage('{{ asset('storage/uploads/' . $item->gambar->namagambar) }}')">

                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function ViewImage(imageUrl) {
            // Membuat elemen modal
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = 0;
            modal.style.left = 0;
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            modal.style.zIndex = 9999; // Pastikan modal di atas elemen lainnya

            // Membuat elemen gambar
            const img = document.createElement('img');
            img.src = imageUrl;
            img.style.maxWidth = '90%';
            img.style.maxHeight = '90%';
            img.style.transition = 'transform 0.2s ease-in-out';
            let scale = 1;

            // Fungsi untuk memperbesar gambar
            img.onclick = function() {
                scale = scale === 1 ? 1.5 : 1; // Jika gambar dalam ukuran normal, perbesar, jika sudah besar, perkecil
                img.style.transform = `scale(${scale})`;
            };

            // Membuat tombol close
            const closeBtn = document.createElement('button');
            closeBtn.textContent = 'Close';
            closeBtn.style.position = 'absolute';
            closeBtn.style.top = '20px';
            closeBtn.style.right = '20px';
            closeBtn.style.backgroundColor = 'white';
            closeBtn.style.border = 'none';
            closeBtn.style.padding = '10px';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.fontSize = '16px';
            closeBtn.style.fontWeight = 'bold';
            closeBtn.style.borderRadius = '5px';
            closeBtn.style.boxShadow = '0 2px 6px rgba(0, 0, 0, 0.3)';

            // Fungsi untuk menutup modal saat tombol ditekan
            closeBtn.onclick = function() {
                document.body.removeChild(modal);
            };

            // Menambahkan gambar dan tombol close ke modal
            modal.appendChild(img);
            modal.appendChild(closeBtn);

            // Menambahkan modal ke body
            document.body.appendChild(modal);

            // Menutup modal jika mengklik di luar gambar
            modal.onclick = function(event) {
                if (event.target === modal) {
                    document.body.removeChild(modal);
                }
            };
        }
    </script>
@endsection
