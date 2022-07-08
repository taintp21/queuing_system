<!-- Page content holder -->
<div @if (Auth::check()) class="page-content" @endif id="content">
    <!-- Demo content -->
    @if (Auth::check())
        <div class="container-fluid background h-100vh" style="z-index: 999;">
            <div class="row h-100">
                @if (!Request::is('/'))
                <main class="col-md-12">
                    <div class="row ps-3 pt-4">
                        <div class="d-flex justify-content-between mb-5">
                            @include('layouts.breadcrumbs')
                            <div class="text-end toggle-sidebar">
                                <button class="navbar-toggler" type="button"  id="sidebarCollapse">
                                    <i class="fa-solid fa-bars fa-2xl"></i>
                                </button>
                            </div>
                            <div class="dropdown">
                                <div class="profile row" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="col-lg-3 avatar">
                                        <img src="{{ url('storage/images/avatar/' . Auth::user()->avatar) }}" class="rounded-circle" alt="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="col-lg-9 info">
                                        <small class="text-muted">Xin chào</small>
                                        <p class="fw-bold">{{ Auth::user()->name }}</p>
                                    </div>
                                </div>
                                <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item {{ Request::is('profile*') ? 'active' : '' }}" href="{{ url('profile/' . Auth::user()->id) }}">Trang cá nhân</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger fw-bold" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <h4 class="page-title">@yield('page-title')</h4>
                            @yield('content')
                        </div>
                    </div>
                </main>

                @else
                <main class="pt-4 px-4 main" style="width: 80%">
                    <!-- Toggle button -->
                    <div class="text-end toggle-sidebar">
                        <button class="navbar-toggler" type="button"  id="sidebarCollapse">
                            <i class="fa-solid fa-bars fa-2xl"></i>
                        </button>
                    </div>
                    @include('layouts.breadcrumbs')
                    <div class="row">
                        <div class="col-lg-12 mt-5">
                            <h4 class="page-title">@yield('page-title')</h4>
                            @yield('content')
                        </div>
                    </div>
                </main>

                <div class="ps-3 pt-4 right-dashboard bg-white" style="width: 20%">
                    <div class="d-flex flex-column">
                        <div class="dropdown">
                            <div class="profile row" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar col-md-2">
                                    <img src="{{ url('storage/images/avatar/' . Auth::user()->avatar) }}"
                                        class="rounded-circle" alt="avatar">
                                </div>
                                <div class="info col-md-10">
                                    <small class="text-muted">Xin chào</small>
                                    <p class="fw-bold">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item {{ Request::is('profile*') ? 'active' : '' }}"
                                        href="{{ url('profile/' . Auth::user()->id) }}">Trang cá nhân</a></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                            </ul>
                        </div>
                        <div class="py-3">
                            <h4 class="fw-bold color-1">Tổng quan</h4>
                        </div>
                        <div class='log-event' id='inlinePicker'></div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @else
        <div class="container-fluid background">
            @yield('content')
        </div>
    @endif
</div>
