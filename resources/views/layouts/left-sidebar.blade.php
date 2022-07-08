@if (Auth::check())
    <div class="vertical-nav bg-white" id="sidebar" style="z-index: 1000;">
        <div class="pb-2 px-3 mb-4 bg-white">
            <div class="logo text-center">
                <img src="{{ asset('images/logo.png') }}">
            </div>
        </div>
        <ul class="nav d-flex flex-column bg-white mb-0">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                    <i class="bi icon-me bi-columns-gap"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('devices.index') }}" class="nav-link {{ Request::is('thiet-bi*') ? 'active' : '' }}">
                    <i class="bi icon-me bi-tv"></i>
                    Thiết bị
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('services.index') }}" class="nav-link {{ Request::is('dich-vu*') ? 'active' : '' }}">
                    <i class="bi icon-me bi-chat-dots"></i>
                    Dịch vụ
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('give_num.index') }}" class="nav-link {{ Request::is('cap-so*') ? 'active' : '' }}">
                    <i class="bi icon-me bi-layers"></i>
                    Cấp số
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reports.index') }}" class="nav-link {{ Request::is('bao-cao*') ? 'active' : '' }}">
                    <i class="bi icon-me bi-file-earmark-bar-graph"></i>
                    Báo cáo
                </a>
            </li>

            <li class="nav-item">
                <div class="dropdown dropend">
                    <a href="#" class="nav-link {{ Request::is('cai-dat*') ? 'active' : '' }}" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi icon-me bi-gear"></i> <span>Cài đặt hệ thống</span> <i class="bi bi-three-dots-vertical"></i></a>
                    <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item {{ Request::is('*vai-tro*') ? 'active' : '' }}" href="{{ route('system.roles.index') }}">Quản lý vai trò</a></li>
                        <li><a class="dropdown-item {{ Request::is('*tai-khoan*') ? 'active' : '' }}" href="{{ route('system.users.index') }}">Quản lý tài khoản</a></li>
                        <li><a class="dropdown-item {{ Request::is('*nhat-ky-hoat-dong*') ? 'active' : '' }}" href="{{ route('system.user_logs.index') }}">Nhật ký hoạt động</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi icon-me bi-box-arrow-right"></i> Đăng xuất</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <!-- End vertical navbar -->
@endif
