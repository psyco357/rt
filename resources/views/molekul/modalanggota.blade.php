<!-- Modal Add New Anggota -->
<div class="modal fade" id="modalAnggota" tabindex="-1" aria-labelledby="modalAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAnggotaLabel">Add New Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAnggotaForm">
                    {{-- @dd($columns) --}}
                    @csrf
                    <div class="mb-3">
                        <label for="noktp" class="form-label">No Ktp</label>
                        <input type="text" class="form-control" id="noktp">
                    </div>
                    <div class="mb-3">
                        <label for="namaanggota" class="form-label">Nama Anggota</label>
                        <input type="text" class="form-control" id="namaanggota">
                    </div>
                    <div class="mb-3">
                        <label for="notelp" class="form-label">No Telp.</label>
                        <input type="text" class="form-control" id="notelp">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Anggota</label>
                        <textarea class="form-control" id="alamat" cols="30" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Anggota</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <p><strong>Nama : </strong> <span id="view-nama"></span></p>
                <p><strong>No Telpon : </strong> <span id="view-notelpon"></span></p>
                <p><strong>Alamat : </strong> <span id="view-alamat"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit Toko -->
<div class="modal fade" id="editTokoModal" tabindex="-1" aria-labelledby="editTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTokoModalLabel">Edit @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTokoForm">
                    @csrf
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-ktp" class="form-label">No Ktp</label>
                        <input type="text" class="form-control" id="edit-ktp">
                    </div>
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama Anggota</label>
                        <input type="text" class="form-control" id="edit-nama">
                    </div>
                    <div class="mb-3">
                        <label for="edit-no_telepon" class="form-label">No Telp.</label>
                        <input type="text" class="form-control" id="edit-no_telepon">
                    </div>
                    <div class="mb-3">
                        <label for="edit-alamat" class="form-label">Alamat Anggota</label>
                        <textarea class="form-control" id="edit-alamat" cols="30" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteTokoModal" tabindex="-1" aria-labelledby="deleteTokoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTokoModalLabel">Delete @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this <strong>@yield('title')</stong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirm-delete" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-success px-5" onclick="notifikasi()"><i
        class="bx bx-check-circle mr-1"></i>Success</button>
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
    // document.addEventListener('DOMContentLoaded', function() {
    // Handle the Add New Toko Form Submission
    document.getElementById('addAnggotaForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Ambil CSRF Token dari form input hidden
        var csrfToken = document.querySelector('input[name="_token"]').value;

        var ktp = document.getElementById('noktp').value;
        var nama = document.getElementById('namaanggota').value;
        var no_telepon = document.getElementById('notelp').value;
        var alamat = document.getElementById('alamat').value;
        // var alamattoko = document.getElementById('notelp').value;

        // Siapkan data untuk dikirimkan
        var data = {
            _token: csrfToken,
            ktp: ktp,
            nama: nama,
            no_telepon: no_telepon,
            alamat: alamat,
        };

        // Kirim data menggunakan fetch
        const createUrl = "{{ route('saveanggota') }}";
        fetch(createUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data), // Mengirim data dalam format JSON
            })
            .then(response => response.json())
            .then(response => {
                // alert(response.success);
                notifikasi('success', response.success, 'bx bx-check-circle');
                var addModal = new bootstrap.Modal(document.getElementById('modalAnggota'));
                addModal.hide();
                location
                    .reload(); // Memuat ulang halaman untuk melihat toko yang baru ditambahkan
            })
            .catch(error => {
                notifikasi('error', error, 'bx bx-x-circle');
                // console.error('Error adding toko:', error);
            });
    });
    // });

    // View Toko Function
    function viewToko(id) {
        const url = `{{ url('anggota') }}/` + id;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                document.getElementById('view-ktp').textContent = data.ktp;
                document.getElementById('view-nama').textContent = data.nama;
                document.getElementById('view-notelpon').textContent = data.no_telepon;
                document.getElementById('view-alamat').textContent = data.alamat;
                var viewModal = new bootstrap.Modal(document.getElementById('viewTokoModal'));
                viewModal.show();
            })
            .catch(error => {
                console.error("Error fetching data: ", error);
            });
    }

    // Edit Toko Function
    function editToko(id) {
        const url = `{{ url('anggota') }}/` + id;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-ktp').value = data.ktp;
                document.getElementById('edit-nama').value = data.nama;
                document.getElementById('edit-no_telepon').value = data.no_telepon;
                document.getElementById('edit-alamat').value = data.alamat;
                var editModal = new bootstrap.Modal(document.getElementById('editTokoModal'));
                editModal.show();
            })
            .catch(error => {
                console.error("Error fetching data: ", error);
            });
    }

    // Handle the Edit Form Submission
    document.getElementById('editTokoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // console.log('edits');
        var csrfToken = document.querySelector('input[name="_token"]').value;
        var id = document.getElementById('edit-id').value;
        var ktp = document.getElementById('edit-ktp').value;
        var nama = document.getElementById('edit-nama').value;
        var no_telepon = document.getElementById('edit-no_telepon').value;
        var alamat = document.getElementById('edit-alamat').value;

        // Prepare data to send with fetch (FormData can also be used here)
        var data = {
            _token: csrfToken,
            ktp: ktp,
            nama: nama,
            no_telepon: no_telepon,
            alamat: alamat,
        };
        const updateUrl = "{{ route('updateanggota', ':id') }}";
        const url = updateUrl.replace(':id', id);
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data), // Sending JSON data
            })
            .then(response => response.json())
            .then(response => {
                notifikasi('success', response.success, 'bx bx-check-circle');

                var editModal = new bootstrap.Modal(document.getElementById('editTokoModal'));
                editModal.hide();
                location.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                notifikasi('error', error, 'bx bx-x-circle');
                // console.error('Error updating toko:', error);
            });
    });

    // Delete Confirmation Function
    function confirmDelete(id) {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteTokoModal'));
        deleteModal.show();

        document.getElementById('confirm-delete').addEventListener('click', function() {
            const updateUrl = "{{ route('deleteanggota', ':id') }}";
            const url = updateUrl.replace(':id', id);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: document.querySelector('input[name="_token"]').value,
                    }), // Sending CSRF token with the DELETE request
                })
                .then(response => response.json())
                .then(response => {
                    notifikasi('success', response.success, 'bx bx-check-circle');
                    deleteModal.hide();
                    location.reload(); // Reload the page to reflect changes
                })
                .catch(error => {
                    notifikasi('error', error, 'bx bx-x-circle');
                    // console.error('Error deleting toko:', error);
                });
        });
    }
</script>
