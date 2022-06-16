<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('web-title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert2.all.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- Styles -->
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
        <div class="container-fluid">
            <div class="row flex-nowrap @if (Auth::check()) background @endif">
                @if (Auth::check())
                    <div class="col-auto px-0 bg-white">
                        @include('layouts.sidebar')
                    </div>
                @endif
                <main class="col ms-md-3 mt-md-5">
                    <div class="row">
                        @if (Auth::check())
                            <div class="col-12">
                                <div class="breadcrumbs">
                                    <h4>Dashboard</h4>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 mt-5">
                            <h4 class="page-title">@yield('page-title')</h4>
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>
    @yield('custom_scripts')
</body>
</html>
