@extends('admin.layouts.master')

@section('title', 'Quản lý người dùng')

@section('styles')
<style>
    /* ============================
       PAGE HEADER
    ============================ */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-header-left h1 {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -.5px;
        line-height: 1.2;
    }

    .page-header-left p {
        color: var(--text-secondary);
        font-size: 13.5px;
        margin-top: 4px;
    }

    .page-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        transition: all var(--transition);
        cursor: pointer;
        border: none;
        font-family: inherit;
    }

    .btn-ghost {
        background: var(--surface);
        color: var(--text-secondary);
        border: 1.5px solid var(--border);
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }

    .btn-ghost:hover {
        background: var(--bg);
        border-color: #c8d0e4;
        color: var(--text-primary);
    }

    .btn-primary {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 2px 8px rgba(26,86,219,.28);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        box-shadow: 0 4px 14px rgba(26,86,219,.38);
        transform: translateY(-1px);
    }

    .btn-primary:active { transform: translateY(0); }

    /* ============================
       STATS CARDS
    ============================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 22px;
        transition: box-shadow var(--transition), transform var(--transition);
    }

    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: .8px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .stat-value-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -1px;
        line-height: 1;
    }

    .stat-change {
        font-size: 12px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .stat-change.up   { color: var(--success); background: #d1fae5; }
    .stat-change.down { color: var(--danger);  background: #fee2e2; }

    .stat-sub {
        font-size: 12px;
        font-weight: 600;
        color: var(--success);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stat-sub.live::before {
        content: '';
        width: 7px; height: 7px;
        background: var(--success);
        border-radius: 50%;
        display: inline-block;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .5; transform: scale(1.3); }
    }

    .stat-sub.high { color: var(--primary); font-size: 12px; }

    /* ============================
       TABLE CARD
    ============================ */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    /* ============================
       TABLE TOOLBAR
    ============================ */
    .table-toolbar {
        padding: 16px 22px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-search {
        position: relative;
        flex: 1;
        max-width: 320px;
    }

    .table-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 13px;
    }

    .table-search input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 13px;
        color: var(--text-primary);
        outline: none;
        background: var(--bg);
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .table-search input::placeholder { color: var(--text-muted); }
    .table-search input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,86,219,.1);
        background: var(--surface);
    }

    .filter-select {
        padding: 8px 32px 8px 12px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 13px;
        color: var(--text-secondary);
        outline: none;
        background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 10px center;
        appearance: none;
        cursor: pointer;
        transition: border-color var(--transition);
    }

    .filter-select:focus { border-color: var(--primary); background-color: var(--surface); }

    .toolbar-spacer { flex: 1; }

    /* ============================
       DATA TABLE
    ============================ */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        padding: 12px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: .7px;
        text-transform: uppercase;
        background: var(--bg);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
        user-select: none;
    }

    .data-table thead th.sortable {
        cursor: pointer;
        transition: color var(--transition);
    }

    .data-table thead th.sortable:hover { color: var(--text-primary); }

    .data-table tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background var(--transition);
    }

    .data-table tbody tr:last-child { border-bottom: none; }

    .data-table tbody tr:hover { background: #fafbff; }

    .data-table td {
        padding: 14px 14px;
        vertical-align: middle;
        font-size: 13px;
        white-space: nowrap;
    }

    .data-table thead th {
        white-space: nowrap;
    }

    /* ============================
       USER CELL
    ============================ */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 160px;
    }

    .user-photo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid var(--border);
    }

    .user-initials {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: -.5px;
    }

    .user-meta strong {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
    }

    .user-meta span {
        display: block;
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    /* ============================
       EMAIL CELL
    ============================ */
    .email-cell {
        color: var(--text-secondary);
        font-size: 13px;
    }

    /* ============================
       STATUS CELL
    ============================ */
    .status-dot {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .status-dot::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-dot.active  { color: var(--success); }
    .status-dot.active::before  { background: var(--success); }
    .status-dot.banned  { color: var(--danger); }
    .status-dot.banned::before  { background: var(--danger); }
    .status-dot.pending { color: var(--warning); }
    .status-dot.pending::before { background: var(--warning); }

    /* ============================
       TOGGLE SWITCH
    ============================ */
    .toggle-wrap {
        display: inline-flex;
        align-items: center;
    }

    .toggle-input {
        display: none;
    }

    .toggle-label {
        display: inline-block;
        width: 42px;
        height: 24px;
        background: #cbd5e1;
        border-radius: 12px;
        cursor: pointer;
        position: relative;
        transition: background .25s ease;
    }

    .toggle-label::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 18px;
        height: 18px;
        background: #fff;
        border-radius: 50%;
        transition: transform .25s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }

    .toggle-input:checked + .toggle-label {
        background: var(--primary);
    }

    .toggle-input:checked + .toggle-label::after {
        transform: translateX(18px);
    }

    /* ============================
       ACTION MENU
    ============================ */
    .action-menu-wrap {
        position: relative;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 16px;
        transition: background var(--transition), color var(--transition);
        cursor: pointer;
    }

    .action-btn:hover {
        background: var(--bg);
        color: var(--text-primary);
    }

    .action-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 6px);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        box-shadow: var(--shadow-lg);
        min-width: 160px;
        z-index: 200;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-6px);
        transition: opacity .15s ease, transform .15s ease, visibility .15s;
    }

    .action-dropdown.open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .action-dropdown a,
    .action-dropdown button {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        width: 100%;
        text-align: left;
        transition: background var(--transition), color var(--transition);
        border: none;
        background: none;
        font-family: inherit;
        cursor: pointer;
    }

    .action-dropdown a:hover,
    .action-dropdown button:hover {
        background: var(--bg);
        color: var(--text-primary);
    }

    .action-dropdown .danger:hover {
        background: #fef2f2;
        color: var(--danger);
    }

    .action-dropdown-divider {
        height: 1px;
        background: var(--border-light);
        margin: 4px 0;
    }

    /* ============================
       TABLE FOOTER (PAGINATION)
    ============================ */
    .table-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 22px;
        border-top: 1px solid var(--border-light);
        background: var(--bg);
    }

    .table-foot-info {
        font-size: 12.5px;
        color: var(--text-muted);
        letter-spacing: .2px;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .page-btn {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        border: 1.5px solid var(--border);
        background: var(--surface);
        transition: all var(--transition);
        text-decoration: none;
    }

    .page-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-light);
    }

    .page-btn.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 2px 6px rgba(26,86,219,.3);
    }

    .page-btn:disabled,
    .page-btn.disabled {
        opacity: .4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ============================
       EMPTY STATE
    ============================ */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        color: var(--text-muted);
        gap: 12px;
    }

    .empty-state i { font-size: 40px; opacity: .35; }
    .empty-state p { font-size: 14px; font-weight: 500; }

    /* ============================
       MODAL OVERLAY
    ============================ */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.45);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity .2s ease, visibility .2s;
        backdrop-filter: blur(3px);
    }

    .modal-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    .modal {
        background: var(--surface);
        border-radius: 16px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 24px 80px rgba(0,0,0,.18);
        transform: scale(.96) translateY(12px);
        transition: transform .2s ease;
        overflow: hidden;
    }

    .modal-overlay.open .modal { transform: scale(1) translateY(0); }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
    }

    .modal-header h2 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 14px;
        transition: background var(--transition), color var(--transition);
        cursor: pointer;
    }

    .modal-close:hover { background: var(--bg); color: var(--text-primary); }

    .modal-body { padding: 20px 24px; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
    }

    .form-group label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: .2px;
    }

    .form-group input,
    .form-group select {
        padding: 9px 12px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 13.5px;
        color: var(--text-primary);
        outline: none;
        background: var(--surface);
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,86,219,.1);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px 20px;
        border-top: 1px solid var(--border);
    }

    /* ============================
       TOAST NOTIFICATION
    ============================ */
    .toast-stack {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 2000;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .toast {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--text-primary);
        color: #fff;
        padding: 12px 18px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 500;
        box-shadow: var(--shadow-lg);
        animation: slideIn .25s ease forwards;
        pointer-events: auto;
    }

    .toast.success { background: #065f46; }
    .toast.error   { background: #991b1b; }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(24px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(24px); }
    }

    .toast.removing { animation: slideOut .2s ease forwards; }

    /* ============================
       RESPONSIVE
    ============================ */
    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
        .form-row   { grid-template-columns: 1fr; }
        .table-foot { flex-direction: column; gap: 10px; }
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-header-left">
        <h1>Quản lý người dùng</h1>
        <p>Quản lý quyền hạn, trạng thái và cài đặt tài khoản cho tất cả thành viên nền tảng.</p>
    </div>
    <div class="page-header-right">
        <button class="btn btn-ghost" id="btn-filter" aria-label="Lọc người dùng">
            <i class="fa-solid fa-sliders"></i> Bộ lọc
        </button>
        <button class="btn btn-primary" id="btn-new-user" aria-label="Thêm người dùng mới">
            <i class="fa-solid fa-user-plus"></i> Người dùng mới
        </button>
    </div>
</div>

{{-- STATS CARDS --}}
<div class="stats-grid">
    <div class="stat-card" id="stat-total">
        <div class="stat-label">Tổng người dùng</div>
        <div class="stat-value-row">
            <span class="stat-value">12,842</span>
            <span class="stat-change up">+12%</span>
        </div>
    </div>
    <div class="stat-card" id="stat-active">
        <div class="stat-label">Đang hoạt động</div>
        <div class="stat-value-row">
            <span class="stat-value">3,201</span>
            <span class="stat-sub live">Live</span>
        </div>
    </div>
    <div class="stat-card" id="stat-banned">
        <div class="stat-label">Bị cấm</div>
        <div class="stat-value-row">
            <span class="stat-value">142</span>
            <span class="stat-change down">-2%</span>
        </div>
    </div>
    <div class="stat-card" id="stat-retention">
        <div class="stat-label">Tỷ lệ giữ chân</div>
        <div class="stat-value-row">
            <span class="stat-value">94.8%</span>
            <span class="stat-sub high">Cao</span>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="table-card">

    {{-- TABLE TOOLBAR --}}
    <div class="table-toolbar">
        <div class="table-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="table-search-input" placeholder="Tìm tên, email..." aria-label="Tìm kiếm trong bảng">
        </div>

        <select class="filter-select" id="filter-role" aria-label="Lọc theo vai trò">
            <option value="">Tất cả vai trò</option>
            <option value="admin">Quản trị viên</option>
            <option value="product-manager">Quản lý sản phẩm</option>
            <option value="lead-designer">Nhà thiết kế chính</option>
            <option value="support">Hỗ trợ khách hàng</option>
            <option value="sales">Nhân viên bán hàng</option>
        </select>

        <select class="filter-select" id="filter-status" aria-label="Lọc theo trạng thái">
            <option value="">Tất cả trạng thái</option>
            <option value="active">Hoạt động</option>
            <option value="banned">Bị cấm</option>
            <option value="pending">Chờ duyệt</option>
        </select>

        <div class="toolbar-spacer"></div>
    </div>

    {{-- DATA TABLE --}}
    <div style="overflow-x: auto;">
        <table class="data-table" id="users-table" aria-label="Bảng người dùng">
            <thead>
                <tr>
                    <th class="sortable" data-col="name" aria-sort="none">
                        NGƯỜI DÙNG <i class="fa-solid fa-sort" style="margin-left:4px;opacity:.4;font-size:10px;"></i>
                    </th>
                    <th class="sortable" data-col="email">
                        ĐỊA CHỈ EMAIL <i class="fa-solid fa-sort" style="margin-left:4px;opacity:.4;font-size:10px;"></i>
                    </th>
                    <th>VAI TRÒ</th>
                    <th>TRẠNG THÁI</th>
                    <th style="text-align:center;">KÍCH HOẠT</th>
                    <th style="text-align:right;">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody id="users-tbody">

                {{-- ROW 1 --}}
                <tr data-user-id="1" data-status="active">
                    <td>
                        <div class="user-cell">
                            <div class="user-initials" style="background: linear-gradient(135deg,#6366f1,#8b5cf6);" aria-label="Ảnh đại diện Sarah Jenkins">SJ</div>
                            <div class="user-meta">
                                <strong>Sarah Jenkins</strong>
                                <span>Tham gia Tháng 10 2023</span>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">sarah.j@kineticmotors.com</td>
                    <td><span class="badge badge-blue">Quản lý SP</span></td>
                    <td><span class="status-dot active">HOẠT ĐỘNG</span></td>
                    <td style="text-align:center;">
                        <div class="toggle-wrap">
                            <input type="checkbox" class="toggle-input user-toggle" id="toggle-1" data-userid="1" checked aria-label="Kích hoạt Sarah Jenkins">
                            <label class="toggle-label" for="toggle-1"></label>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="action-menu-wrap">
                            <button class="action-btn action-menu-trigger" aria-label="Tùy chọn cho Sarah Jenkins" data-user="1">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="action-dropdown" id="dropdown-1">
                                <a href="#" onclick="editUser(1,event)"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                                <a href="#"><i class="fa-solid fa-eye"></i> Xem hồ sơ</a>
                                <a href="#"><i class="fa-solid fa-key"></i> Đặt lại mật khẩu</a>
                                <div class="action-dropdown-divider"></div>
                                <button class="danger" onclick="confirmBan(1,event)"><i class="fa-solid fa-ban"></i> Cấm tài khoản</button>
                                <button class="danger" onclick="confirmDelete(1,event)"><i class="fa-solid fa-trash"></i> Xóa người dùng</button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- ROW 2 --}}
                <tr data-user-id="2" data-status="banned">
                    <td>
                        <div class="user-cell">
                            <div class="user-initials" style="background: linear-gradient(135deg,#f59e0b,#ef4444);" aria-label="Ảnh đại diện Marcus Thorne">MT</div>
                            <div class="user-meta">
                                <strong>Marcus Thorne</strong>
                                <span>Tham gia Tháng 01 2024</span>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">m.thorne@kineticmotors.com</td>
                    <td><span class="badge badge-purple">Nhà TK Chính</span></td>
                    <td><span class="status-dot banned">BỊ CẤM</span></td>
                    <td style="text-align:center;">
                        <div class="toggle-wrap">
                            <input type="checkbox" class="toggle-input user-toggle" id="toggle-2" data-userid="2" aria-label="Kích hoạt Marcus Thorne">
                            <label class="toggle-label" for="toggle-2"></label>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="action-menu-wrap">
                            <button class="action-btn action-menu-trigger" aria-label="Tùy chọn cho Marcus Thorne" data-user="2">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="action-dropdown" id="dropdown-2">
                                <a href="#" onclick="editUser(2,event)"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                                <a href="#"><i class="fa-solid fa-eye"></i> Xem hồ sơ</a>
                                <a href="#"><i class="fa-solid fa-key"></i> Đặt lại mật khẩu</a>
                                <div class="action-dropdown-divider"></div>
                                <button class="danger" onclick="confirmBan(2,event)"><i class="fa-solid fa-rotate-left"></i> Gỡ cấm</button>
                                <button class="danger" onclick="confirmDelete(2,event)"><i class="fa-solid fa-trash"></i> Xóa người dùng</button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- ROW 3 --}}
                <tr data-user-id="3" data-status="active">
                    <td>
                        <div class="user-cell">
                            <div class="user-initials" style="background: linear-gradient(135deg,#10b981,#0ea5e9);" aria-label="Ảnh đại diện Elena Kovic">EK</div>
                            <div class="user-meta">
                                <strong>Elena Kovic</strong>
                                <span>Tham gia Tháng 02 2024</span>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">elena.k@kineticmotors.com</td>
                    <td><span class="badge badge-gray">Hỗ trợ Cấp II</span></td>
                    <td><span class="status-dot active">HOẠT ĐỘNG</span></td>
                    <td style="text-align:center;">
                        <div class="toggle-wrap">
                            <input type="checkbox" class="toggle-input user-toggle" id="toggle-3" data-userid="3" checked aria-label="Kích hoạt Elena Kovic">
                            <label class="toggle-label" for="toggle-3"></label>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="action-menu-wrap">
                            <button class="action-btn action-menu-trigger" aria-label="Tùy chọn cho Elena Kovic" data-user="3">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="action-dropdown" id="dropdown-3">
                                <a href="#" onclick="editUser(3,event)"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                                <a href="#"><i class="fa-solid fa-eye"></i> Xem hồ sơ</a>
                                <a href="#"><i class="fa-solid fa-key"></i> Đặt lại mật khẩu</a>
                                <div class="action-dropdown-divider"></div>
                                <button class="danger" onclick="confirmBan(3,event)"><i class="fa-solid fa-ban"></i> Cấm tài khoản</button>
                                <button class="danger" onclick="confirmDelete(3,event)"><i class="fa-solid fa-trash"></i> Xóa người dùng</button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- ROW 4 --}}
                <tr data-user-id="4" data-status="active">
                    <td>
                        <div class="user-cell">
                            <div class="user-initials" style="background: linear-gradient(135deg,#ec4899,#f43f5e);" aria-label="Ảnh đại diện James Park">JP</div>
                            <div class="user-meta">
                                <strong>James Park</strong>
                                <span>Tham gia Tháng 03 2024</span>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">j.park@kineticmotors.com</td>
                    <td><span class="badge badge-green">Nhân viên Bán hàng</span></td>
                    <td><span class="status-dot active">HOẠT ĐỘNG</span></td>
                    <td style="text-align:center;">
                        <div class="toggle-wrap">
                            <input type="checkbox" class="toggle-input user-toggle" id="toggle-4" data-userid="4" checked aria-label="Kích hoạt James Park">
                            <label class="toggle-label" for="toggle-4"></label>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="action-menu-wrap">
                            <button class="action-btn action-menu-trigger" aria-label="Tùy chọn cho James Park" data-user="4">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="action-dropdown" id="dropdown-4">
                                <a href="#" onclick="editUser(4,event)"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                                <a href="#"><i class="fa-solid fa-eye"></i> Xem hồ sơ</a>
                                <a href="#"><i class="fa-solid fa-key"></i> Đặt lại mật khẩu</a>
                                <div class="action-dropdown-divider"></div>
                                <button class="danger" onclick="confirmBan(4,event)"><i class="fa-solid fa-ban"></i> Cấm tài khoản</button>
                                <button class="danger" onclick="confirmDelete(4,event)"><i class="fa-solid fa-trash"></i> Xóa người dùng</button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- ROW 5 --}}
                <tr data-user-id="5" data-status="pending">
                    <td>
                        <div class="user-cell">
                            <div class="user-initials" style="background: linear-gradient(135deg,#64748b,#475569);" aria-label="Ảnh đại diện Nina Okafor">NO</div>
                            <div class="user-meta">
                                <strong>Nina Okafor</strong>
                                <span>Tham gia Tháng 04 2024</span>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">n.okafor@kineticmotors.com</td>
                    <td><span class="badge badge-amber">Quản trị viên</span></td>
                    <td><span class="status-dot pending">CHỜ DUYỆT</span></td>
                    <td style="text-align:center;">
                        <div class="toggle-wrap">
                            <input type="checkbox" class="toggle-input user-toggle" id="toggle-5" data-userid="5" aria-label="Kích hoạt Nina Okafor">
                            <label class="toggle-label" for="toggle-5"></label>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="action-menu-wrap">
                            <button class="action-btn action-menu-trigger" aria-label="Tùy chọn cho Nina Okafor" data-user="5">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="action-dropdown" id="dropdown-5">
                                <a href="#" onclick="editUser(5,event)"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
                                <a href="#"><i class="fa-solid fa-eye"></i> Xem hồ sơ</a>
                                <a href="#"><i class="fa-solid fa-key"></i> Đặt lại mật khẩu</a>
                                <div class="action-dropdown-divider"></div>
                                <button class="danger" onclick="confirmBan(5,event)"><i class="fa-solid fa-ban"></i> Cấm tài khoản</button>
                                <button class="danger" onclick="confirmDelete(5,event)"><i class="fa-solid fa-trash"></i> Xóa người dùng</button>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- EMPTY STATE (hidden by default) --}}
    <div class="empty-state" id="empty-state" style="display:none;" aria-live="polite">
        <i class="fa-solid fa-users-slash"></i>
        <p>Không tìm thấy người dùng nào phù hợp.</p>
    </div>

    {{-- TABLE FOOTER --}}
    <div class="table-foot">
        <span class="table-foot-info" id="showing-info">Hiển thị 1–5 trong tổng 12,842 người dùng</span>
        <nav class="pagination" aria-label="Phân trang">
            <button class="page-btn disabled" id="prev-page" aria-label="Trang trước" disabled>
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="page-btn active" aria-current="page">1</button>
            <button class="page-btn" aria-label="Trang 2">2</button>
            <button class="page-btn" aria-label="Trang 3">3</button>
            <span style="color:var(--text-muted);font-size:13px;padding:0 4px;">…</span>
            <button class="page-btn" aria-label="Trang cuối">1,285</button>
            <button class="page-btn" id="next-page" aria-label="Trang tiếp">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </nav>
    </div>

