@extends('layouts.pages')
@section('title', 'Data Transaksi')
@section('content')


    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#proses" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Data Masuk</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#setujui" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Setujui</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tolak" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Di Tolak</div>
                            </div>
                        </a>
                    </li>

                </ul>
                <div class="tab-content py-3">
                    <div class="tab-pane fade show active" id="proses" role="tabpanel">
                        @include('molekul.tabletrans', [
                            'data' => $dataMasuk,
                            'tableId' => 'transaksi-table-1',
                            'status' => '1',
                        ])
                    </div>
                    <div class="tab-pane fade" id="setujui" role="tabpanel">
                        @include('molekul.tabletrans', [
                            'data' => $dataSetujui,
                            'tableId' => 'transaksi-table-2',
                            'status' => '2',
                        ])
                    </div>
                    <div class="tab-pane fade" id="tolak" role="tabpanel">
                        @include('molekul.tabletrans', [
                            'data' => $dataTolak,
                            'tableId' => 'transaksi-table-3',
                            'status' => '3',
                        ])
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Handle form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // console.log('edits');
            var csrfToken = document.querySelector('input[name="_token"]').value;
            var id = document.getElementById('edit-id').value;
            var status = document.getElementById('edit-status').value;
            var trans = document.getElementById('edit-trans').value;
            var author = document.getElementById('edit-author').value;
            var alasan = document.getElementById('edit-alasan').value;


            // Prepare data to send with fetch (FormData can also be used here)
            var data = {
                _token: csrfToken,
                status: status,
                trans: trans,
                alasan: alasan,
                author: author,
            };
            const updateUrl = "{{ route('updatetransaksi', ':id') }}";
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
                    if (response.success) {
                        notifikasi('success', response.message, 'bx bx-check-circle');
                        var editModal = new bootstrap.Modal(document.getElementById('editTrans'));
                        editModal.hide();
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        notifikasi('error', response.message, 'bx bx-x-circle');
                    }

                })
                .catch(error => {
                    console.log(error);
                    notifikasi('error', error, 'bx bx-x-circle');
                    // console.error('Error updating toko:', error);
                });
        });
    </script>
@endsection
