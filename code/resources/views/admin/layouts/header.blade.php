<header class="topbar">

    {{-- SEARCH BAR --}}
    <div class="topbar-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input
            type="text"
            id="global-search"
            placeholder="Tìm người dùng, vai trò hoặc trạng thái..."
            aria-label="Tìm kiếm toàn cục"
        >
    </div>

    <div class="topbar-spacer"></div>

    {{-- RIGHT ACTIONS --}}
    <div class="topbar-actions">

        {{-- Notification Bell --}}
        <button class="icon-btn" id="btn-notifications" title="Thông báo" aria-label="Thông báo">
            <i class="fa-solid fa-bell"></i>
            <span class="notif-badge"></span>
        </button>

        {{-- App Grid --}}
        <button class="icon-btn" id="btn-apps" title="Ứng dụng" aria-label="Ứng dụng">
            <i class="fa-solid fa-grip"></i>
        </button>

        <div class="topbar-divider"></div>

        {{-- User Profile Dropdown --}}
        @php
            $user = Auth::user();
            $initials = strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'D', 0, 1));
            $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
            $roleLabel = match($user->role ?? '') {
                'admin'    => 'Quản trị viên',
                'manager'  => 'Quản lý',
                'staff'    => 'Nhân viên',
                default    => ucfirst($user->role ?? 'Người dùng'),
            };
        @endphp

        <div class="user-badge" id="user-profile-dropdown" role="button" tabindex="0"
             aria-label="Tài khoản người dùng" aria-haspopup="true" aria-expanded="false">
            <div class="user-avatar-placeholder" aria-hidden="true">{{ $initials }}</div>
            <div class="user-info">
                <strong>{{ $fullName ?: 'Admin' }}</strong>
                <span>{{ $roleLabel }}</span>
            </div>
            <i class="fa-solid fa-chevron-down" style="font-size:10px; color:var(--text-muted); margin-left:4px; transition: transform .2s;"></i>
        </div>

        {{-- Dropdown Menu --}}
        <div class="user-dropdown-menu" id="user-dropdown-menu" role="menu" aria-hidden="true">
            <div class="dropdown-header">
                <div class="user-avatar-placeholder" style="width:38px;height:38px;font-size:14px;">{{ $initials }}</div>
                <div>
                    <div style="font-weight:700; font-size:13.5px;">{{ $fullName ?: 'Admin' }}</div>
                    <div style="font-size:11.5px; color:var(--text-muted);">{{ $user->email ?? '' }}</div>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" role="menuitem">
                <i class="fa-solid fa-user"></i> Hồ sơ cá nhân
            </a>
            <a href="#" class="dropdown-item" role="menuitem">
                <i class="fa-solid fa-gear"></i> Cài đặt
            </a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item danger" role="menuitem" style="width:100%;text-align:left;background:none;border:none;font-family:inherit;cursor:pointer;">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>

    </div>
</header>

<style>
    /* Dropdown menu */
    .topbar-actions { position: relative; }

    .user-badge { cursor: pointer; user-select: none; }
    .user-badge:hover { background: var(--bg); }

    .user-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 240px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        z-index: 9999;
        overflow: hidden;
        animation: dropdownFade .18s ease;
    }
    .user-dropdown-menu.open { display: block; }

    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        background: var(--bg);
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-light, #f1f5f9);
        margin: 2px 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        transition: background .15s, color .15s;
    }
    .dropdown-item:hover {
        background: var(--bg);
        color: var(--text-primary);
    }
    .dropdown-item.danger { color: #ef4444; }
    .dropdown-item.danger:hover { background: #fee2e2; color: #dc2626; }
    .dropdown-item i { width: 16px; text-align: center; }
</style>

<script>
(function(){
    const trigger  = document.getElementById('user-profile-dropdown');
    const menu     = document.getElementById('user-dropdown-menu');
    const chevron  = trigger.querySelector('.fa-chevron-down');

    function openMenu() {
        menu.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
        menu.setAttribute('aria-hidden', 'false');
        chevron.style.transform = 'rotate(180deg)';
    }
    function closeMenu() {
        menu.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');
        chevron.style.transform = '';
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.contains('open') ? closeMenu() : openMenu();
    });

    trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openMenu(); }
        if (e.key === 'Escape') closeMenu();
    });

    document.addEventListener('click', (e) => {
        if (!trigger.contains(e.target) && !menu.contains(e.target)) closeMenu();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMenu();
    });
})();
</script>
