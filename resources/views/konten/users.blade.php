@extends('layouts.pages')
@section('title', 'Users')
@push('styles')
    <style>
        .fade-password {
            display: none;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .fade-password.show {
            display: inline;
            opacity: 1;
        }

        .short-password.hide {
            display: none;
        }

        .clickable-text {
            color: #0d6efd;
            text-decoration: underline;
            cursor: pointer;
        }

        .text-muted {
            font-size: 0.85em;
            color: #6c757d;
            margin-left: 4px;
        }
    </style>
@endpush
@section('content')
    <div class="card">
        <div class="mb-3 mt-3 ms-3">
            <!-- Tombol Add New Toko -->
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalUsers">
                Add New Users
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Anggota</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->anggota->ktp }}</td>
                                <td>{{ $item->anggota->nama }}</td>
                                <td>{{ $item->username }}</td>
                                <td><!-- Versi pendek -->
                                    <span class="short-password clickable-text" id="short-{{ $item->id }}"
                                        onclick="togglePassword({{ $item->id }})">
                                        {{ $item->short_password }}
                                        <span class="text-muted">see more</span>
                                    </span>

                                    <!-- Versi full -->
                                    <span class="full-password fade-password" id="full-{{ $item->id }}"
                                        onclick="togglePassword({{ $item->id }})">
                                        {{ $item->password }} <span class="text-muted">see less</span>
                                    </span>
                                </td>
                                <td>{{ $item->roleUser->name }}</td>
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
    @include('molekul.modalusers')

@endsection
@push('scripts')
    <script>
        function togglePassword(id) {
            const shortEl = document.getElementById('short-' + id);
            const fullEl = document.getElementById('full-' + id);

            const isShortVisible = !shortEl.classList.contains('hide');

            if (isShortVisible) {
                // From short → full
                shortEl.classList.add('hide');
                fullEl.style.display = 'inline';
                setTimeout(() => {
                    fullEl.classList.add('show');
                }, 10);
            } else {
                // From full → short
                fullEl.classList.remove('show');
                setTimeout(() => {
                    fullEl.style.display = 'none';
                    shortEl.classList.remove('hide');
                }, 400); // match transition duration
            }
        }
    </script>
@endpush
