@extends('admin.layouts.master')

@section('title', 'Hãng xe — Brands Management')

@section('styles')
<style>
    /* ====================================
       PAGE HEADER
    ==================================== */
    .page-super {
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 4px;
    }
    .page-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title-row h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -.6px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: inherit;
        transition: all var(--transition);
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
    .btn-ghost {
        background: var(--surface);
        color: var(--text-secondary);
        border: 1.5px solid var(--border);
    }
    .btn-ghost:hover { background: var(--bg); color: var(--text-primary); }

    /* ====================================
       STATS
    ==================================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px;
        transition: box-shadow var(--transition), transform var(--transition);
    }
    .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .stat-label {
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
    .stat-value-row { display: flex; align-items: baseline; gap: 7px; }
    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -1px;
        line-height: 1;
    }
    .stat-tag { font-size: 12px; font-weight: 700; color: var(--success); }
    .stat-tag.neutral { color: var(--text-muted); font-weight: 600; }

    /* ====================================
       TABLE CARD
    ==================================== */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    /* Toolbar */
    .table-toolbar {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .t-search {
        position: relative;
        flex: 1;
        max-width: 280px;
        min-width: 160px;
    }
    .t-search i {
        position: absolute;
        left: 11px; top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 12.5px;
    }
    .t-search input {
        width: 100%;
        padding: 8px 12px 8px 33px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 13px;
        color: var(--text-primary);
        outline: none;
        background: var(--bg);
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .t-search input::placeholder { color: var(--text-muted); }
    .t-search input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,86,219,.1);
        background: var(--surface);
    }
    .filter-select {
        padding: 8px 28px 8px 11px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 12.5px;
        color: var(--text-secondary);
        background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 10 10'%3E%3Cpath fill='%2394a3b8' d='M5 7L0 2h10z'/%3E%3C/svg%3E") no-repeat right 9px center;
        appearance: none;
        cursor: pointer;
        outline: none;
        transition: border-color var(--transition);
    }
    .filter-select:focus { border-color: var(--primary); background-color: var(--surface); }
    .toolbar-spacer { flex: 1; }

    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table thead th {
        padding: 11px 16px;
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .7px;
        text-transform: uppercase;
        color: var(--text-muted);
        background: var(--bg);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background var(--transition);
    }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbff; }
    .data-table td {
        padding: 14px 16px;
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Brand logo */
    .brand-logo {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: -1px;
    }

    .brand-cell-wrap { display: flex; align-items: center; gap: 13px; }
    .brand-name  { font-size: 14px; font-weight: 700; color: var(--text-primary); }
    .brand-slug  { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

    .country-cell { color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
    .country-flag { font-size: 18px; }

    .num-cell  { font-weight: 700; color: var(--text-primary); text-align: right; }
    .avail-cell { color: var(--success); font-weight: 600; text-align: right; }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .pill-active   { background: #d1fae5; color: #065f46; }
    .pill-inactive { background: #f1f5f9; color: #475569; }

    /* Actions */
    .action-group {
        display: flex; align-items: center; gap: 4px; justify-content: flex-end;
    }
    .act-btn {
        width: 31px; height: 31px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 13.5px;
        color: var(--text-muted);
        cursor: pointer;
        transition: background var(--transition), color var(--transition);
        border: none; background: none; text-decoration: none;
    }
    .act-btn:hover { background: var(--bg); color: var(--text-primary); }
    .act-btn.danger:hover { background: #fee2e2; color: var(--danger); }

    /* Footer */
    .table-foot {
        display: flex; align-items: center; justify-content: space-between;
        padding: 13px 20px;
        border-top: 1px solid var(--border-light);
        background: var(--bg);
        flex-wrap: wrap; gap: 10px;
    }
    .foot-info { font-size: 12px; color: var(--text-muted); }
    .pagination { display: flex; gap: 4px; }
    .page-btn {
        width: 30px; height: 30px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12.5px; font-weight: 600;
        color: var(--text-secondary);
        border: 1.5px solid var(--border);
        background: var(--surface);
        cursor: pointer;
        transition: all var(--transition);
    }
    .page-btn:hover { border-color: var(--primary); color: var(--primary); }
    .page-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .page-btn.disabled { opacity: .4; pointer-events: none; }

    /* Modal */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(15,23,42,.45);
        z-index: 1000;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: opacity .2s ease, visibility .2s;
        backdrop-filter: blur(3px);
    }
    .modal-overlay.open { opacity: 1; visibility: visible; }
    .modal {
        background: var(--surface);
        border-radius: 16px;
        width: 100%; max-width: 480px;
        box-shadow: 0 24px 80px rgba(0,0,0,.18);
        transform: scale(.96) translateY(12px);
        transition: transform .2s ease;
        overflow: hidden;
    }
    .modal-overlay.open .modal { transform: scale(1) translateY(0); }
    .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
    }
    .modal-header h2 { font-size: 16px; font-weight: 700; }
    .modal-close {
        width: 30px; height: 30px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); cursor: pointer; font-size: 14px;
        transition: background var(--transition);
    }
    .modal-close:hover { background: var(--bg); color: var(--text-primary); }
    .modal-body { padding: 20px 24px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
    .form-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); }
    .form-group input,
    .form-group select {
        padding: 8.5px 11px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit; font-size: 13.5px;
        color: var(--text-primary); outline: none;
        background: var(--surface);
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,86,219,.1);
    }
    .modal-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        padding: 14px 24px 20px;
        border-top: 1px solid var(--border);
    }

    /* Toast */
    .toast-stack { position: fixed; bottom: 24px; right: 24px; z-index: 2000; display: flex; flex-direction: column; gap: 8px; pointer-events: none; }
    .toast {
        display: flex; align-items: center; gap: 10px;
        background: var(--text-primary); color: #fff;
        padding: 11px 16px; border-radius: var(--radius-sm);
        font-size: 13px; font-weight: 500;
        box-shadow: var(--shadow-lg);
        animation: slideIn .25s ease forwards; pointer-events: auto;
    }
    .toast.success { background: #065f46; }
    .toast.error   { background: #991b1b; }
    @keyframes slideIn { from { opacity:0;transform:translateX(20px); } to { opacity:1;transform:translateX(0); } }
    @keyframes slideOut { from { opacity:1; } to { opacity:0;transform:translateX(20px); } }
    .toast.removing { animation: slideOut .2s ease forwards; }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2,1fr); }
        .form-row   { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-super">BRANDS OVERVIEW</div>
<div class="page-title-row">
    <h1>Quản lý hãng xe</h1>
    <button class="btn btn-primary" id="btn-add-brand">
        <i class="fa-solid fa-plus"></i> Thêm hãng mới
    </button>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Tổng hãng xe</div>
        <div class="stat-value-row">
            <span class="stat-value">48</span>
            <span class="stat-tag">+3</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Hãng hoạt động</div>
        <div class="stat-value-row">
            <span class="stat-value">42</span>
            <span class="stat-tag neutral">87.5%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Xe trong kho</div>
        <div class="stat-value-row">
            <span class="stat-value">1,284</span>
            <span class="stat-tag">+4%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Hãng xe mới (tháng)</div>
        <div class="stat-value-row">
            <span class="stat-value">3</span>
            <span class="stat-tag neutral">+tháng này</span>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">

    {{-- Toolbar --}}
    <div class="table-toolbar">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="brand-search" placeholder="Tìm tên hãng..." aria-label="Tìm kiếm hãng">
        </div>
        <select class="filter-select" id="filter-country" aria-label="Lọc theo quốc gia">
            <option value="">Tất cả quốc gia</option>
            <option>Đức</option>
            <option>Nhật Bản</option>
            <option>Hàn Quốc</option>
            <option>Mỹ</option>
            <option>Ý</option>
            <option>Anh</option>
        </select>
        <select class="filter-select" id="filter-brand-status" aria-label="Lọc theo trạng thái">
            <option value="">Tất cả trạng thái</option>
            <option value="active">Hoạt động</option>
            <option value="inactive">Không hoạt động</option>
        </select>
        <div class="toolbar-spacer"></div>
        <button class="btn btn-ghost" id="btn-export-brands">
            <i class="fa-solid fa-download"></i> Xuất
        </button>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="data-table" id="brands-table" aria-label="Bảng danh sách hãng xe">
            <thead>
                <tr>
                    <th>HÃNG XE</th>
                    <th>QUỐC GIA</th>
                    <th>NĂM THÀNH LẬP</th>
                    <th style="text-align:right;">TỔNG XE</th>
                    <th style="text-align:right;">CÒN LẠI</th>
                    <th>TRẠNG THÁI</th>
                    <th style="text-align:right;">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody id="brands-tbody">

                <tr data-status="active" data-country="đức">
                    <td>
                        <div class="brand-cell-wrap">
                            <div class="brand-logo" style="background:linear-gradient(135deg,#e63946,#d62828);">Po</div>
                            <div>
                                <div class="brand-name">Porsche</div>
                                <div class="brand-slug">porsche.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell"><span class="country-flag">🇩🇪</span> Đức</td>
                    <td>1931</td>
                    <td class="num-cell">186</td>
                    <td class="avail-cell">124</td>
                    <td><span class="status-pill pill-active">HOẠT ĐỘNG</span></td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Xem xe" onclick="viewBrand('Porsche')"><i class="fa-solid fa-eye"></i></button>
                            <button class="act-btn" title="Sửa" onclick="editBrand(1)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteBrand(1)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr data-status="active" data-country="nhật bản">
                    <td>
                        <div class="brand-cell-wrap">
                            <div class="brand-logo" style="background:linear-gradient(135deg,#cc0000,#990000);">To</div>
                            <div>
                                <div class="brand-name">Toyota</div>
                                <div class="brand-slug">toyota.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell"><span class="country-flag">🇯🇵</span> Nhật Bản</td>
                    <td>1937</td>
                    <td class="num-cell">312</td>
                    <td class="avail-cell">218</td>
                    <td><span class="status-pill pill-active">HOẠT ĐỘNG</span></td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Xem xe" onclick="viewBrand('Toyota')"><i class="fa-solid fa-eye"></i></button>
                            <button class="act-btn" title="Sửa" onclick="editBrand(2)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteBrand(2)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr data-status="active" data-country="đức">
                    <td>
                        <div class="brand-cell-wrap">
                            <div class="brand-logo" style="background:linear-gradient(135deg,#1a56db,#1344b5);">BM</div>
                            <div>
                                <div class="brand-name">BMW</div>
                                <div class="brand-slug">bmw.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell"><span class="country-flag">🇩🇪</span> Đức</td>
                    <td>1916</td>
                    <td class="num-cell">203</td>
                    <td class="avail-cell">150</td>
                    <td><span class="status-pill pill-active">HOẠT ĐỘNG</span></td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Xem xe" onclick="viewBrand('BMW')"><i class="fa-solid fa-eye"></i></button>
                            <button class="act-btn" title="Sửa" onclick="editBrand(3)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteBrand(3)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr data-status="active" data-country="đức">
                    <td>
                        <div class="brand-cell-wrap">
                            <div class="brand-logo" style="background:linear-gradient(135deg,#111,#333);">MB</div>
                            <div>
                                <div class="brand-name">Mercedes</div>
                                <div class="brand-slug">mercedes-benz.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell"><span class="country-flag">🇩🇪</span> Đức</td>
                    <td>1926</td>
                    <td class="num-cell">178</td>
                    <td class="avail-cell">99</td>
                    <td><span class="status-pill pill-active">HOẠT ĐỘNG</span></td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Xem xe" onclick="viewBrand('Mercedes')"><i class="fa-solid fa-eye"></i></button>
                            <button class="act-btn" title="Sửa" onclick="editBrand(4)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteBrand(4)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr data-status="active" data-country="ý">
                    <td>
                        <div class="brand-cell-wrap">
                            <div class="brand-logo" style="background:linear-gradient(135deg,#ffd700,#b8860b);">La</div>
                            <div>
                                <div class="brand-name">Lamborghini</div>
                                <div class="brand-slug">lamborghini.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell"><span class="country-flag">🇮🇹</span> Ý</td>
                    <td>1963</td>
                    <td class="num-cell">48</td>
                    <td class="avail-cell">32</td>
                    <td><span class="status-pill pill-active">HOẠT ĐỘNG</span></td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Xem xe" onclick="viewBrand('Lamborghini')"><i class="fa-solid fa-eye"></i></button>
                            <button class="act-btn" title="Sửa" onclick="editBrand(5)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteBrand(5)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

                <tr data-status="inactive" data-country="mỹ">
                    <td>
                        <div class="brand-cell-wrap">
                            <div class="brand-logo" style="background:linear-gradient(135deg,#0ea5e9,#0369a1);">Lu</div>
                            <div>
                                <div class="brand-name">Lucid</div>
                                <div class="brand-slug">lucidmotors.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell"><span class="country-flag">🇺🇸</span> Mỹ</td>
                    <td>2007</td>
                    <td class="num-cell">56</td>
                    <td class="avail-cell">38</td>
                    <td><span class="status-pill pill-inactive">TẠM DỪNG</span></td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Xem xe" onclick="viewBrand('Lucid')"><i class="fa-solid fa-eye"></i></button>
                            <button class="act-btn" title="Sửa" onclick="editBrand(6)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteBrand(6)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- Empty state --}}
    <div id="empty-brands" style="display:none; padding:48px 20px; text-align:center; color:var(--text-muted);">
        <i class="fa-solid fa-ban" style="font-size:36px;opacity:.3;"></i>
        <p style="margin-top:10px;font-size:14px;font-weight:500;">Không tìm thấy hãng xe phù hợp.</p>
    </div>

    {{-- Footer --}}
    <div class="table-foot">
        <span class="foot-info" id="brand-foot-info">Hiển thị 1–6 trong tổng 48 hãng</span>
        <nav class="pagination" aria-label="Phân trang hãng xe">
            <button class="page-btn disabled" aria-label="Trang trước"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="page-btn active" aria-current="page">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn" aria-label="Trang tiếp"><i class="fa-solid fa-chevron-right"></i></button>
        </nav>
    </div>

</div>

{{-- MODAL: Thêm / Sửa hãng --}}
<div class="modal-overlay" id="brand-modal" role="dialog" aria-modal="true" aria-labelledby="brand-modal-title">
    <div class="modal">
        <div class="modal-header">
            <h2 id="brand-modal-title">Thêm hãng xe mới</h2>
            <button class="modal-close" id="brand-modal-close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="brand-name-input">Tên hãng</label>
                <input type="text" id="brand-name-input" placeholder="VD: Ferrari">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="brand-country">Quốc gia</label>
                    <select id="brand-country">
                        <option value="">Chọn quốc gia...</option>
                        <option>Đức</option>
                        <option>Nhật Bản</option>
                        <option>Hàn Quốc</option>
                        <option>Mỹ</option>
                        <option>Ý</option>
                        <option>Anh</option>
                        <option>Pháp</option>
                        <option>Trung Quốc</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand-founded">Năm thành lập</label>
                    <input type="number" id="brand-founded" placeholder="VD: 1950" min="1800" max="2030">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="brand-website">Website</label>
                    <input type="text" id="brand-website" placeholder="VD: ferrari.com">
                </div>
                <div class="form-group">
                    <label for="brand-status-input">Trạng thái</label>
                    <select id="brand-status-input">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Tạm dừng</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" id="brand-modal-cancel">Hủy bỏ</button>
            <button class="btn btn-primary" id="brand-modal-save">
                <i class="fa-solid fa-floppy-disk"></i> Lưu hãng xe
            </button>
        </div>
    </div>
</div>

{{-- Toast --}}
<div class="toast-stack" id="toast-stack" aria-live="polite"></div>
@endsection

@section('scripts')
<script>
(function(){
    'use strict';

    /* Modal */
    const modal      = document.getElementById('brand-modal');
    const modalTitle = document.getElementById('brand-modal-title');
    const openModal  = (title) => { modalTitle.textContent = title; modal.classList.add('open'); };
    const closeModal = () => modal.classList.remove('open');

    document.getElementById('btn-add-brand').addEventListener('click', () => openModal('Thêm hãng xe mới'));
    document.getElementById('brand-modal-close').addEventListener('click', closeModal);
    document.getElementById('brand-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    document.getElementById('brand-modal-save').addEventListener('click', () => {
        const name = document.getElementById('brand-name-input').value.trim();
        if(!name){ showToast('Vui lòng nhập tên hãng.','error'); return; }
        closeModal();
        showToast('Hãng xe đã được lưu thành công!','success');
        document.getElementById('brand-name-input').value = '';
    });

    /* Edit / View / Delete */
    window.editBrand   = (id) => openModal('Chỉnh sửa hãng xe #'+id);
    window.viewBrand   = (name) => showToast('Đang chuyển đến xe của hãng '+name+'...');
    window.deleteBrand = (id) => {
        if(confirm('Xóa hãng #'+id+'?')){
            showToast('Đã xóa hãng #'+id+'.','error');
        }
    };

    /* Search & Filter */
    const searchInput  = document.getElementById('brand-search');
    const filterCountry = document.getElementById('filter-country');
    const filterSt      = document.getElementById('filter-brand-status');
    const emptyEl       = document.getElementById('empty-brands');

    function filterTable(){
        const q  = searchInput.value.toLowerCase();
        const co = filterCountry.value.toLowerCase();
        const st = filterSt.value.toLowerCase();
        let visible = 0;

        document.querySelectorAll('#brands-tbody tr').forEach(row => {
            const name    = row.querySelector('.brand-name')?.textContent.toLowerCase()||'';
            const country = row.dataset.country||'';
            const status  = row.dataset.status||'';
            const show    = (!q||name.includes(q))
                         && (!co||country.includes(co))
                         && (!st||status===st);
            row.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        emptyEl.style.display = visible===0 ? 'block' : 'none';
        document.getElementById('brand-foot-info').textContent
            = visible===0 ? 'Không tìm thấy kết quả'
                           : `Hiển thị 1–${visible} trong tổng 48 hãng`;
    }

    searchInput.addEventListener('input', filterTable);
    filterCountry.addEventListener('change', filterTable);
    filterSt.addEventListener('change', filterTable);

    document.getElementById('btn-export-brands').addEventListener('click', () => showToast('Đang xuất dữ liệu hãng xe...'));

    /* Toast */
    function showToast(msg, type=''){
        const stack = document.getElementById('toast-stack');
        const el    = document.createElement('div');
        el.className = 'toast'+(type?' '+type:'');
        el.innerHTML = `<i class="fa-solid fa-${type==='success'?'circle-check':type==='error'?'circle-xmark':'circle-info'}"></i> ${msg}`;
        stack.appendChild(el);
        setTimeout(()=>{ el.classList.add('removing'); setTimeout(()=>el.remove(),220); },3000);
    }
})();
</script>
@endsection
