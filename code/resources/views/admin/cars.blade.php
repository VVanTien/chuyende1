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

    /* ====== UPLOAD ZONE ====== */
    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 20px 16px;
        text-align: center;
        cursor: pointer;
        background: var(--bg);
        transition: border-color .2s, background .2s;
        position: relative;
        min-height: 96px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .upload-zone:hover { border-color: var(--primary); background: var(--primary-light); }
    .upload-zone.drag-over { border-color: var(--primary); background: var(--primary-light); }
    .upload-placeholder { display: flex; flex-direction: column; align-items: center; gap: 6px; pointer-events: none; }
    .upload-icon { font-size: 26px; color: var(--text-muted); }
    .upload-text { font-size: 13px; font-weight: 600; color: var(--text-secondary); }
    .upload-hint { font-size: 11px; color: var(--text-muted); }
    .upload-preview { position: relative; display: flex; justify-content: center; width: 100%; }
    .upload-remove-btn {
        position: absolute; top: -8px; right: -8px;
        width: 22px; height: 22px;
        border-radius: 50%;
        background: var(--danger);
        color: #fff;
        border: none; cursor: pointer;
        font-size: 11px;
        display: flex; align-items: center; justify-content: center;
        z-index: 2;
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
            <span class="stat-value">{{ number_format($totalCars) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Có sẵn</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($availableCars) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Đang thuê</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($rentedCars) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Bảo dưỡng</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($maintenanceCars) }}</span>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('cars.index') }}" class="table-toolbar" id="filter-form">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" id="car-search" placeholder="Tìm tên xe, VIN..." aria-label="Tìm kiếm xe">
            <button type="submit" style="display:none;"></button>
        </div>
        <select class="filter-select" name="brand_id" aria-label="Lọc theo hãng" onchange="this.form.submit()">
            <option value="">Tất cả hãng</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
            @endforeach
        </select>
        <select class="filter-select" name="category_id" aria-label="Lọc theo dòng xe" onchange="this.form.submit()">
            <option value="">Tất cả dòng xe</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        <select class="filter-select" name="status" aria-label="Lọc theo trạng thái" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Có sẵn</option>
            <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Đang thuê</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Bảo dưỡng</option>
        </select>
        <div class="toolbar-spacer"></div>
    </form>

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
                @forelse($cars as $car)
                <tr>
                    <td>
                        <div class="thumb-wrap" style="width: 72px; height: 48px; border-radius: 6px; overflow: hidden; background: var(--bg); display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-light);">
                            @if($car->thumbnail)
                                <img src="{{ asset($car->thumbnail) }}" alt="{{ $car->name }}" style="width: 100%; height: 100%; object-fit: contain; padding: 3px;">
                            @else
                                <i class="fa-solid fa-car-side" style="color: var(--text-muted);"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="vname" style="font-weight: 700;">{{ $car->name }}</div>
                        <div class="vvin" style="font-size: 11px; color: var(--text-muted);">VIN: {{ $car->vin_code }}</div>
                    </td>
                    <td class="brand-cell" style="font-weight: 500;">{{ $car->brand->name ?? '-' }}</td>
                    <td class="price-cell" style="font-weight: 600; color: var(--success);">${{ number_format($car->sale_price) }}</td>
                    <td>
                        @if($car->status == 'available')
                            <span class="status-pill pill-available" style="background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">CÓ SẴN</span>
                        @elseif($car->status == 'rented')
                            <span class="status-pill pill-pending" style="background: #fef08a; color: #854d0e; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">ĐANG THUÊ</span>
                        @elseif($car->status == 'maintenance')
                            <span class="status-pill pill-sold" style="background: #fecdd3; color: #be123c; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">BẢO DƯỠNG</span>
                        @else
                            <span class="status-pill" style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ strtoupper($car->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="act-btn" title="Chỉnh sửa" onclick="editCar({{ $car }})"><i class="fa-solid fa-pen"></i></button>
                            <button type="button" class="act-btn danger" title="Xóa" onclick="confirmDeleteModal({{ $car->id }}, '{{ $car->name }}')"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-solid fa-car-burst" style="font-size:36px;opacity:.3;"></i>
                        <p style="margin-top:10px;font-size:14px;font-weight:500;">Không có dữ liệu xe.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="table-foot" style="padding: 14px 20px; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
        <span class="foot-info" id="car-foot-info" style="font-size: 13px; color: var(--text-secondary);">
            Hiển thị {{ $cars->firstItem() ?? 0 }}–{{ $cars->lastItem() ?? 0 }} trong tổng {{ number_format($cars->total()) }} xe
        </span>
        @php $cars->appends(request()->query()) @endphp
        <nav class="pagination" aria-label="Phân trang kho xe" style="display: flex; gap: 4px;">
            @if ($cars->onFirstPage())
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $cars->previousPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                @if ($page >= $cars->currentPage() - 2 && $page <= $cars->currentPage() + 2)
                    <a href="{{ $url }}" class="act-btn" style="{{ $page == $cars->currentPage() ? 'background: var(--primary); color: white;' : '' }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($cars->hasMorePages())
                <a href="{{ $cars->nextPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </nav>
    </div>
</div>

{{-- MODAL: Thêm / Sửa xe --}}
<div class="modal-overlay" id="car-modal" role="dialog" aria-modal="true" aria-labelledby="car-modal-title">
    <div class="modal" style="max-width: 600px;">
        <form id="car-form" action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="modal-header">
                <h2 id="car-modal-title">Thêm xe mới</h2>
                <button type="button" class="modal-close" id="car-modal-close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="car-name">Tên xe</label>
                        <input type="text" name="name" id="car-name" placeholder="VD: Porsche 911 Carrera S" required>
                    </div>
                    <div class="form-group">
                        <label for="car-vin">Số VIN</label>
                        <input type="text" name="vin_code" id="car-vin" placeholder="VD: LP921-X01" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="car-brand">Hãng xe</label>
                        <select name="brand_id" id="car-brand" required>
                            <option value="">Chọn hãng xe...</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="car-category">Dòng xe</label>
                        <select name="category_id" id="car-category">
                            <option value="">Chọn dòng xe...</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="car-year">Năm sản xuất</label>
                        <input type="number" name="year" id="car-year" placeholder="2024" min="1900" max="2030" required>
                    </div>
                    <div class="form-group">
                        <label for="car-price">Giá niêm yết (USD)</label>
                        <input type="number" name="sale_price" id="car-price" placeholder="0.00" step="100">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="car-daily-rate">Giá thuê/ngày (USD)</label>
                        <input type="number" name="daily_rate" id="car-daily-rate" placeholder="0.00" step="10">
                    </div>
                    <div class="form-group">
                        <label for="car-status">Trạng thái</label>
                        <select name="status" id="car-status">
                            <option value="available">Có sẵn</option>
                            <option value="rented">Đang thuê</option>
                            <option value="maintenance">Bảo dưỡng</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Hình ảnh (Thumbnail)</label>
                    <div class="upload-zone" id="car-thumb-zone" onclick="document.getElementById('car-thumbnail').click()">
                        <div class="upload-preview" id="car-thumb-preview" style="display:none;">
                            <img id="car-thumb-preview-img" src="" alt="Preview" style="max-height:140px; max-width:100%; border-radius:8px; object-fit:cover;">
                            <button type="button" class="upload-remove-btn" id="car-thumb-remove" title="Xóa ảnh">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="upload-placeholder" id="car-thumb-placeholder">
                            <i class="fa-solid fa-image upload-icon"></i>
                            <span class="upload-text">Nhấn để chọn hoặc kéo thả ảnh xe</span>
                            <span class="upload-hint">PNG, JPG, WEBP &mdash; tối đa 5MB</span>
                        </div>
                        <input type="file" name="thumbnail" id="car-thumbnail" accept="image/*" style="display:none;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="car-desc">Mô tả</label>
                    <textarea name="description" id="car-desc" rows="3" placeholder="Mô tả ngắn về xe..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="car-modal-cancel">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" id="car-modal-save"><i class="fa-solid fa-floppy-disk"></i> Lưu xe</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL XÓA --}}
