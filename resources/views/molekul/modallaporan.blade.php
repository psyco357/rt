<!-- Modal for View Toko -->
<div class="modal fade" id="viewTokoModal" tabindex="-1" aria-labelledby="viewTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTokoModalLabel">View @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>KTP : </strong> <span id="view-ktp"></span></p>
                <p><strong>Jenis Uang : </strong> <span id="view-jenis"></span></p>
                <p><strong>Nama Anggota : </strong> <span id="view-nama"></span></p>
                <p><strong>Jumlah : Rp. </strong> <span id="view-jumlah"></span></p>
                <p><strong>Status : </strong> <span id="view-status"></span></p>
                <p><strong>Di Setujui Oleh : </strong> <span id="view-verif"></span></p>
                <p><strong>Tanggal Verifikasi : </strong> <span id="view-date"></span></p>
                <p><strong>Jumlah Khas Saat ini : Rp. </strong> <span id="view-khas"></span></p>

            </div>
        </div>
    </div>
</div>

<script>
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

    // View Toko Function
    function viewToko(id) {
        const url = `{{ url('laporan') }}/` + id;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('view-ktp').textContent = data.anggota.ktp;
                document.getElementById('view-jenis').textContent = data.jenistransaksi.namajenis;
                document.getElementById('view-nama').textContent = data.anggota.nama;
                document.getElementById('view-jumlah').textContent = data.jumlah.toLocaleString('id-ID');
                document.getElementById('view-status').textContent = data.kategoristatus.namastatus;
                document.getElementById('view-verif').textContent = data.penulis.nama;
                document.getElementById('view-date').textContent = data.updated_at;
                document.getElementById('view-khas').textContent = data.total.toLocaleString('id-ID');
                var viewModal = new bootstrap.Modal(document.getElementById('viewTokoModal'));
                viewModal.show();
            })
            .catch(error => {
                console.error("Error fetching data: ", error);
            });
    }
</script>
