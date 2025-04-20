<!-- Modal Add New Toko -->
<div class="modal fade" id="addTokoModal" tabindex="-1" aria-labelledby="addTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTokoModalLabel">Add New Toko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTokoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="add-nametoko" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" id="add-nametoko" required>
                    </div>
                    <div class="mb-3">
                        <label for="add-alamattoko" class="form-label">Alamat Toko</label>
                        <input type="text" class="form-control" id="add-alamattoko" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Toko</button>
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
                <h5 class="modal-title" id="viewTokoModalLabel">View Toko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Toko:</strong> <span id="view-nametoko"></span></p>
                <p><strong>Alamat Toko:</strong> <span id="view-alamattoko"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit Toko -->
<div class="modal fade" id="editTokoModal" tabindex="-1" aria-labelledby="editTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTokoModalLabel">Edit Toko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTokoForm">
                    @csrf
                    <input type="hidden" id="edit-toko-id">
                    <div class="mb-3">
                        <label for="edit-nametoko" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" id="edit-nametoko" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-alamattoko" class="form-label">Alamat Toko</label>
                        <input type="text" class="form-control" id="edit-alamattoko" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteTokoModal" tabindex="-1" aria-labelledby="deleteTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTokoModalLabel">Delete Toko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this toko?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirm-delete" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the Add New Toko Form Submission
        document.getElementById('addTokoForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Ambil CSRF Token dari form input hidden
            var csrfToken = document.querySelector('input[name="_token"]').value;

            var nametoko = document.getElementById('add-nametoko').value;
            var alamattoko = document.getElementById('add-alamattoko').value;

            // Siapkan data untuk dikirimkan
            var data = {
                _token: csrfToken,
                nametoko: nametoko,
                alamattoko: alamattoko
            };

            // Kirim data menggunakan fetch
            fetch('/toko/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data), // Mengirim data dalam format JSON
                })
                .then(response => response.json())
                .then(response => {
                    alert(response.success);
                    var addModal = new bootstrap.Modal(document.getElementById('addTokoModal'));
                    addModal.hide();
                    location
                        .reload(); // Memuat ulang halaman untuk melihat toko yang baru ditambahkan
                })
                .catch(error => {
                    console.error('Error adding toko:', error);
                });
        });
    });

    // View Toko Function
    function viewToko(id) {
        fetch(`/toko/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('view-nametoko').textContent = data.nametoko;
                document.getElementById('view-alamattoko').textContent = data.alamattoko;
                var viewModal = new bootstrap.Modal(document.getElementById('viewTokoModal'));
                viewModal.show();
            })
            .catch(error => {
                console.error("Error fetching data: ", error);
            });
    }

    // Edit Toko Function
    function editToko(id) {
        fetch(`/toko/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-toko-id').value = data.id;
                document.getElementById('edit-nametoko').value = data.nametoko;
                document.getElementById('edit-alamattoko').value = data.alamattoko;
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
        var id = document.getElementById('edit-toko-id').value;
        var nametoko = document.getElementById('edit-nametoko').value;
        var alamattoko = document.getElementById('edit-alamattoko').value;

        // Prepare data to send with fetch (FormData can also be used here)
        var data = {
            _token: csrfToken,
            nametoko: nametoko,
            alamattoko: alamattoko
        };

        fetch(`/toko/update/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data), // Sending JSON data
            })
            .then(response => response.json())
            .then(response => {
                alert(response.success);
                var editModal = new bootstrap.Modal(document.getElementById('editTokoModal'));
                editModal.hide();
                location.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                console.error('Error updating data:', error);
            });
    });

    // Delete Confirmation Function
    function confirmDelete(id) {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteTokoModal'));
        deleteModal.show();

        document.getElementById('confirm-delete').addEventListener('click', function() {
            fetch(`/toko/delete/${id}`, {
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
                    alert(response.success);
                    deleteModal.hide();
                    location.reload(); // Reload the page to reflect changes
                })
                .catch(error => {
                    console.error('Error deleting data:', error);
                });
        });
    }
</script>
