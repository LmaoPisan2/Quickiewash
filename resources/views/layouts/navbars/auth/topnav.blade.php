
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">{{ $titleSub }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2" id="navbar">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center gap-3">
                    <!-- Notifikasi -->
                    @php
                        $unreadNotifications = App\Models\Notifikasi::where('user_id', Auth::id())
                                                ->where('is_read', false)
                                                ->count();
                    @endphp
                    <a href="{{ route('notifikasi') }}" class="nav-link p-0 position-relative">
                       <img src="{{ asset('img/NotificationIcon.png') }}" alt="Notif" class="icon-sm text-light">
                        @if($unreadNotifications > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadNotifications }}
                                <span class="visually-hidden">Notifikasi Baru</span>
                            </span>
                        @endif
                    </a>

                    <!-- Gambar Profil -->
                    <a href="{{ route('profile') }}" class="nav-link p-0">
                        <div class="rounded-circle overflow-hidden d-flex align-items-center"
                            style="width: 36px; height: 36px; background-color: #ffffff;">
                            <img src="{{ asset('storage/' . Auth::user()->gambar_profile) }}"
                                alt="Profile Picture" class="img-fluid"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>



<!-- <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div> -->
