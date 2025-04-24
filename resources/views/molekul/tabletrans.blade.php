<div class="table-responsive">
    <table id="{{ $tableId }}" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Jenis Transaksi</th>
                <th>Jumlah</th>
                <th>Bukti Transaksi</th>
                <th>Keterangan</th>
                @if ($status == '1')
                    <th>Action</th>
                @endif
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
                        <img src="{{ asset('uploads/' . $item->gambar->namagambar) }}" class="product-img-2"
                            alt="product img" onclick="ViewImage('{{ asset('uploads/' . $item->gambar->namagambar) }}')">

                    </td>
                    @if ($status == '3')
                        <td>{{ $item->alasan }}</td> <!-- Menampilkan nama user -->
                    @else
                        <td>{{ $item->keterangan }}</td> <!-- Menampilkan nama user -->
                    @endif

                    @if ($status == '1')
                        <td>
                            <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                onclick="etitTrans({{ $item->id }},2)">
                                Setujui
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                onclick="etitTrans({{ $item->id }},3)">
                                Tolak
                            </a>
                        </td>
                    @endif

                </tr>
            @endforeach

        </tbody>
    </table>
</div>

<!-- Modal for Edit Toko -->
<div class="modal fade" id="editTrans" tabindex="-1" aria-labelledby="editTransLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTransLabel">Edit @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="edit-id">
                    <input type="hidden" id="edit-status">
                    <input type="hidden" id="edit-author" value="{{ Auth::user()->id }}">

                    <div class="mb-3">
                        <label for="edit-alasan" class="form-label">Alasan</label>
                        <textarea class="form-control" id="edit-alasan" cols="30" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
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

    function dataTables(tableId) {
        // Cek apakah DataTable sudah ada pada tabel yang ditentukan
        if (!$.fn.dataTable.isDataTable(tableId)) {
            // Inisialisasi DataTable hanya jika belum ada DataTable yang diinisialisasi
            $(tableId).DataTable({
                paging: true, // Mengaktifkan pagination
                searching: true, // Mengaktifkan pencarian
                ordering: true, // Mengaktifkan pengurutan
                info: true, // Menampilkan informasi jumlah data
                lengthChange: true // Mengaktifkan pemilihan jumlah per halaman
            });
        }
    }
    // Edit Toko Function
    function etitTrans(id, status) {
        // const url = `{{ url('anggota') }}/` + id;
        const updateUrl = "{{ route('transaksibyid', ':id') }}";
        const url = updateUrl.replace(':id', id);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-status').value = status;
                document.getElementById('edit-alasan').value = '';
                var editModal = new bootstrap.Modal(document.getElementById('editTrans'));
                editModal.show();
            })
            .catch(error => {
                console.error("Error fetching data: ", error);
            });
    }
    // Inisialisasi DataTable
    document.addEventListener('DOMContentLoaded', function() {
        dataTables('#{{ $tableId }}');
    });

    function notifikasi(response = 'success', massage = 'berhasil', icon = 'bx bx-check-circle') {
        Lobibox.notify(response, {
            pauseDelayOnHover: true,
            size: 'mini',
            rounded: true,
            delayIndicator: false,
            icon: icon,
            continueDelayOnInactiveTab: false,
            position: 'top right',
            msg: massage,
            sound: false,
        });
    }
</script>
