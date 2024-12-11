@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Edit Detail', 'titleSub' => ''. ucfirst(Auth::user()->auth). ' : '. Auth::user()->nama])
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-white">
            <h5 class="fw-bold text-start text-orange">Edit {{ ucfirst($category) }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pages.editlaundry', ['auth' => Auth::user()->auth]) }}" method="POST">
                @csrf
                <input type="hidden" name="id_pembayaran" value="{{$pembayaran->id}}">
                <div class="mb-3">
                    <label for="customer" class="form-label text-orange">Nama</label>
                    <select name="id_customer" id="customer" class="form-select" required>
                        <option value="" disabled>Pilih Customer</option>
                        @foreach ($customers as $customer)
                            <option
                                value="{{ $customer->id }}"
                                {{ $customer->id == $pembayaran->id_customer ? 'selected' : '' }}>
                                {{ $customer->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if($category == "pakaian")
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Berat (Kg)</label>
                    <input
                        type="number"
                        name="jumlah"
                        id="jumlah"
                        class="form-control"
                        value="{{ $pembayaran->jumlah }}"
                        required>
                </div>
                @else
                <div class="mb-3">
                    <label for="jumlah" class="form-label text-orange">Jumlah</label>
                    <input
                        type="number"
                        name="jumlah"
                        id="jumlah"
                        class="form-control"
                        value="{{ $pembayaran->jumlah }}"
                        required>
                </div>
                @endif
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label text-orange">Tanggal Mulai</label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        id="tanggal_mulai"
                        class="form-control"
                        value="{{ $pembayaran->tanggal_mulai }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label text-orange">Tanggal Selesai</label>
                    <input
                        type="date"
                        name="tanggal_selesai"
                        id="tanggal_selesai"
                        class="form-control"
                        value="{{ $pembayaran->tanggal_selesai }}"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="background-color: #f56d37">Edit</button>
            </form>
        </div>
    </div>
</div>
@endsection
