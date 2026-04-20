@extends('admin.layouts.master')

@section('title', 'Kho xe — Fleet Management')

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
    .btn-ghost:hover {
        background: var(--bg);
        color: var(--text-primary);
    }

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
    .stat-value-row {
        display: flex;
        align-items: baseline;
        gap: 7px;
    }
    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -1px;
        line-height: 1;
    }
    .stat-tag {
        font-size: 12px;
        font-weight: 700;
        color: var(--success);
    }
    .stat-tag.hot   { color: var(--danger); }
    .stat-tag.pct   { color: var(--text-muted); font-weight: 600; }

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
        max-width: 300px;
        min-width: 180px;
    }
    .t-search i {
        position: absolute;
        left: 11px;
        top: 50%;
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
        padding: 8px 30px 8px 11px;
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

    /* Data table */
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

    /* Thumbnail */
    .thumb-wrap {
        width: 68px;
        height: 46px;
        border-radius: 8px;
        background: var(--bg);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .thumb-wrap i { font-size: 22px; color: var(--text-muted); }

    /* Vehicle name + VIN */
    .vname { font-size: 13.5px; font-weight: 600; color: var(--text-primary); line-height: 1.2; }
    .vvin  { font-size: 11px; color: var(--text-muted); margin-top: 2px; letter-spacing: .3px; }

    /* Brand */
    .brand-cell { color: var(--text-secondary); font-weight: 500; }

    /* Price */
    .price-cell { font-weight: 700; color: var(--text-primary); }

    /* Status pills */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: .1px;
    }
    .pill-available { background: #d1fae5; color: #065f46; }
    .pill-pending   { background: #fef3c7; color: #92400e; }
    .pill-sold      { background: #fee2e2; color: #991b1b; }

    /* Actions */
    .action-group {
        display: flex;
        align-items: center;
        gap: 4px;
        justify-content: flex-end;
    }
    .act-btn {
        width: 31px;
        height: 31px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
        color: var(--text-muted);
        cursor: pointer;
        transition: background var(--transition), color var(--transition);
        border: none;
        background: none;
        text-decoration: none;
    }
    .act-btn:hover { background: var(--bg); color: var(--text-primary); }
    .act-btn.danger:hover { background: #fee2e2; color: var(--danger); }

    /* Pagination */
    .table-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 20px;
        border-top: 1px solid var(--border-light);
        background: var(--bg);
        flex-wrap: wrap;
        gap: 10px;
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
        width: 100%; max-width: 540px;
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
    .form-group select,
    .form-group textarea {
        padding: 8.5px 11px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: inherit; font-size: 13.5px;
        color: var(--text-primary); outline: none;
        background: var(--surface);
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
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
    @keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
    @keyframes slideOut { from { opacity:1; } to { opacity:0; transform:translateX(20px); } }
    .toast.removing { animation: slideOut .2s ease forwards; }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2,1fr); }
        .form-row   { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-super">INVENTORY OVERVIEW</div>
<div class="page-title-row">
    <h1>Quản lý kho xe</h1>
    <button class="btn btn-primary" id="btn-add-car">
        <i class="fa-solid fa-car"></i> Thêm xe mới
    </button>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Tổng đơn vị</div>
        <div class="stat-value-row">
            <span class="stat-value">1,284</span>
            <span class="stat-tag">+4%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Có sẵn</div>
        <div class="stat-value-row">
            <span class="stat-value">842</span>
            <span class="stat-tag pct">65%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Bán hàng tháng</div>
        <div class="stat-value-row">
            <span class="stat-value">156</span>
            <span class="stat-tag">+12%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Khách hàng tiềm năng</div>
        <div class="stat-value-row">
            <span class="stat-value">42</span>
            <span class="stat-tag hot">Hot</span>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">

    {{-- Toolbar --}}
    <div class="table-toolbar">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="car-search" placeholder="Tìm tên xe, VIN..." aria-label="Tìm kiếm xe">
        </div>
        <select class="filter-select" id="filter-brand" aria-label="Lọc theo hãng">
            <option value="">Tất cả hãng</option>
            <option>Porsche</option>
            <option>Lucid</option>
            <option>Mercedes</option>
            <option>BMW</option>
            <option>Toyota</option>
        </select>
        <select class="filter-select" id="filter-status" aria-label="Lọc theo trạng thái">
            <option value="">Tất cả trạng thái</option>
            <option value="available">Có sẵn</option>
            <option value="pending">Chờ xử lý</option>
            <option value="sold">Đã bán</option>
        </select>
        <div class="toolbar-spacer"></div>
        <button class="btn btn-ghost" id="btn-export">
            <i class="fa-solid fa-download"></i> Xuất
        </button>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="data-table" id="cars-table" aria-label="Danh sách xe">
            <thead>
                <tr>
                    <th>THUMBNAIL</th>
                    <th>TÊN XE</th>
                    <th>HÃNG</th>
                    <th>GIÁ</th>
                    <th>TRẠNG THÁI</th>
                    <th style="text-align:right;">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody id="cars-tbody">
                <tr data-status="available">
                    <td><div class="thumb-wrap"><i class="fa-solid fa-car-side"></i></div></td>
                    <td>
                        <div class="vname">911 Carrera S</div>
                        <div class="vvin">VIN: LP921-X01</div>
                    </td>
                    <td class="brand-cell">Porsche</td>
                    <td class="price-cell">$114,400</td>
                    <td><span class="status-pill pill-available">CÓ SẴN</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="act-btn" title="Xem chi tiết"><i class="fa-solid fa-eye"></i></a>
                            <button class="act-btn" title="Chỉnh sửa" onclick="editCar(1)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteCar(1)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr data-status="pending">
                    <td><div class="thumb-wrap"><i class="fa-solid fa-car-side"></i></div></td>
                    <td>
                        <div class="vname">Lucid Air Dream</div>
                        <div class="vvin">VIN: LA001-Z99</div>
                    </td>
                    <td class="brand-cell">Lucid</td>
                    <td class="price-cell">$169,000</td>
                    <td><span class="status-pill pill-pending">CHỜ XỬ LÝ</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="act-btn" title="Xem"><i class="fa-solid fa-eye"></i></a>
                            <button class="act-btn" title="Sửa" onclick="editCar(2)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteCar(2)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr data-status="sold">
                    <td><div class="thumb-wrap"><i class="fa-solid fa-car-side"></i></div></td>
                    <td>
                        <div class="vname">G-Wagon G63</div>
                        <div class="vvin">VIN: MB882-G21</div>
                    </td>
                    <td class="brand-cell">Mercedes</td>
                    <td class="price-cell">$179,000</td>
                    <td><span class="status-pill pill-sold">ĐÃ BÁN</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="act-btn" title="Xem"><i class="fa-solid fa-eye"></i></a>
                            <button class="act-btn" title="Sửa" onclick="editCar(3)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteCar(3)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr data-status="available">
                    <td><div class="thumb-wrap"><i class="fa-solid fa-car-side"></i></div></td>
                    <td>
                        <div class="vname">BMW i7 M70</div>
                        <div class="vvin">VIN: BM-882-LL</div>
                    </td>
                    <td class="brand-cell">BMW</td>
                    <td class="price-cell">$135,000</td>
                    <td><span class="status-pill pill-available">CÓ SẴN</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="act-btn" title="Xem"><i class="fa-solid fa-eye"></i></a>
                            <button class="act-btn" title="Sửa" onclick="editCar(4)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteCar(4)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr data-status="available">
                    <td><div class="thumb-wrap"><i class="fa-solid fa-car-side"></i></div></td>
                    <td>
                        <div class="vname">Toyota Land Cruiser 300</div>
                        <div class="vvin">VIN: TY300-2024</div>
                    </td>
                    <td class="brand-cell">Toyota</td>
                    <td class="price-cell">$88,500</td>
                    <td><span class="status-pill pill-available">CÓ SẴN</span></td>
                    <td>
                        <div class="action-group">
                            <a href="#" class="act-btn" title="Xem"><i class="fa-solid fa-eye"></i></a>
                            <button class="act-btn" title="Sửa" onclick="editCar(5)"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="deleteCar(5)"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Empty state --}}
    <div id="empty-cars" style="display:none; padding:48px 20px; text-align:center; color:var(--text-muted);">
        <i class="fa-solid fa-car-burst" style="font-size:36px;opacity:.3;"></i>
        <p style="margin-top:10px;font-size:14px;font-weight:500;">Không tìm thấy xe phù hợp.</p>
    </div>

    {{-- Footer --}}
    <div class="table-foot">
        <span class="foot-info" id="car-foot-info">Hiển thị 1–5 trong 1,284 xe</span>
        <nav class="pagination" aria-label="Phân trang kho xe">
            <button class="page-btn disabled" aria-label="Trang trước"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="page-btn active" aria-current="page">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <span style="color:var(--text-muted);font-size:12px;padding:0 4px;align-self:center;">…</span>
            <button class="page-btn">257</button>
            <button class="page-btn" aria-label="Trang tiếp"><i class="fa-solid fa-chevron-right"></i></button>
        </nav>
    </div>

</div>

{{-- MODAL: Thêm / Sửa xe --}}
<div class="modal-overlay" id="car-modal" role="dialog" aria-modal="true" aria-labelledby="car-modal-title">
    <div class="modal">
        <div class="modal-header">
            <h2 id="car-modal-title">Thêm xe mới</h2>
            <button class="modal-close" id="car-modal-close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                    <label for="car-name">Tên xe</label>
                    <input type="text" id="car-name" placeholder="VD: Porsche 911 Carrera S">
                </div>
                <div class="form-group">
                    <label for="car-vin">Số VIN</label>
                    <input type="text" id="car-vin" placeholder="VD: LP921-X01">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="car-brand">Hãng xe</label>
                    <select id="car-brand">
                        <option value="">Chọn hãng...</option>
                        <option>Porsche</option>
                        <option>Lucid</option>
                        <option>Mercedes</option>
                        <option>BMW</option>
                        <option>Toyota</option>
                        <option>Audi</option>
                        <option>Ferrari</option>
                        <option>Lamborghini</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="car-year">Năm sản xuất</label>
                    <input type="number" id="car-year" placeholder="2024" min="2000" max="2030">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="car-price">Giá niêm yết (USD)</label>
                    <input type="number" id="car-price" placeholder="0.00" step="100">
                </div>
                <div class="form-group">
                    <label for="car-status">Trạng thái</label>
                    <select id="car-status">
                        <option value="available">Có sẵn</option>
                        <option value="pending">Chờ xử lý</option>
                        <option value="sold">Đã bán</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="car-desc">Mô tả</label>
                <textarea id="car-desc" rows="3" placeholder="Mô tả ngắn về xe..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" id="car-modal-cancel">Hủy bỏ</button>
            <button class="btn btn-primary" id="car-modal-save"><i class="fa-solid fa-floppy-disk"></i> Lưu xe</button>
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
    const modal       = document.getElementById('car-modal');
    const modalTitle  = document.getElementById('car-modal-title');
    const openModal   = (title) => { modalTitle.textContent = title; modal.classList.add('open'); };
    const closeModal  = () => modal.classList.remove('open');

    document.getElementById('btn-add-car').addEventListener('click', () => openModal('Thêm xe mới'));
    document.getElementById('car-modal-close').addEventListener('click', closeModal);
    document.getElementById('car-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    document.getElementById('car-modal-save').addEventListener('click', () => {
        const name = document.getElementById('car-name').value.trim();
        if(!name){ showToast('Vui lòng nhập tên xe.','error'); return; }
        closeModal();
        showToast('Xe đã được lưu thành công!','success');
    });

    /* Edit / Delete */
    window.editCar   = (id) => openModal('Chỉnh sửa xe #'+id);
    window.deleteCar = (id) => {
        if(confirm('Xóa xe #'+id+'?')){
            document.querySelector(`tr:nth-child(${id})`);
            showToast('Đã xóa xe #'+id+'.','error');
        }
    };

    /* Search & Filter */
    const searchInput = document.getElementById('car-search');
    const filterBrand = document.getElementById('filter-brand');
    const filterSt    = document.getElementById('filter-status');
    const emptyEl     = document.getElementById('empty-cars');

    function filterTable(){
        const q  = searchInput.value.toLowerCase();
        const br = filterBrand.value.toLowerCase();
        const st = filterSt.value.toLowerCase();
        let visible = 0;
        document.querySelectorAll('#cars-tbody tr').forEach(row => {
            const name   = row.querySelector('.vname')?.textContent.toLowerCase()||'';
            const vin    = row.querySelector('.vvin')?.textContent.toLowerCase()||'';
            const brand  = row.querySelector('.brand-cell')?.textContent.toLowerCase()||'';
            const status = row.dataset.status||'';
            const show   = (!q||(name.includes(q)||vin.includes(q)))
                        && (!br||brand===br)
                        && (!st||status===st);
            row.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        emptyEl.style.display = visible===0 ? 'block' : 'none';
        document.getElementById('car-foot-info').textContent
            = visible===0 ? 'Không tìm thấy kết quả'
                           : `Hiển thị 1–${visible} trong 1,284 xe`;
    }

    searchInput.addEventListener('input', filterTable);
    filterBrand.addEventListener('change', filterTable);
    filterSt.addEventListener('change', filterTable);

    /* Export btn */
    document.getElementById('btn-export').addEventListener('click', () => showToast('Đang xuất dữ liệu...'));

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
