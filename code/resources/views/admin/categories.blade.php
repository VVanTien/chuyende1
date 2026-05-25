@extends('admin.layouts.master')

@section('title', 'Dòng xe — Category Management')

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
    .data-table tbody tr:hover { background: #fafbff; }
    .data-table td {
        padding: 14px 16px;
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Thumbnail */
    .thumb-wrap {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: var(--bg);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .thumb-wrap i { font-size: 20px; color: var(--text-muted); }

    /* Names */
    .cname { font-size: 14px; font-weight: 600; color: var(--primary); }
    .cslug { font-size: 11px; color: var(--text-muted); font-family: monospace; }
    .cdesc { color: var(--text-secondary); max-width: 250px; white-space: normal; line-height: 1.4; }

    /* Status pills */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .pill-active { background: #d1fae5; color: #065f46; }
    .pill-inactive { background: #fee2e2; color: #991b1b; }

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
    }
    .act-btn:hover { background: var(--bg); color: var(--text-primary); }
    .act-btn.danger:hover { background: #fee2e2; color: var(--danger); }

    /* Modal & Toast (Reused identical from cars.blade.php) */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15,23,42,.45); z-index: 1000;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; backdrop-filter: blur(3px);
        transition: opacity .2s ease, visibility .2s;
    }
    .modal-overlay.open { opacity: 1; visibility: visible; }
    .modal {
        background: var(--surface); border-radius: 16px; width: 100%; max-width: 500px;
        box-shadow: 0 24px 80px rgba(0,0,0,.18); transform: scale(.96) translateY(12px);
        transition: transform .2s ease; overflow: hidden;
    }
    .modal-overlay.open .modal { transform: scale(1) translateY(0); }
    .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 16px; border-bottom: 1px solid var(--border); }
    .modal-header h2 { font-size: 16px; font-weight: 700; }
    .modal-close { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); cursor: pointer; border:none; background:none; }
    .modal-close:hover { background: var(--bg); color: var(--text-primary); }
    .modal-body { padding: 20px 24px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
    .form-group label { font-size: 12px; font-weight: 600; color: var(--text-secondary); }
    .form-group input, .form-group select, .form-group textarea { padding: 8.5px 11px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13.5px; outline: none; transition: border-color .3s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); }
    .modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 24px 20px; border-top: 1px solid var(--border); }

    .toast-stack { position: fixed; bottom: 24px; right: 24px; z-index: 2000; display: flex; flex-direction: column; gap: 8px; pointer-events: none; }
    .toast { display: flex; align-items: center; gap: 10px; background: var(--text-primary); color: #fff; padding: 11px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; animation: slideIn .25s ease forwards; pointer-events: auto; }
    .toast.success { background: #065f46; }
    .toast.error   { background: #991b1b; }
    @keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
    @keyframes slideOut { from { opacity:1; } to { opacity:0; transform:translateX(20px); } }
    .toast.removing { animation: slideOut .2s ease forwards; }
</style>
@endsection

@section('content')
<div class="page-super">CATEGORY OVERVIEW</div>
<div class="page-title-row">
    <h1>Quản lý Dòng xe</h1>
    <button class="btn btn-primary" id="btn-add-cat">
        <i class="fa-solid fa-plus"></i> Thêm Dòng Xe
    </button>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Tổng số Dòng xe</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($totalCategories) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Đang hoạt động</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($activeCategories) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng số xe (Tất cả)</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($totalCars) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tạm ẩn</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($inactiveCategories) }}</span>
        </div>
    </div>
</div>

<div class="table-card">
    <form method="GET" action="{{ route('categories.index') }}" class="table-toolbar" id="filter-form">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" id="search-input" placeholder="Tìm tên dòng xe, mã slug...">
            <button type="submit" style="display:none;"></button>
        </div>
        <div class="toolbar-spacer"></div>
    </form>

    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ICON</th>
                    <th>DÒNG XE</th>
                    <th>MÔ TẢ</th>
                    <th>SỐ LƯỢNG XE</th>
                    <th>TRẠNG THÁI</th>
                    <th style="text-align:right;">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody id="data-tbody">
                @forelse($categories as $cat)
                <tr>
                    <td><div class="thumb-wrap"><i class="fa-solid fa-car-side"></i></div></td>
                    <td>
                        <div class="cname">{{ $cat->name }}</div>
                        <div class="cslug">/{{ $cat->slug }}</div>
                    </td>
                    <td><div class="cdesc">{{ Str::limit($cat->description, 50) }}</div></td>
                    <td style="font-weight: 600;">{{ $cat->cars_count }}</td>
                    <td>
                        @if($cat->status == 'active')
                            <span class="status-pill pill-active">HOẠT ĐỘNG</span>
                        @else
                            <span class="status-pill pill-inactive">TẠM ẨN</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" onclick="editCat({{ $cat }})"><i class="fa-solid fa-pen"></i></button>
                            <button type="button" class="act-btn danger" onclick="confirmDeleteModal({{ $cat->id }}, '{{ $cat->name }}')"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">Không có dữ liệu dòng xe.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TABLE FOOTER --}}
    <div class="table-foot" style="padding: 14px 20px; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
        <span class="table-foot-info" style="font-size: 13px; color: var(--text-secondary);">
            Hiển thị {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }} trong tổng {{ number_format($categories->total()) }} dòng xe
        </span>
        @php $categories->appends(request()->query()) @endphp
        <nav class="pagination" aria-label="Phân trang" style="display: flex; gap: 4px;">
            @if ($categories->onFirstPage())
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $categories->previousPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                @if ($page >= $categories->currentPage() - 2 && $page <= $categories->currentPage() + 2)
                    <a href="{{ $url }}" class="act-btn" style="{{ $page == $categories->currentPage() ? 'background: var(--primary); color: white;' : '' }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($categories->hasMorePages())
                <a href="{{ $categories->nextPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </nav>
    </div>
