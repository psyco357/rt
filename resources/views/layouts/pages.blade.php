<!DOCTYPE html>
<html lang="en">

<head>
    @include('komponent.meta')
    <title>@yield('title')</title>
    @stack('styles')
</head>

<body>
    {{-- @include('layouts.sidebar') --}}
    <div class="wrapper">
        <div class="container-fluid">
            @include('komponent.sidebar')
            @include('komponent.header')
            <main class="page-content">
                @yield('content')
            </main>
            <!--start overlay-->
            <div class="overlay nav-toggle-icon"></div>
            <!--end overlay-->

            <!--Start Back To Top Button-->
            <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
            <!--End Back To Top Button-->
        </div>
    </div>
    @include('komponent.footer')
    @stack('scripts')
    {{-- @include('layouts.footer-script') --}}
</body>

</html>