</div>{{-- /.table-card --}}


{{-- ==========================================
     MODAL: THÊM / CHỈNH SỬA NGƯỜI DÙNG
=========================================== --}}
<div class="modal-overlay" id="modal-user" role="dialog" aria-modal="true" aria-labelledby="modal-user-title">
    <div class="modal">
        <div class="modal-header">
            <h2 id="modal-user-title">Thêm người dùng mới</h2>
            <button class="modal-close" id="modal-close-btn" aria-label="Đóng modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                    <label for="input-firstname">Họ</label>
                    <input type="text" id="input-firstname" placeholder="VD: Nguyễn">
                </div>
                <div class="form-group">
                    <label for="input-lastname">Tên</label>
                    <input type="text" id="input-lastname" placeholder="VD: Văn A">
                </div>
            </div>
            <div class="form-group">
                <label for="input-email">Địa chỉ email</label>
                <input type="email" id="input-email" placeholder="email@kineticmotors.com">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="input-role">Vai trò</label>
                    <select id="input-role">
                        <option value="">Chọn vai trò...</option>
                        <option value="admin">Quản trị viên</option>
                        <option value="product-manager">Quản lý sản phẩm</option>
                        <option value="lead-designer">Nhà thiết kế chính</option>
                        <option value="support">Hỗ trợ khách hàng</option>
                        <option value="sales">Nhân viên bán hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input-status">Trạng thái</label>
                    <select id="input-status">
                        <option value="active">Hoạt động</option>
                        <option value="pending">Chờ duyệt</option>
                        <option value="banned">Bị cấm</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="input-password">Mật khẩu</label>
                <input type="password" id="input-password" placeholder="Tối thiểu 8 ký tự">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" id="modal-cancel-btn">Hủy bỏ</button>
            <button class="btn btn-primary" id="modal-save-btn">
                <i class="fa-solid fa-floppy-disk"></i> Lưu người dùng
            </button>
        </div>
    </div>
