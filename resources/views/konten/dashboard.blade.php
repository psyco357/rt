@extends('layouts.pages')
@section('title', 'Dashboard')
@section('content-title', 'Dashboard')
@section('content-subtitle', 'Dashboard Penjualan')

@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Total Khas</p>
                            <h4 class="">8,542</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-success">+ 16% <i class="bi bi-arrow-up"></i></p>
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Total Hari Ini</p>
                            <h4 class="">12.5M</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-danger">- 3.4% <i class="bi bi-arrow-down"></i></p>
                            <div id="chart2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Total Uang Masuk</p>
                            <h4 class="">$64.5K</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-success">+ 24% <i class="bi bi-arrow-up"></i></p>
                            <div id="chart3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Total Uang Keluar</p>
                            <h4 class="">25.8K</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-success">+ 8.2% <i class="bi bi-arrow-up"></i></p>
                            <div id="chart4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Total Uang Masuk</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer">
                                <span>Rp. {{ number_format($totalUangMasuk, 2, '.', ',') }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="chart80"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Total Uang Keluar</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                                <span>Rp. {{ number_format($totalUangKeluar, 2, '.', ',') }}</span>

                            </div>

                        </div>
                    </div>
                    <div id="chart6"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script>
        var dataUangMasuk = {!! $chartData !!};
        var dataUangKeluar = {!! $chartKeluar !!};
        renderUangMasukChart(dataUangMasuk, "#chart80", "Total Uang Masuk")
        renderUangMasukChart(dataUangKeluar, "#chart6", "Total Uang Keluar")

        function renderUangMasukChart(dataUangMasuk, id, judul) {
            var options = {
                series: [{
                    name: judul,
                    data: dataUangMasuk
                }],
                chart: {
                    type: "area",
                    stacked: true,
                    height: 280,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    dropShadow: {
                        enabled: false,
                        top: 3,
                        left: 14,
                        blur: 4,
                        opacity: .12,
                        color: "#3461ff"
                    },
                    sparkline: {
                        enabled: false
                    }
                },
                markers: {
                    size: 0,
                    colors: ["#3461ff"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: [2.5],
                    curve: "smooth"
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#3361ff'],
                        inverseColors: false,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                    }
                },
                colors: ["#3361ff"],
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return "Rp. " + value.toLocaleString('id-ID');
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            type: "area",
                            stacked: true
                        }
                    }
                }],
                legend: {
                    show: false
                },
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function(value) {
                            return "Rp. " + value.toLocaleString('id-ID');
                        }
                    }
                }
            };

            // Render ulang (bersihkan jika sudah ada sebelumnya)
            // if (window.chartUangMasuk) {
            //     window.chartUangMasuk.destroy();
            // }

            window.chartUangMasuk = new ApexCharts(document.querySelector(id), options);
            window.chartUangMasuk.render();
        }
    </script>
@endpush
