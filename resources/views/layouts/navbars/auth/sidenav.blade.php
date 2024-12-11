<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "style="overflow: auto;"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}"
            target="_blank">
            <img src="{{ asset('img/QuicKie.png') }}" alt="QuickieWash Logo" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-orange">Quickie Wash</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <!-- <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main"> -->
        <ul class="navbar-nav">
            <li class="nav-item">
                @if(Auth::user()->auth == "admin")
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard', ['auth' => 'admin']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('img/piechart.png') }}" alt="Dashboard Icon" class="text-info text-sm opacity-10" style="width: 20px; height: 20px;">
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                    <a class="nav-link {{ str_contains(request()->url(), 'category-laundry') == true || str_contains(request()->url(), 'input-detail') == true  ? 'active' : '' }}" href="{{route('pages.categorylaundry', ['auth' => 'admin']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('img/category.png') }}" alt="Dashboard Icon" class="text-info text-sm opacity-10" style="width: 20px; height: 20px;">
                        </div>
                        <span class="nav-link-text ms-1">Kategori Laundry</span>
                    </a>
                    <a class="nav-link {{ str_contains(request()->url(), 'history-laundry') == true ? 'active' : '' }}" href="{{route('pages.historylaundry', ['auth' => 'admin']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('img/order.png') }}" alt="Dashboard Icon" class="text-info text-sm opacity-10" style="width: 20px; height: 20px;">
                        </div>
                        <span class="nav-link-text ms-1">Order History</span>
                    </a>
                @else(Auth::user()->auth == "customer")
                    <a class="nav-link {{ str_contains(request()->url(), 'dashboard') == true ? 'active' : '' }}" href="{{route('dashboard', ['auth' => 'customer']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('img/piechart.png') }}" alt="Dashboard Icon" class="text-info text-sm opacity-10" style="width: 20px; height: 20px;">
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                    <a class="nav-link {{ str_contains(request()->url(), 'history-laundry') == true ? 'active' : '' }}" href="{{route('pages.historylaundry', ['auth' => 'customer']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('img/order.png') }}" alt="Dashboard Icon" class="text-info text-sm opacity-10" style="width: 20px; height: 20px;">
                        </div>
                        <span class="nav-link-text ms-1">Order History</span>
                    </a>
                @endif

            </li>
            <li class="nav-item">
                <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('img/logout.png') }}" alt="Dashboard Icon" class="text-info text-sm opacity-10" style="width: 20px; height: 20px;">
                        </div>
                        <span class="nav-link-text ms-1">Log out</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>

