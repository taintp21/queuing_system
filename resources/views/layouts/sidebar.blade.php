<div id="sidebar" class="collapse collapse-horizontal show">
    <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="">
        </div>
        <a href="{{ url('/') }}" class="list-group-item border-0 d-inline-block {{ Request::is('/') ? 'active' : '' }}" data-bs-parent="#sidebar"><i class="bi icon-me bi-columns-gap"></i> <span>Dashboard</span> </a>
        <a href="{{ route('devices.index') }}" class="list-group-item border-0 d-inline-block {{ Request::is('thiet-bi*') ? 'active' : '' }}" data-bs-parent="#sidebar"><i class="bi icon-me bi-tv"></i> <span>Thiết bị</span> </a>
        <a href="{{ route('services.index') }}" class="list-group-item border-0 d-inline-block {{ Request::is('dich-vu*') ? 'active' : '' }}" data-bs-parent="#sidebar"><i class="bi icon-me bi-chat-dots"></i> <span>Dịch vụ</span> </a>
        <a href="{{ route('give_num.index') }}" class="list-group-item border-0 d-inline-block {{ Request::is('cap-so*') ? 'active' : '' }}" data-bs-parent="#sidebar"><i class="bi icon-me bi-layers"></i> <span>Cấp số</span> </a>
        <a href="{{ route('reports.index') }}" class="list-group-item border-0 d-inline-block {{ Request::is('bao-cao*') ? 'active' : '' }}" data-bs-parent="#sidebar"><i class="bi icon-me bi-file-earmark-bar-graph"></i> <span>Báo cáo</span> </a>

        <div class="dropdown dropend">
            <a href="{{ route('devices.index') }}" class="list-group-item border-0 d-inline-block {{ Request::is('cai-dat*') ? 'active' : '' }}" data-bs-parent="#sidebar" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi icon-me bi-gear"></i> <span>Cài đặt hệ thống</span> <i class="bi bi-three-dots-vertical"></i></a>
            <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item {{ Request::is('*vai-tro*') ? 'active' : '' }}" href="{{ route('system.roles.index') }}">Quản lý vai trò</a></li>
                <li><a class="dropdown-item {{ Request::is('*tai-khoan*') ? 'active' : '' }}" href="{{ route('system.users.index') }}">Quản lý tài khoản</a></li>
                <li><a class="dropdown-item {{ Request::is('*nhat-ky-hoat-dong*') ? 'active' : '' }}" href="{{ route('system.user_logs.index') }}">Nhật ký hoạt động</a></li>
            </ul>
        </div>
        <a href="{{ route('logout') }}" class="list-group-item border-0 d-inline-block logout-btn" data-bs-parent="#sidebar" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi icon-me bi-box-arrow-right"></i> Đăng xuất</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
