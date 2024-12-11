@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dashboard', 'titleSub' => ''. ucfirst(Auth::user()->auth). ' : '. Auth::user()->nama])
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<div class="container py-5">
    <div class="card shadow border-0">
        <div class="card-header text-white">
            <h5 class="fw-bold mb-0 text-orange">Notifikasi</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse ($notifikasis as $notifikasi)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold text-orange">{{ $notifikasi->judul }}</div>
                            {{ $notifikasi->pesan }}
                        </div>
                        <div class="d-flex align-items-center">
                            <small class="text-muted me-3">{{ $notifikasi->created_at->diffForHumans() }}</small>
                            @if (!$notifikasi->is_read)
                                <button class="btn btn-sm btn-outline-primary mark-as-read-btn text-orange"
                                        data-id="{{ $notifikasi->id }}">Tandai Dibaca</button>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-orange">Tidak ada notifikasi baru.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