</div>

{{-- MODAL THÊM/SỬA --}}
<div class="modal-overlay" id="main-modal">
    <div class="modal">
        <form id="cat-form" action="{{ route('categories.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="modal-header">
                <h2 id="modal-title">Thêm Dòng xe mới</h2>
                <button type="button" class="modal-close" id="modal-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên dòng xe</label>
                    <input type="text" name="name" id="input-name" placeholder="VD: SUV, Sedan..." required>
                </div>
                <div class="form-group">
                    <label>Mã Slug (Tùy chọn)</label>
                    <input type="text" name="slug" id="input-slug" placeholder="VD: suv (Tự động tạo nếu để trống)">
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" id="input-status">
                        <option value="active">Đang hoạt động</option>
                        <option value="inactive">Tạm ẩn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" id="input-desc" rows="3" placeholder="Mô tả về dòng xe..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="modal-cancel">Hủy</button>
                <button type="submit" class="btn btn-primary" id="modal-save"><i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi</button>
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
                <p>Bạn có chắc chắn muốn xóa dòng xe <strong id="delete-cat-name"></strong> không? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" style="background: var(--danger);"><i class="fa-solid fa-trash"></i> Xóa</button>
            </div>
        </form>
    </div>
</div>

<div class="toast-stack" id="toast-stack"></div>
@endsection

@section('scripts')
<script>
(function(){
    const modal = document.getElementById('main-modal');
    const title = document.getElementById('modal-title');
    const form  = document.getElementById('cat-form');
    const formMethod = document.getElementById('form-method');

    const openM = (t) => { title.textContent=t; modal.classList.add('open'); };
    const closeM= () => modal.classList.remove('open');

    document.getElementById('btn-add-cat').onclick = () => {
        form.reset();
        form.action = "{{ route('categories.store') }}";
        formMethod.value = "POST";
        openM('Thêm Dòng xe mới');
    };
    
    document.getElementById('modal-close').onclick = closeM;
    document.getElementById('modal-cancel').onclick = closeM;
    modal.addEventListener('click', (e) => { if (e.target === modal) closeM(); });
    
    window.editCat = (cat) => {
        form.action = `/admin/categories/${cat.id}`;
        formMethod.value = "PUT";
        
        document.getElementById('input-name').value = cat.name;
        document.getElementById('input-slug').value = cat.slug || '';
        document.getElementById('input-status').value = cat.status || 'active';
        document.getElementById('input-desc').value = cat.description || '';
        
        openM('Sửa Dòng xe: ' + cat.name);
    };

    /* DELETE MODAL */
    const modalDelete = document.getElementById('modal-delete');
    const deleteForm = document.getElementById('delete-form');
    const deleteCatName = document.getElementById('delete-cat-name');

    window.confirmDeleteModal = function(id, name) {
        deleteCatName.textContent = name;
        deleteForm.action = `/admin/categories/${id}`;
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

    window.showToast = function(msg, type=''){
        const stack = document.getElementById('toast-stack');
        const el = document.createElement('div');
        el.className = 'toast ' + type;
        el.innerHTML = `<i class="fa-solid fa-${type === 'success' ? 'circle-check' : type === 'error' ? 'circle-xmark' : 'circle-info'}"></i> ${msg}`;
        stack.appendChild(el);
        setTimeout(()=>{ el.classList.add('removing'); setTimeout(()=>el.remove(),220); }, 3000);
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
@endsection
