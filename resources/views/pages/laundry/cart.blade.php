@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Cart', 'titleSub' => ''. ucfirst(Auth::user()->auth). ' : '. Auth::user()->nama])
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<div class="container-fluid">
    <div class="row">
        <!-- Content -->
        <div class="col-md-10 ">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary">Keranjang</h4>
                <div class="d-flex align-items-center">
                    <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2">
                    <div>
                        <p class="mb-0 text-primary fw-bold">Paong</p>
                        <span class="text-secondary">Admin</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-3 p-3">
                        @foreach ($carts as $cart)
                        <h5 class="text-orange fw-bold">{{ucfirst($cart->category->nama)}}</h5>
                        <p>Nama: {{$cart->pembayaran->users->nama}}</p>
                        @if ($cart->category->nama == 'pakaian')
                            <p>Berat: {{$cart->jumlah}} Kg</p>
                        @else
                            <p>Jumlah: {{$cart->jumlah}} Pasang</p>
                        @endif
                        <p>Harga/Kg: Rp. {{number_format($cart->category->harga, 0, ',', '.')}}</p>
                        <p>Total: Rp. {{$cart->pembayaran->total}}</p>
                        <div class="d-flex justify-content-end gap-2">
                            <a class="btn btn-warning btn-sm" href='{{ route("pages.editInputdetail", ["auth" => "admin", "id" => $cart->pembayaran->id])}}'>Edit</a>
                            <a class="btn btn-danger btn-sm" href='{{ route("pages.deleteInputdetail", ["auth" => "admin", "id" => $cart->pembayaran->id])}}'>Delete</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Price Summary -->
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <h5 class="text-orange fw-bold">Rincian Harga</h5>
                        @foreach ($summary as $item)
                            <p>{{ ucfirst($item['jenis']) }}: Rp.{{ number_format($item['total_harga'], 0, ',', '.') }}</p>
                            <h6 class="fw-bold text-orange">Total: Rp.{{ number_format($summary->sum('total_harga'), 0, ',', '.') }}</h6>
                        @endforeach
                        <hr>
                        <a class="btn btn-primary w-100 mt-3" style="background-color: #f56d37" href="{{ route('pages.makeOrder', ['auth' => 'admin']) }}">Kirim</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
