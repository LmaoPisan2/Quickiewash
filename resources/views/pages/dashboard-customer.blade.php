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
                    <h1 class="text-orange">Welcome to Quickie {{ Auth::user()->nama}}!</h1>
                </div>
            </div>
        </div>

        <div class="panel mt-4">
            <div class="panel-hdr">
                <h6>Recent Orders</h6>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through the recent Pembayaran records -->
                            @foreach($recentOrders as $pembayaran)
                                <tr>
                                    <td>{{ $pembayaran->id }}</td>
                                    <td>{{ $pembayaran->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_mulai)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_selesai)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
