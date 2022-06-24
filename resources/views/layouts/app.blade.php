<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('web-title')</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    @yield('custom_css')
</head>
<body>
    <div id="app">
        {{-- <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul> --}}
        @if (Auth::check())
            <div class="container-fluid">
                <div class="row flex-nowrap background">
                    <div class="col-auto px-0 bg-white">
                        @include('layouts.sidebar')
                    </div>
                    <main class="col ms-md-3 mt-md-4">
                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <div class="breadcrumbs">
                                <h4 class="color-1 fw-bold">@yield('breadcrumbs')</h4>
                            </div>
                            <a href="{{ url('profile/'.Auth::user()->id) }}" class="text-decoration-none text-black">
                                <div class="profile d-flex flex-wrap" style="gap: 10px;">
                                    <div class="avatar">
                                        <img src="{{ url('storage/images/avatar/'.Auth::user()->avatar) }}" class="rounded-circle" alt="avatar">
                                    </div>
                                    <div class="info">
                                        <small class="text-muted">Xin chào</small>
                                        <p class="fw-bold">{{ Auth::user()->name }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-5">
                                <h4 class="page-title">@yield('page-title')</h4>
                                @yield('content')
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        @else
            <div class="container-fluid background h100vh">
                @yield('content')
            </div>
        @endif
    </div>
    <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert2.all.js') }}"></script>
    @yield('custom_scripts')
</body>
</html>
