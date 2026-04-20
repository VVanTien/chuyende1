<aside class="sidebar">

    {{-- BRAND / LOGO --}}
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-car-side"></i>
        </div>
        <div class="sidebar-brand-text">
            <strong>Kinetic Motors</strong>
            <span>Premium Management</span>
        </div>
    </div>

    {{-- NAV LINKS --}}
    <nav class="sidebar-nav">
        <a href="{{ url('/') }}"
           class="nav-item {{ request()->is('/') ? 'active' : '' }}"
           id="nav-dashboard">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ url('/cars') }}"
           class="nav-item {{ request()->is('cars*') ? 'active' : '' }}"
           id="nav-inventory">
            <i class="fa-solid fa-car"></i>
            <span>Kho xe</span>
        </a>

        <a href="{{ url('/brands') }}"
           class="nav-item {{ request()->is('brands*') ? 'active' : '' }}"
           id="nav-brands">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Hãng xe</span>
        </a>

        <a href="{{ url('/users') }}"
           class="nav-item {{ request()->is('users*') ? 'active' : '' }}"
           id="nav-clients">
            <i class="fa-solid fa-users"></i>
            <span>Khách hàng</span>
        </a>

        <a href="{{ url('/messages') }}"
           class="nav-item {{ request()->is('messages*') ? 'active' : '' }}"
           id="nav-messages">
            <i class="fa-solid fa-envelope"></i>
            <span>Tin nhắn</span>
        </a>

        <a href="{{ url('/settings') }}"
           class="nav-item {{ request()->is('settings*') ? 'active' : '' }}"
           id="nav-settings">
            <i class="fa-solid fa-gear"></i>
            <span>Cài đặt</span>
        </a>
    </nav>

    {{-- BOTTOM ACTIONS --}}
    <div class="sidebar-bottom">
        <a href="{{ url('/cars/create') }}" class="add-listing-btn" id="btn-add-listing">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm xe mới</span>
        </a>
        <a href="{{ url('/help') }}" class="help-link" id="nav-help">
            <i class="fa-solid fa-circle-question"></i>
            <span>Trung tâm trợ giúp</span>
        </a>
    </div>

</aside>
