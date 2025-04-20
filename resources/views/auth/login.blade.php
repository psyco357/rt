<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href={{ asset('assets/images/favicon-32x32.png') }} type="image/png">
    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap.min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap-extended.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/style.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/icons.css') }}>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <title>Toko - Sign in</title>
</head>

<body>
    <div class="wrapper">
        <main class="authentication-conten">
            <div class="container-fluid">
                <div class="authentication-card">
                    <div class="card shadow rounded-0 overflow-hidden col-lg-6">
                        {{-- <div class="row g-0"> --}}
                        <div class="col-md d-flex justify-content-center">
                            <div class="card-body p-4 p-sm-5">
                                <h5 class="card-title text-center">Sign In</h5>
                                <p class="card-text mb-5 text-center">See your growth and get consulting support!</p>

                                @if ($errors->any())
                                    <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
                                            </div>
                                            <div class="ms-3">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button> --}}
                                    </div>
                                    {{-- <div class="text-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div> --}}
                                @endif
                                <form class="form-body" action="{{ url('/auth') }}" method="POST">
                                    @csrf
                                    <div class="row g-3 mb-5">
                                        <div class="col-12">
                                            <label for="inputUsername" class="form-label">Username</label>
                                            <div class="ms-auto position-relative">
                                                <div
                                                    class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                    <i class="bi bi-envelope-fill"></i>
                                                </div>
                                                <input type="text" class="form-control radius-30 ps-5"
                                                    id="inputUsername" name="username" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Enter
                                                Password</label>
                                            <div class="ms-auto position-relative">
                                                <div
                                                    class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                    <i class="bi bi-lock-fill"></i>
                                                </div>
                                                <input type="password" class="form-control radius-30 ps-5"
                                                    id="inputChoosePassword" name="password"
                                                    placeholder="Enter Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary radius-30"
                                                href="/dashboard">Sign
                                                In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>

</html>
