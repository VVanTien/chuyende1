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

        {{-- User Profile --}}
        <div
            class="user-badge"
            id="user-profile-dropdown"
            role="button"
            tabindex="0"
            aria-label="Tài khoản người dùng"
            aria-haspopup="true"
        >
            <div class="user-avatar-placeholder" aria-hidden="true">AR</div>
            <div class="user-info">
                <strong>Alex Rivera</strong>
                <span>Quản trị viên</span>
            </div>
        </div>

    </div>
</header>
