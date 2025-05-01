@extends('layouts.pages')
@section('title', 'Profil')
@push('styles')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endpush
@section('content')


    <div class="profile-cover bg-dark"></div>

    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-0">My Account</h5>
                    <hr>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">USER INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('user.update') }}">
                                @csrf
                                <input type="hidden" class="form-control" name="iduser" value="{{ $user->id }}">

                                <div class="col-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username"
                                        value="{{ $user->username }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Email address</label>
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="namaanggota"
                                        value="{{ $user->anggota->nama }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">No Telp</label>
                                    <input type="text" class="form-control" name="no_telepon"
                                        value="{{ $user->anggota->no_telepon }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamatanggota" class="form-control" rows="2" col="10">{{ $user->anggota->alamat }}
                                    </textarea>
                                    {{-- <input type="text" class="form-control" name="alamatanggota"
                                        value="{{ $user->anggota->alamat }}"> --}}
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password" class="form-control" id="newPassword"
                                            autocomplete="new-password">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('newPassword', 'passwordIcon1')">
                                            <i class="fas fa-eye" id="passwordIcon1"></i> <!-- Eye icon -->
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password_confirmation" class="form-control"
                                            id="newPasswordConfirmation" autocomplete="new-password">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('newPasswordConfirmation', 'passwordIcon2')">
                                            <i class="fas fa-eye" id="passwordIcon2"></i> <!-- Eye icon -->
                                        </button>
                                    </div>
                                </div>

                        </div>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--end row-->


@endsection
@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const passwordField = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);

            // If the password is currently hidden, show it
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
