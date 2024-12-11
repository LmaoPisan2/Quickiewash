@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard', 'titleSub' => ''. ucfirst(Auth::user()->auth). ' : '. Auth::user()->nama])
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <!-- Panel Welcome (Posisi di atas) -->
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
            </div>
            <div class="panel-container show">
                <div class="panel-content d-flex justify-content-center align-items-center" style="height: 200px; text-align: center;">
                    <h1>Welcome</h1>
                </div>
            </div>
        </div>
    <!-- Container Utama -->
    <div class="container-fluid py-4">

        <!-- Panel Welcome (Posisi di atas) -->
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
            </div>
            <div class="panel-container show">
                <div class="panel-content d-flex justify-content-center align-items-center" style="height: 200px; text-align: center;">
                    <h1 class ="text-orange ">Welcome Admin</h1>
                </div>
            </div>
        </div>

        <!-- Statistik Total (Tetap di bawah Panel Welcome) -->
        <div class="row d-flex justify-content-center mt-4">
            <!-- Total Pembayaran -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <h5 class="font-weight-bolder text-orange">
                                        {{ $totalPembayaran }}
                                    </h5>
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-orange">
                                        Harga Total Laundry
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Customer -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <h5 class="font-weight-bolder text-orange">
                                        {{$totalUsers}}
                                    </h5>
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-orange">
                                        Total Customer
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