</div>

{{-- TOAST CONTAINER --}}
<div class="toast-stack" id="toast-stack" aria-live="polite" aria-atomic="true"></div>

@endsection

@section('scripts')
<script>
(function () {
    'use strict';

    /* ============================================================
       MODAL
    ============================================================ */
    const modal       = document.getElementById('modal-user');
    const modalTitle  = document.getElementById('modal-user-title');
    const btnNewUser  = document.getElementById('btn-new-user');
    const btnClose    = document.getElementById('modal-close-btn');
    const btnCancel   = document.getElementById('modal-cancel-btn');
    const btnSave     = document.getElementById('modal-save-btn');

    function openModal(title = 'Thêm người dùng mới') {
        modalTitle.textContent = title;
        modal.classList.add('open');
        document.getElementById('input-firstname').focus();
    }

    function closeModal() {
        modal.classList.remove('open');
    }

    btnNewUser.addEventListener('click', () => openModal('Thêm người dùng mới'));
    btnClose.addEventListener('click', closeModal);
    btnCancel.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
    });

    btnSave.addEventListener('click', () => {
        const fn = document.getElementById('input-firstname').value.trim();
        const ln = document.getElementById('input-lastname').value.trim();
        const em = document.getElementById('input-email').value.trim();

        if (!fn || !ln || !em) {
            showToast('Vui lòng điền đầy đủ thông tin bắt buộc.', 'error');
            return;
        }

        closeModal();
        showToast('Người dùng đã được lưu thành công!', 'success');

        // Reset form
        ['input-firstname','input-lastname','input-email','input-password'].forEach(id => {
            document.getElementById(id).value = '';
        });
    });

    /* ============================================================
       EDIT / DROPDOWN
    ============================================================ */
    window.editUser = function (id, e) {
        e.preventDefault();
        closeAllDropdowns();
        openModal('Chỉnh sửa người dùng #' + id);
    };

    window.confirmBan = function (id, e) {
        e.preventDefault();
        closeAllDropdowns();
        const row = document.querySelector(`tr[data-user-id="${id}"]`);
        const isBanned = row && row.dataset.status === 'banned';
        showToast(isBanned
            ? `Đã gỡ cấm người dùng #${id}.`
            : `Đã cấm người dùng #${id}.`, isBanned ? 'success' : 'error');
    };

    window.confirmDelete = function (id, e) {
        e.preventDefault();
        closeAllDropdowns();
        if (confirm(`Bạn chắc chắn muốn xóa người dùng #${id}?`)) {
            showToast(`Người dùng #${id} đã bị xóa.`, 'error');
            const row = document.querySelector(`tr[data-user-id="${id}"]`);
            if (row) row.remove();
        }
    };

    /* ============================================================
       ACTION DROPDOWN MENUS
    ============================================================ */
    function closeAllDropdowns() {
        document.querySelectorAll('.action-dropdown.open').forEach(d => d.classList.remove('open'));
    }

    document.querySelectorAll('.action-menu-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const uid      = btn.dataset.user;
            const dropdown = document.getElementById('dropdown-' + uid);
            const wasOpen  = dropdown.classList.contains('open');

            closeAllDropdowns();
            if (!wasOpen) dropdown.classList.add('open');
        });
    });

    document.addEventListener('click', closeAllDropdowns);

    /* ============================================================
       TOGGLE SWITCH
    ============================================================ */
    document.querySelectorAll('.user-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const uid  = this.dataset.userid;
            const name = this.closest('tr').querySelector('strong').textContent;
            const msg  = this.checked
                ? `Đã kích hoạt tài khoản ${name}.`
                : `Đã vô hiệu hóa tài khoản ${name}.`;
            showToast(msg, this.checked ? 'success' : '');
        });
    });

    /* ============================================================
       TABLE SEARCH & FILTER
    ============================================================ */
    const searchInput  = document.getElementById('table-search-input');
    const filterRole   = document.getElementById('filter-role');
    const filterStatus = document.getElementById('filter-status');
    const tbody        = document.getElementById('users-tbody');
    const emptyState   = document.getElementById('empty-state');

    function filterTable() {
        const q      = searchInput.value.toLowerCase();
        const role   = filterRole.value.toLowerCase();
        const status = filterStatus.value.toLowerCase();

        let visible = 0;
        document.querySelectorAll('#users-tbody tr').forEach(row => {
            const name   = row.querySelector('strong')?.textContent.toLowerCase() || '';
            const email  = row.querySelector('.email-cell')?.textContent.toLowerCase() || '';
            const rowSt  = row.dataset.status || '';
            const roleTx = row.querySelector('.badge')?.textContent.toLowerCase() || '';

            const matchQ      = !q      || name.includes(q) || email.includes(q);
            const matchStatus = !status || rowSt === status;
            const matchRole   = !role   || roleTx.includes(role.replace('-', ' '));

            const show = matchQ && matchStatus && matchRole;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        emptyState.style.display = visible === 0 ? 'flex' : 'none';
        document.getElementById('showing-info').textContent =
            visible === 0
                ? 'Không tìm thấy kết quả'
                : `Hiển thị 1–${visible} trong tổng 12,842 người dùng`;
    }

    searchInput.addEventListener('input',  filterTable);
    filterRole.addEventListener('change',  filterTable);
    filterStatus.addEventListener('change', filterTable);

    /* ============================================================
       GLOBAL HEADER SEARCH (sync with table search)
    ============================================================ */
    const globalSearch = document.getElementById('global-search');
    if (globalSearch) {
        globalSearch.addEventListener('input', function () {
            searchInput.value = this.value;
            filterTable();
        });
    }

    /* ============================================================
       TOAST NOTIFICATIONS
    ============================================================ */
    function showToast(message, type = '') {
        const stack = document.getElementById('toast-stack');
        const toast = document.createElement('div');
        toast.className = 'toast' + (type ? ' ' + type : '');
        toast.innerHTML = `<i class="fa-solid fa-${type === 'success' ? 'circle-check' : type === 'error' ? 'circle-xmark' : 'circle-info'}"></i> ${message}`;
        stack.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('removing');
            setTimeout(() => toast.remove(), 220);
        }, 3000);
    }

    /* ============================================================
       PAGINATION BUTTONS (demo)
    ============================================================ */
    document.querySelectorAll('.page-btn:not(#prev-page):not(#next-page)').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('prev-page').classList.toggle('disabled', this.textContent.trim() === '1');
        });
    });

})();
</script>
@endsection
