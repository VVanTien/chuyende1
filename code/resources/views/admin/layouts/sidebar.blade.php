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
        <a href="{{ url('/admin/') }}" class="nav-item {{ request()->is('admin') || request()->is('admin/') ? 'active' : '' }}" id="nav-dashboard">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Tổng quan</span>
        </a>

        <a href="{{ url('/admin/cars') }}" class="nav-item {{ request()->is('admin/cars*') ? 'active' : '' }}"
            id="nav-inventory">
            <i class="fa-solid fa-car"></i>
            <span>Kho xe</span>
        </a>

        <a href="{{ url('/admin/brands') }}" class="nav-item {{ request()->is('admin/brands*') ? 'active' : '' }}"
            id="nav-brands">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Hãng xe</span>
        </a>

        <a href="{{ url('/admin/categories') }}" class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}"
            id="nav-categories">
            <i class="fa-solid fa-list"></i>
            <span>Dòng xe</span>
        </a>

        <a href="{{ url('/admin/users') }}" class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}"
            id="nav-users">
            <i class="fa-solid fa-users"></i>
            <span>Khách hàng</span>
        </a>

        <a href="{{ url('/admin/orders') }}" class="nav-item {{ request()->is('admin/orders*') ? 'active' : '' }}"
            id="nav-orders">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Đơn hàng</span>
        </a>

        <a href="{{ url('/admin/payments') }}" class="nav-item {{ request()->is('admin/payments*') ? 'active' : '' }}"
            id="nav-payments">
            <i class="fa-solid fa-credit-card"></i>
            <span>Thanh toán</span>
        </a>
    </nav>

    {{-- BOTTOM ACTIONS --}}
    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
            @csrf
            <button type="submit" class="add-listing-btn" id="btn-logout" style="width: 100%; border: none; cursor: pointer; font-family: inherit; background: #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,.35);">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Đăng xuất</span>
            </button>
        </form>
        <a href="{{ url('/admin/help') }}" class="help-link" id="nav-help">
            <i class="fa-solid fa-circle-question"></i>
            <span>Trung tâm trợ giúp</span>
        </a>
    </div>

</aside>