<div class="modal-overlay" id="modal-delete">
    <div class="modal" style="max-width: 400px;">
        <form id="delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h2>Xác nhận xóa</h2>
                <button type="button" class="modal-close" onclick="closeDeleteModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa xe <strong id="delete-car-name"></strong> không? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" style="background: var(--danger);"><i class="fa-solid fa-trash"></i> Xóa</button>
            </div>
        </form>
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
    const form        = document.getElementById('car-form');
    const formMethod  = document.getElementById('form-method');

    const openModal   = (title) => { modalTitle.textContent = title; modal.classList.add('open'); };
    const closeModal  = () => modal.classList.remove('open');

    /* Reset upload zone helper */
    function resetUploadZone() {
        const input       = document.getElementById('car-thumbnail');
        const preview     = document.getElementById('car-thumb-preview');
        const previewImg  = document.getElementById('car-thumb-preview-img');
        const placeholder = document.getElementById('car-thumb-placeholder');
        if (input)       input.value = '';
        if (previewImg)  previewImg.src = '';
        if (preview)     preview.style.display = 'none';
        if (placeholder) placeholder.style.display = 'flex';
    }

    document.getElementById('btn-add-car').addEventListener('click', () => {
        form.reset();
        form.action = "{{ route('cars.store') }}";
        formMethod.value = "POST";
        resetUploadZone();
        openModal('Thêm xe mới');
    });

    document.getElementById('car-modal-close').addEventListener('click', closeModal);
    document.getElementById('car-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    /* Edit / Delete */
    window.editCar = (car) => {
        form.action = `/admin/cars/${car.id}`;
        formMethod.value = "PUT";
        resetUploadZone();
        
        document.getElementById('car-name').value = car.name;
        document.getElementById('car-vin').value = car.vin_code;
        document.getElementById('car-brand').value = car.brand_id || '';
        document.getElementById('car-category').value = car.category_id || '';
        document.getElementById('car-year').value = car.year;
        document.getElementById('car-price').value = car.sale_price || '';
        document.getElementById('car-daily-rate').value = car.daily_rate || '';
        document.getElementById('car-status').value = car.status || 'available';
        document.getElementById('car-desc').value = car.description || '';
        
        openModal('Chỉnh sửa xe: ' + car.name);
    };

    /* DELETE MODAL */
    const modalDelete = document.getElementById('modal-delete');
    const deleteForm = document.getElementById('delete-form');
    const deleteCarName = document.getElementById('delete-car-name');

    window.confirmDeleteModal = function(id, name) {
        deleteCarName.textContent = name;
        deleteForm.action = `/admin/cars/${id}`;
        modalDelete.classList.add('open');
    }

    window.closeDeleteModal = function() {
        modalDelete.classList.remove('open');
    }
    modalDelete.addEventListener('click', (e) => { if (e.target === modalDelete) closeDeleteModal(); });

    /* AUTO-SUBMIT SEARCH */
    const searchInput = document.querySelector('input[name="search"]');
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 600);
        });
    }

    /* Export btn */
    document.getElementById('btn-export').addEventListener('click', () => showToast('Đang xuất dữ liệu...'));

    /* Toast */
    window.showToast = function(msg, type=''){
        const stack = document.getElementById('toast-stack');
        const el    = document.createElement('div');
        el.className = 'toast'+(type?' '+type:'');
        el.innerHTML = `<i class="fa-solid fa-${type==='success'?'circle-check':type==='error'?'circle-xmark':'circle-info'}"></i> ${msg}`;
        stack.appendChild(el);
        setTimeout(()=>{ el.classList.add('removing'); setTimeout(()=>el.remove(),220); },3000);
    }

    /* FLASH MESSAGES */
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            showToast("{{ $error }}", "error");
        @endforeach
    @endif

    @if (session('success'))
        showToast("{{ session('success') }}", "success");
    @endif
})();
</script>

<script>
/* ====== Upload Zone: Car Thumbnail ====== */
(function(){
    function setupUploadZone(inputId, previewId, previewImgId, placeholderId, removeId, zoneId) {
        const input       = document.getElementById(inputId);
        const preview     = document.getElementById(previewId);
        const previewImg  = document.getElementById(previewImgId);
        const placeholder = document.getElementById(placeholderId);
        const removeBtn   = document.getElementById(removeId);
        const zone        = document.getElementById(zoneId);

        if (!input) return;

        input.addEventListener('change', function(){
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewImg.src = e.target.result;
                    preview.style.display = 'flex';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        removeBtn.addEventListener('click', function(e){
            e.stopPropagation();
            input.value = '';
            previewImg.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'flex';
        });

        // Drag & drop
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    }

    setupUploadZone(
        'car-thumbnail', 'car-thumb-preview', 'car-thumb-preview-img',
        'car-thumb-placeholder', 'car-thumb-remove', 'car-thumb-zone'
    );
})();
</script>
@endsection
