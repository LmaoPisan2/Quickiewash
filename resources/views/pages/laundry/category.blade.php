@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Category', 'titleSub' => ''. ucfirst(Auth::user()->auth). ' : '. Auth::user()->nama])
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<div class="container-fluid py-4">
    <div class="row">

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="card shadow border border-2 text-black" style="width: 100rem">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0 fw-bold text-orange">Kategori Laundry</h5>
                    
                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('pages.category', ['auth' => Auth::user()->auth]) }}" class="d-flex align-items-center">
                        <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2" style="background-color: #f56d37; margin-top: 15px">Cari</button>
                    </form>
                    
                    <!-- Icon Keranjang -->
                    <a href="{{ route('pages.cartlaundry', ['auth' => Auth::user()->auth]) }}"
                        class="d-flex justify-content-center align-items-center p-2"
                        style="background-color: #f56d37; border-radius: 8px; width: 3rem; height: 3rem; background: rgba(0,0,0,0.0);">
                        <img src="{{ asset('img/shopping cart.png') }}" alt="default profile" style="width: 70px; height: 30px;">
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        @foreach ($categories as $category)
                        <div class="col-md-4 mb-4">
                            <div class="card text-center border-0 shadow">
                                <div class="card-body">
                                    <img src="{{ asset($category->icon) }}" class="icon-lg" alt="{{ $category->nama }}">
                                    <h5 class="mt-3 fw-bold text-orange">{{ ucwords($category->nama) }}</h5>
                                    <p class="text-muted">Harga: Rp {{ number_format($category->harga, 0, ',', '.') }}</p> <!-- Displaying the price -->
                                    <a href="{{ route('pages.inputdetail', ['auth' => Auth::user()->auth, 'category' => $category->nama]) }}"
                                    class="btn btn-primary mt-3 w-100" style="background-color: #f56d37">
                                        Pilih
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination Footer -->
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <p class="mb-0 text-muted">Showing data {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries</p>
                    <nav>
                        {{ $categories->links('pagination::bootstrap-4') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
