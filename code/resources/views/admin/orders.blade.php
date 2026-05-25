@extends('admin.layouts.master')

@section('title', 'Đơn hàng — Order Management')

@section('styles')
<style>
    /* ====================================
       PAGE HEADER & STATS (Reused from cars)
    ==================================== */
    .page-super { font-size: 10.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px; }
    .page-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; flex-wrap: wrap; gap: 12px; }
    .page-title-row h1 { font-size: 26px; font-weight: 800; color: var(--text-primary); letter-spacing: -.6px; }

    .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; transition: all var(--transition); }
    .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 2px 8px rgba(26,86,219,.28); }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .btn-ghost { background: var(--surface); color: var(--text-secondary); border: 1.5px solid var(--border); }
    .btn-ghost:hover { background: var(--bg); color: var(--text-primary); }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; transition: box-shadow var(--transition), transform var(--transition); }
    .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .stat-label { font-size: 10.5px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
    .stat-value-row { display: flex; align-items: baseline; gap: 7px; }
    .stat-value { font-size: 26px; font-weight: 800; color: var(--text-primary); letter-spacing: -1px; line-height: 1; }
    .stat-tag { font-size: 12px; font-weight: 700; color: var(--success); }
    .stat-tag.hot { color: var(--danger); }
    .stat-tag.pct { color: var(--text-muted); font-weight: 600; }

    /* ====================================
       TABLE CARD
    ==================================== */
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); }
    .table-toolbar { padding: 14px 20px; border-bottom: 1px solid var(--border-light); display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .t-search { position: relative; flex: 1; max-width: 300px; min-width: 180px; }
    .t-search i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 12.5px; }
    .t-search input { width: 100%; padding: 8px 12px 8px 33px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 13px; outline: none; background: var(--bg); }
    .t-search input:focus { border-color: var(--primary); background: var(--surface); }
    .filter-select { padding: 8px 30px 8px 11px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: inherit; font-size: 12.5px; color: var(--text-secondary); background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 10 10'%3E%3Cpath fill='%2394a3b8' d='M5 7L0 2h10z'/%3E%3C/svg%3E") no-repeat right 9px center; appearance: none; cursor: pointer; outline: none; }
    .toolbar-spacer { flex: 1; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th { padding: 11px 16px; text-align: left; font-size: 10.5px; font-weight: 700; letter-spacing: .7px; text-transform: uppercase; color: var(--text-muted); background: var(--bg); border-bottom: 1px solid var(--border); white-space: nowrap; }
    .data-table tbody tr { border-bottom: 1px solid var(--border-light); transition: background var(--transition); }
    .data-table tbody tr:hover { background: #fafbff; }
    .data-table td { padding: 14px 16px; font-size: 13px; vertical-align: middle; white-space: nowrap; }

    /* Custom cells */
    .ord-code { font-family: monospace; font-weight: 700; color: var(--primary); font-size: 14px; }
    
    .c-info { display: flex; align-items: center; gap: 10px; }
    .c-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #1e3a8a); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; }
    .c-name { font-weight: 600; color: var(--text-primary); }
    .c-email { font-size: 11.5px; color: var(--text-muted); }

    .car-meta { font-weight: 600; color: var(--text-primary); }
    .car-date { font-size: 11.5px; color: var(--text-muted); }

    .price-val { font-weight: 700; font-size: 14px; }

    .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
    .pill-pending { background: #fef3c7; color: #d97706; }
    .pill-confirmed { background: #e0f2fe; color: #0284c7; }
    .pill-completed { background: #d1fae5; color: #059669; }
    .pill-cancelled { background: #fee2e2; color: #dc2626; }

    .type-sale { color: #8b5cf6; font-weight: 600; font-size: 12px; border: 1px solid #c4b5fd; padding: 2px 6px; border-radius: 4px; background: #f5f3ff; }
    .type-rent { color: #f59e0b; font-weight: 600; font-size: 12px; border: 1px solid #fcd34d; padding: 2px 6px; border-radius: 4px; background: #fffbeb; }

    .action-group { display: flex; align-items: center; gap: 4px; justify-content: flex-end; }
    .act-btn { width: 31px; height: 31px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 13.5px; color: var(--text-muted); cursor: pointer; border: none; background: none; }
    .act-btn:hover { background: var(--bg); color: var(--text-primary); }

    .table-foot { display: flex; align-items: center; justify-content: space-between; padding: 13px 20px; border-top: 1px solid var(--border-light); background: var(--bg); }
    .foot-info { font-size: 12px; color: var(--text-muted); }
    .pagination { display: flex; gap: 4px; }
    .page-btn { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); border: 1.5px solid var(--border); background: var(--surface); cursor: pointer; }
    .page-btn:hover, .page-btn.active { border-color: var(--primary); color: var(--primary); }
</style>
@endsection

@section('content')
<div class="page-super">ORDER MANAGEMENT</div>
<div class="page-title-row">
    <h1>Quản lý Đơn hàng</h1>
    <button class="btn btn-primary" id="btn-add-order">
        <i class="fa-solid fa-plus"></i> Tạo đơn mới
    </button>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Tổng đơn hàng</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($totalOrders) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Hoàn thành (Tháng)</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($completedMonth) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Đang chờ xử lý</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($pendingOrders) }}</span>
            @if($pendingOrders > 0) <span class="stat-tag hot">Cần chú ý</span> @endif
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng Doanh thu</div>
        <div class="stat-value-row">
            <span class="stat-value">${{ number_format($totalRevenue) }}</span>
        </div>
    </div>
</div>

<div class="table-card">
    <form method="GET" action="{{ route('orders.index') }}" class="table-toolbar" id="filter-form">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" id="order-search" placeholder="Tìm kiếm mã đơn, khách hàng...">
            <button type="submit" style="display:none;"></button>
        </div>
        <select class="filter-select" name="status" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
        </select>
        <select class="filter-select" name="type" onchange="this.form.submit()">
            <option value="">Loại hình</option>
            <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Mua đứt</option>
            <option value="rental" {{ request('type') == 'rental' ? 'selected' : '' }}>Thuê xe</option>
        </select>
        <div class="toolbar-spacer"></div>
    </form>

    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>MÃ ĐƠN</th>
                    <th>KHÁCH HÀNG</th>
                    <th>THÔNG TIN XE</th>
                    <th>LOẠI HÌNH</th>
                    <th>TỔNG TIỀN</th>
                    <th>TRẠNG THÁI</th>
                    <th style="text-align:right;">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span class="ord-code">{{ $order->order_code }}</span></td>
                    <td>
                        <div class="c-info">
                            @php
                                $fullName = trim(($order->user->first_name ?? '') . ' ' . ($order->user->last_name ?? ''));
                                $names = explode(' ', $fullName ?: 'User');
                                $initials = substr($names[0], 0, 1) . (isset($names[1]) ? substr($names[count($names)-1], 0, 1) : '');
                            @endphp
                            <div class="c-avatar">{{ strtoupper($initials) }}</div>
                            <div>
                                <div class="c-name">{{ $fullName ?: 'Khách ẩn danh' }}</div>
                                <div class="c-email">{{ $order->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="car-meta">{{ $order->car->name ?? 'Xe đã xóa' }}</div>
                        <div class="car-date">
                            @if($order->type == 'rental')
                                {{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d/m/Y') : '?' }} - 
                                {{ $order->end_date ? \Carbon\Carbon::parse($order->end_date)->format('d/m/Y') : '?' }}
                            @else
                                {{ $order->created_at->format('d/m/Y') }}
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($order->type == 'sale')
                            <span class="type-sale">Mua đứt</span>
                        @else
                            <span class="type-rent">Thuê xe</span>
                        @endif
                    </td>
                    <td class="price-val">$ {{ number_format($order->total_amount) }}</td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="status-pill pill-pending">CHỜ XỬ LÝ</span>
                        @elseif($order->status == 'confirmed')
                            <span class="status-pill pill-confirmed">ĐÃ XÁC NHẬN</span>
                        @elseif($order->status == 'completed')
                            <span class="status-pill pill-completed">HOÀN THÀNH</span>
                        @elseif($order->status == 'cancelled')
                            <span class="status-pill pill-cancelled">ĐÃ HỦY</span>
                        @else
                            <span class="status-pill" style="background:#f1f5f9;color:#475569">{{ strtoupper($order->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="act-btn" title="Chỉnh sửa" onclick="editOrder({{ $order }})"><i class="fa-solid fa-pen"></i></button>
                            <button class="act-btn danger" title="Xóa" onclick="confirmDeleteModal({{ $order->id }}, '{{ $order->order_code }}')"><i class="fa-solid fa-trash" style="color:var(--danger)"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-solid fa-file-invoice-dollar" style="font-size:36px;opacity:.3;"></i>
                        <p style="margin-top:10px;font-size:14px;font-weight:500;">Không có đơn hàng nào.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-foot" style="padding: 14px 20px; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
        <span class="foot-info" id="order-foot-info" style="font-size: 13px; color: var(--text-secondary);">
            Hiển thị {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} trong tổng {{ number_format($orders->total()) }} đơn hàng
        </span>
        @php $orders->appends(request()->query()) @endphp
        <nav class="pagination" aria-label="Phân trang đơn hàng" style="display: flex; gap: 4px;">
            @if ($orders->onFirstPage())
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $orders->previousPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                @if ($page >= $orders->currentPage() - 2 && $page <= $orders->currentPage() + 2)
                    <a href="{{ $url }}" class="act-btn" style="{{ $page == $orders->currentPage() ? 'background: var(--primary); color: white;' : '' }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="act-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="act-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </nav>
    </div>
</div>
@endsection

@section('scripts')
{{-- MODAL: Thêm / Sửa Order --}}
<div class="modal-overlay" id="order-modal" role="dialog" aria-modal="true" aria-labelledby="order-modal-title">
    <div class="modal" style="max-width: 600px;">
        <form id="order-form" action="{{ route('orders.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="modal-header">
                <h2 id="order-modal-title">Tạo đơn hàng mới</h2>
                <button type="button" class="modal-close" id="order-modal-close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="order-user">Khách hàng <span style="color:var(--danger)">*</span></label>
                        <select name="user_id" id="order-user" required>
                            <option value="">Chọn khách hàng...</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->first_name }} {{ $u->last_name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order-car">Xe <span style="color:var(--danger)">*</span></label>
                        <select name="car_id" id="order-car" required>
                            <option value="">Chọn xe...</option>
                            @foreach($cars as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="order-type">Loại hình <span style="color:var(--danger)">*</span></label>
                        <select name="type" id="order-type" required onchange="toggleDates(this.value)">
                            <option value="rental">Thuê xe (Rental)</option>
                            <option value="sale">Mua đứt (Sale)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order-status">Trạng thái</label>
                        <select name="status" id="order-status">
                            <option value="pending">Chờ xử lý</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                </div>
                <div class="form-row" id="date-row">
                    <div class="form-group">
                        <label for="order-start">Ngày bắt đầu</label>
                        <input type="date" name="start_date" id="order-start">
                    </div>
                    <div class="form-group">
                        <label for="order-end">Ngày kết thúc</label>
                        <input type="date" name="end_date" id="order-end">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="order-total">Tổng tiền (USD) <span style="color:var(--danger)">*</span></label>
                        <input type="number" name="total_amount" id="order-total" placeholder="0.00" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="order-deposit">Tiền cọc (USD)</label>
                        <input type="number" name="deposit_amount" id="order-deposit" placeholder="0.00" step="0.01">
                    </div>
                </div>
                <div class="form-group">
                    <label for="order-notes">Ghi chú</label>
                    <textarea name="notes" id="order-notes" rows="3" placeholder="Ghi chú thêm..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="order-modal-cancel">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" id="order-modal-save"><i class="fa-solid fa-floppy-disk"></i> Lưu đơn hàng</button>
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
                <p>Bạn có chắc chắn muốn xóa đơn hàng <strong id="delete-order-code"></strong> không? Hành động này không thể hoàn tác.</p>
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

<style>
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal { background: var(--bg); width: 100%; max-width: 500px; border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; animation: modalFadeIn 0.3s ease; }
    @keyframes modalFadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; border-bottom: 1px solid var(--border); background: var(--surface); }
    .modal-header h2 { font-size: 18px; font-weight: 700; color: var(--text-primary); }
    .modal-close { background: none; border: none; font-size: 18px; color: var(--text-muted); cursor: pointer; padding: 4px; border-radius: 4px; transition: background 0.2s; }
    .modal-close:hover { background: var(--border); }
    .modal-body { padding: 24px; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 18px 24px; border-top: 1px solid var(--border); background: var(--surface); }
    
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-group label { font-size: 13px; font-weight: 600; color: var(--text-secondary); }
    .form-group input, .form-group select, .form-group textarea { padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 14px; font-family: inherit; color: var(--text-primary); outline: none; background: var(--surface); transition: border-color 0.2s, box-shadow 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,219,0.1); }
    
    .toast-stack { position: fixed; bottom: 24px; right: 24px; display: flex; flex-direction: column; gap: 10px; z-index: 2000; }
    .toast { display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: var(--radius); background: var(--surface); box-shadow: var(--shadow-lg); color: var(--text-primary); font-size: 14px; font-weight: 500; animation: toastSlideIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    @keyframes toastSlideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    .toast.success i { color: var(--success); }
    .toast.error i { color: var(--danger); }
</style>

<script>
(function(){
    'use strict';

    /* Modal */
    const modal       = document.getElementById('order-modal');
    const modalTitle  = document.getElementById('order-modal-title');
    const form        = document.getElementById('order-form');
    const formMethod  = document.getElementById('form-method');

    const openModal   = (title) => { modalTitle.textContent = title; modal.classList.add('open'); };
    const closeModal  = () => modal.classList.remove('open');

    document.getElementById('btn-add-order').addEventListener('click', () => {
        form.reset();
        form.action = "{{ route('orders.store') }}";
        formMethod.value = "POST";
        document.getElementById('date-row').style.display = 'grid'; // default rental
        openModal('Tạo đơn hàng mới');
    });

    document.getElementById('order-modal-close').addEventListener('click', closeModal);
    document.getElementById('order-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    window.toggleDates = function(type) {
        if(type === 'sale') {
            document.getElementById('date-row').style.display = 'none';
        } else {
            document.getElementById('date-row').style.display = 'grid';
        }
    };

    /* Edit / Delete */
    window.editOrder = (order) => {
        form.action = `/admin/orders/${order.id}`;
        formMethod.value = "PUT";
        
        document.getElementById('order-user').value = order.user_id;
        document.getElementById('order-car').value = order.car_id;
        document.getElementById('order-type').value = order.type;
        document.getElementById('order-status').value = order.status;
        document.getElementById('order-start').value = order.start_date ? order.start_date.substring(0, 10) : '';
        document.getElementById('order-end').value = order.end_date ? order.end_date.substring(0, 10) : '';
        document.getElementById('order-total').value = order.total_amount;
        document.getElementById('order-deposit').value = order.deposit_amount || '';
        document.getElementById('order-notes').value = order.notes || '';
        
        toggleDates(order.type);
        openModal('Sửa đơn: ' + order.order_code);
    };

    /* DELETE MODAL */
    const modalDelete = document.getElementById('modal-delete');
    const deleteForm = document.getElementById('delete-form');
    const deleteOrderCode = document.getElementById('delete-order-code');

    window.confirmDeleteModal = function(id, code) {
        deleteOrderCode.textContent = code;
        deleteForm.action = `/admin/orders/${id}`;
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
        el.className = 'toast ' + type;
        el.innerHTML = `<i class="fa-solid fa-${type==='success'?'circle-check':type==='error'?'circle-xmark':'circle-info'}"></i> ${msg}`;
        stack.appendChild(el);
        setTimeout(()=>{ el.style.opacity = '0'; setTimeout(()=>el.remove(),300); }, 3000);
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
