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

@php
$countryMap = [
    'China'       => 'Trung Quốc',
    'France'      => 'Pháp',
    'Germany'     => 'Đức',
    'India'       => 'Ấn Độ',
    'Italy'       => 'Ý',
    'Japan'       => 'Nhật Bản',
    'South Korea' => 'Hàn Quốc',
    'Sweden'      => 'Thụy Điển',
    'UK'          => 'Anh',
    'USA'         => 'Mỹ',
    'Vietnam'     => 'Việt Nam',
];
@endphp

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
            <span class="stat-value">{{ number_format($totalBrands) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Hãng hoạt động</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($activeBrands) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng số xe</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($totalCars) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Hãng xe mới (tháng)</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($newBrandsThisMonth) }}</span>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('brands.index') }}" class="table-toolbar" id="filter-form">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" id="brand-search" placeholder="Tìm tên hãng..." aria-label="Tìm kiếm hãng">
            <button type="submit" style="display:none;"></button>
        </div>
        <select class="filter-select" name="country" aria-label="Lọc theo quốc gia" onchange="this.form.submit()">
            <option value="">Tất cả quốc gia</option>
            @foreach($countries as $c)
                <option value="{{ $c }}" {{ request('country') == $c ? 'selected' : '' }}>
                    {{ $countryMap[$c] ?? $c }}
                </option>
            @endforeach
        </select>
        <select class="filter-select" name="status" aria-label="Lọc theo trạng thái" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
        </select>
        <div class="toolbar-spacer"></div>
    </form>

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
                @forelse($brands as $brand)
                <tr>
                    <td>
                        <div class="brand-cell-wrap">
                            @if($brand->logo_theme)
                                <img src="{{ asset($brand->logo_theme) }}" alt="{{ $brand->name }}" style="width: 46px; height: 46px; border-radius: 10px; object-fit: contain; padding: 4px; background: var(--surface); border: 1px solid var(--border-light);">
                            @else
                                <div class="brand-logo" style="background:linear-gradient(135deg, #1a56db, #1344b5); color: #fff; font-weight: bold; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                    {{ substr($brand->name, 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <div class="brand-name">{{ $brand->name }}</div>
                                <div class="brand-slug">{{ $brand->website_url ?? $brand->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="country-cell">{{ $countryMap[$brand->country] ?? ($brand->country ?? '-') }}</td>
                    <td>{{ $brand->established_year ?? '-' }}</td>
                    <td class="num-cell" style="text-align: right;">{{ $brand->cars_count }}</td>
                    <td class="avail-cell" style="text-align: right;">-</td>
                    <td>
                        @if($brand->status == 'active')
                            <span class="status-pill pill-active">HOẠT ĐỘNG</span>
                        @else
                            <span class="status-pill pill-inactive">TẠM DỪNG</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="act-btn" title="Sửa" onclick="editBrand({{ $brand }})"><i class="fa-solid fa-pen"></i></button>
                            <button type="button" class="act-btn danger" title="Xóa" onclick="confirmDeleteModal({{ $brand->id }}, '{{ $brand->name }}')"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-solid fa-ban" style="font-size:36px;opacity:.3;"></i>
                        <p style="margin-top:10px;font-size:14px;font-weight:500;">Không có dữ liệu hãng xe.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="table-foot" style="padding: 14px 20px; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
        <span class="foot-info" id="brand-foot-info" style="font-size: 13px; color: var(--text-secondary);">
            Hiển thị {{ $brands->firstItem() ?? 0 }}–{{ $brands->lastItem() ?? 0 }} trong tổng {{ number_format($brands->total()) }} hãng xe
        </span>
        @php $brands->appends(request()->query()) @endphp
        <nav class="pagination" aria-label="Phân trang hãng xe" style="display: flex; gap: 4px;">
            @if ($brands->onFirstPage())
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $brands->previousPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                @if ($page >= $brands->currentPage() - 2 && $page <= $brands->currentPage() + 2)
                    <a href="{{ $url }}" class="act-btn" style="{{ $page == $brands->currentPage() ? 'background: var(--primary); color: white;' : '' }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($brands->hasMorePages())
                <a href="{{ $brands->nextPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </nav>
    </div>
</div>

{{-- MODAL: Thêm / Sửa hãng --}}
<div class="modal-overlay" id="brand-modal" role="dialog" aria-modal="true" aria-labelledby="brand-modal-title">
    <div class="modal">
        <form id="brand-form" action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="modal-header">
                <h2 id="brand-modal-title">Thêm hãng xe mới</h2>
                <button type="button" class="modal-close" id="brand-modal-close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="brand-name-input">Tên hãng</label>
                    <input type="text" name="name" id="brand-name-input" placeholder="VD: Ferrari" required>
                </div>
                <div class="form-group" style="margin-bottom: 14px;">
                    <label>Hình ảnh Logo</label>
                    <div class="upload-zone" id="brand-logo-zone" onclick="document.getElementById('brand-logo').click()">
                        <div class="upload-preview" id="brand-logo-preview" style="display:none;">
                            <img id="brand-logo-preview-img" src="" alt="Preview" style="max-height:120px; max-width:100%; border-radius:8px; object-fit:contain;">
                            <button type="button" class="upload-remove-btn" id="brand-logo-remove" title="Xóa ảnh">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="upload-placeholder" id="brand-logo-placeholder">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                            <span class="upload-text">Nhấn để chọn hoặc kéo thả ảnh</span>
                            <span class="upload-hint">PNG, JPG, SVG, WEBP &mdash; tối đa 2MB</span>
                        </div>
                        <input type="file" name="logo_theme" id="brand-logo" accept="image/*" style="display:none;">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="brand-country">Quốc gia</label>
                        <select name="country" id="brand-country">
                            <option value="">-- Chọn quốc gia --</option>
                            @php
                                $countryList = collect([
                                    'China'        => 'Trung Quốc',
                                    'France'       => 'Pháp',
                                    'Germany'      => 'Đức',
                                    'India'        => 'Ấn Độ',
                                    'Italy'        => 'Ý',
                                    'Japan'        => 'Nhật Bản',
                                    'South Korea'  => 'Hàn Quốc',
                                    'Sweden'       => 'Thụy Điển',
                                    'UK'           => 'Anh',
                                    'USA'          => 'Mỹ',
                                    'Vietnam'      => 'Việt Nam',
                                ]);
                                // Gộp thêm quốc gia từ DB nếu chưa có trong danh sách
                                foreach ($countries as $dbCountry) {
                                    if (!$countryList->has($dbCountry)) {
                                        $countryList->put($dbCountry, $dbCountry);
                                    }
                                }
                                $countryList = $countryList->sortKeys();
                            @endphp
                            @foreach($countryList as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand-founded">Năm thành lập</label>
                        <input type="number" name="established_year" id="brand-founded" placeholder="VD: 1950">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="brand-website">Website</label>
                        <input type="url" name="website_url" id="brand-website" placeholder="VD: https://ferrari.com">
                    </div>
                    <div class="form-group">
                        <label for="brand-status-input">Trạng thái</label>
                        <select name="status" id="brand-status-input">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Tạm dừng</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="brand-modal-cancel">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" id="brand-modal-save">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu hãng xe
                </button>
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
                <p>Bạn có chắc chắn muốn xóa hãng xe <strong id="delete-brand-name"></strong> không? Hành động này không thể hoàn tác.</p>
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
    const modal      = document.getElementById('brand-modal');
    const modalTitle = document.getElementById('brand-modal-title');
    const form       = document.getElementById('brand-form');
    const formMethod = document.getElementById('form-method');

    const openModal  = (title) => { modalTitle.textContent = title; modal.classList.add('open'); };
    const closeModal = () => modal.classList.remove('open');

    /* Reset upload zone helper */
    function resetUploadZone() {
        const input       = document.getElementById('brand-logo');
        const preview     = document.getElementById('brand-logo-preview');
        const previewImg  = document.getElementById('brand-logo-preview-img');
        const placeholder = document.getElementById('brand-logo-placeholder');
        if (input)       input.value = '';
        if (previewImg)  previewImg.src = '';
        if (preview)     preview.style.display = 'none';
        if (placeholder) placeholder.style.display = 'flex';
    }

    document.getElementById('btn-add-brand').addEventListener('click', () => {
        form.reset();
        form.action = "{{ route('brands.store') }}";
        formMethod.value = "POST";
        resetUploadZone();
        openModal('Thêm hãng xe mới');
    });

    document.getElementById('brand-modal-close').addEventListener('click', closeModal);
    document.getElementById('brand-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    /* Edit / Delete */
    window.editBrand = (brand) => {
        form.action = `/admin/brands/${brand.id}`;
        formMethod.value = "PUT";
        resetUploadZone();
        
        document.getElementById('brand-name-input').value = brand.name;
        document.getElementById('brand-country').value = brand.country || '';
        document.getElementById('brand-founded').value = brand.established_year || '';
        document.getElementById('brand-website').value = brand.website_url || '';
        document.getElementById('brand-status-input').value = brand.status || 'active';
        
        openModal('Chỉnh sửa hãng xe: ' + brand.name);
    };

    /* DELETE MODAL */
    const modalDelete = document.getElementById('modal-delete');
    const deleteForm = document.getElementById('delete-form');
    const deleteBrandName = document.getElementById('delete-brand-name');

    window.confirmDeleteModal = function(id, name) {
        deleteBrandName.textContent = name;
        deleteForm.action = `/admin/brands/${id}`;
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
/* ====== Upload Zone: Brand Logo ====== */
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
        'brand-logo', 'brand-logo-preview', 'brand-logo-preview-img',
        'brand-logo-placeholder', 'brand-logo-remove', 'brand-logo-zone'
    );
})();
</script>
@endsection
