@extends('admin.layouts.master')

@section('title', 'Lịch sử Thanh toán — Transaction Logs')

@section('styles')
<style>
    /* ====================================
       PAGE HEADER & STATS (Reused)
    ==================================== */
    .page-super { font-size: 10.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px; }
    .page-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; flex-wrap: wrap; gap: 12px; }
    .page-title-row h1 { font-size: 26px; font-weight: 800; color: var(--text-primary); letter-spacing: -.6px; }

    .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; transition: all var(--transition); }
    .btn-ghost { background: var(--surface); color: var(--text-secondary); border: 1.5px solid var(--border); }
    .btn-ghost:hover { background: var(--bg); color: var(--text-primary); }
    .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 2px 8px rgba(26,86,219,.28); }
    .btn-primary:hover { background: var(--primary-dark); box-shadow: 0 4px 14px rgba(26,86,219,.38); transform: translateY(-1px); }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; transition: box-shadow var(--transition), transform var(--transition); }
    .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .stat-label { font-size: 10.5px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
    .stat-value-row { display: flex; align-items: baseline; gap: 7px; }
    .stat-value { font-size: 26px; font-weight: 800; color: var(--text-primary); letter-spacing: -1px; line-height: 1; }
    .stat-tag { font-size: 12px; font-weight: 700; color: var(--success); }
    .stat-tag.hot { color: var(--danger); }

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
    .txn-code { font-family: monospace; font-size: 13px; color: var(--text-muted); }
    .ord-link { font-family: monospace; font-weight: 700; color: var(--primary); font-size: 13.5px; text-decoration: none; }
    .ord-link:hover { text-decoration: underline; }

    .method-badge { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; color: var(--text-secondary); }
    .method-badge i { font-size: 16px; }

    .amt-plus { color: #059669; font-weight: 700; font-family: monospace; font-size: 15px; }
    .amt-minus { color: #dc2626; font-weight: 700; font-family: monospace; font-size: 15px; }

    .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
    .pill-success { background: #d1fae5; color: #059669; }
    .pill-pending { background: #fef3c7; color: #d97706; }
    .pill-refunded { background: #f3e8ff; color: #7e22ce; }

    .table-foot { display: flex; align-items: center; justify-content: space-between; padding: 13px 20px; border-top: 1px solid var(--border-light); background: var(--bg); }
    .foot-info { font-size: 12px; color: var(--text-muted); }
    .pagination { display: flex; gap: 4px; }
    .page-btn { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); border: 1.5px solid var(--border); background: var(--surface); cursor: pointer; }
    .page-btn:hover, .page-btn.active { border-color: var(--primary); color: var(--primary); }
</style>
@endsection

@section('content')
<div class="page-super">TRANSACTION LOGS</div>
<div class="page-title-row">
    <h1>Lịch sử Thanh toán</h1>
    <button class="btn btn-primary" id="btn-add-payment">
        <i class="fa-solid fa-plus"></i> Ghi nhận thanh toán
    </button>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Tổng Giao dịch</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($totalTransactions) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Giao dịch thành công</div>
        <div class="stat-value-row">
            <span class="stat-value">{{ number_format($successfulCount) }}</span>
            <span class="stat-tag">Tốt</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng Doanh thu</div>
        <div class="stat-value-row">
            <span class="stat-value">${{ number_format($totalRevenue) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Đang chờ xử lý</div>
        <div class="stat-value-row">
            <span class="stat-value">${{ number_format($pendingAmount) }}</span>
            <span class="stat-tag pct">Đang xử lý</span>
        </div>
    </div>
</div>

<div class="table-card">
    <form method="GET" action="{{ route('payments.index') }}" class="table-toolbar" id="filter-form">
        <div class="t-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã giao dịch, đơn hàng...">
            <button type="submit" style="display:none;"></button>
        </div>
        <select class="filter-select" name="status" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Thành công</option>
            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
        </select>
        <select class="filter-select" name="method" onchange="this.form.submit()">
            <option value="">Phương thức</option>
            <option value="credit_card" {{ request('method') == 'credit_card' ? 'selected' : '' }}>Thẻ tín dụng</option>
            <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
            <option value="paypal" {{ request('method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
            <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
        </select>
        <div class="toolbar-spacer"></div>
    </form>

    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>MÃ GIAO DỊCH</th>
                    <th>MÃ ĐƠN HÀNG</th>
                    <th>PHƯƠNG THỨC</th>
                    <th>SỐ TIỀN</th>
                    <th style="text-align:center;">THỜI GIAN</th>
                    <th style="text-align:center;">TRẠNG THÁI</th>
                    <th style="text-align:right;">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $p)
                <tr>
                    <td><span class="txn-code">{{ $p->transaction_id ?? 'N/A' }}</span></td>
                    <td>
                        <a href="{{ route('orders.index', ['search' => $p->order->order_code ?? '']) }}" class="ord-link">
                            {{ $p->order->order_code ?? 'N/A' }}
                        </a>
                        <br>
                        <small style="color:var(--text-muted)">{{ $p->order->user->first_name ?? '' }} {{ $p->order->user->last_name ?? '' }}</small>
                    </td>
                    <td>
                        <span class="method-badge">
                            @if($p->payment_method == 'credit_card') <i class="fa-brands fa-cc-visa" style="color: #1a1f71;"></i> Thẻ tín dụng
                            @elseif($p->payment_method == 'bank_transfer') <i class="fa-solid fa-building-columns" style="color: #3b82f6;"></i> Chuyển khoản
                            @elseif($p->payment_method == 'paypal') <i class="fa-brands fa-cc-paypal" style="color: #00457c;"></i> PayPal
                            @else <i class="fa-solid fa-money-bill" style="color: #059669;"></i> Tiền mặt @endif
                        </span>
                    </td>
                    <td class="{{ $p->status == 'refunded' ? 'amt-minus' : 'amt-plus' }}">
                        {{ $p->status == 'refunded' ? '-' : '+' }} $ {{ number_format($p->amount) }}
                    </td>
                    <td style="text-align:center; color: var(--text-muted);">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td style="text-align:center;">
                        @if($p->status == 'completed') <span class="status-pill pill-success">THÀNH CÔNG</span>
                        @elseif($p->status == 'pending') <span class="status-pill pill-pending">ĐANG XỬ LÝ</span>
                        @elseif($p->status == 'refunded') <span class="status-pill pill-refunded">HOÀN TIỀN</span>
                        @else <span class="status-pill" style="background:#fee2e2;color:#dc2626">THẤT BẠI</span> @endif
                    </td>
                    <td style="text-align:right;">
                        <button class="act-btn" title="Sửa" onclick="editPayment({{ $p }})" style="display:inline-flex; width:28px;height:28px;border:none;background:none;color:var(--text-muted);cursor:pointer;border-radius:6px;align-items:center;justify-content:center"><i class="fa-solid fa-pen"></i></button>
                        <button class="act-btn danger" title="Xóa" onclick="confirmDeleteModal({{ $p->id }}, '{{ $p->transaction_id }}')" style="display:inline-flex; width:28px;height:28px;border:none;background:none;color:var(--danger);cursor:pointer;border-radius:6px;align-items:center;justify-content:center"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-solid fa-money-bill-transfer" style="font-size:36px;opacity:.3;"></i>
                        <p style="margin-top:10px;font-size:14px;font-weight:500;">Không có giao dịch nào.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-foot" style="padding: 14px 20px; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
        <span class="foot-info" id="payment-foot-info" style="font-size: 13px; color: var(--text-secondary);">
            Hiển thị {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }} trong tổng {{ number_format($payments->total()) }} giao dịch
        </span>
        @php $payments->appends(request()->query()) @endphp
        <nav class="pagination" aria-label="Phân trang" style="display: flex; gap: 4px;">
            @if ($payments->onFirstPage())
                <span class="page-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $payments->previousPageUrl() }}" class="page-btn" style="text-decoration:none;"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                @if ($page >= $payments->currentPage() - 2 && $page <= $payments->currentPage() + 2)
                    <a href="{{ $url }}" class="page-btn" style="text-decoration:none; {{ $page == $payments->currentPage() ? 'background: var(--primary); color: white;' : '' }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($payments->hasMorePages())
                <a href="{{ $payments->nextPageUrl() }}" class="page-btn" style="text-decoration:none;"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn disabled" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </nav>
    </div>
</div>

{{-- MODAL THÊM/SỬA --}}
<div class="modal-overlay" id="payment-modal" role="dialog" aria-modal="true">
    <div class="modal" style="max-width: 500px;">
        <form id="payment-form" action="{{ route('payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="modal-header">
                <h2 id="payment-modal-title">Ghi nhận thanh toán</h2>
                <button type="button" class="modal-close" id="payment-modal-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="display:flex; flex-direction:column; gap:5px; margin-bottom:14px;">
                    <label style="font-size:12px; font-weight:600; color:var(--text-secondary);">Mã Đơn hàng <span style="color:var(--danger)">*</span></label>
                    <select name="order_id" id="payment-order" required style="padding:8px 11px; border:1.5px solid var(--border); border-radius:4px;">
                        <option value="">Chọn đơn hàng...</option>
                        @foreach($orders as $o)
                            <option value="{{ $o->id }}" data-total="{{ $o->total_amount }}">{{ $o->order_code }} ({{ $o->user->first_name }} {{ $o->user->last_name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div class="form-group" style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:600; color:var(--text-secondary);">Phương thức <span style="color:var(--danger)">*</span></label>
                        <select name="payment_method" id="payment-method" required style="padding:8px 11px; border:1.5px solid var(--border); border-radius:4px;">
                            <option value="credit_card">Thẻ tín dụng</option>
                            <option value="bank_transfer">Chuyển khoản</option>
                            <option value="paypal">PayPal</option>
                            <option value="cash">Tiền mặt</option>
                        </select>
                    </div>
                    <div class="form-group" style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:600; color:var(--text-secondary);">Trạng thái</label>
                        <select name="status" id="payment-status" style="padding:8px 11px; border:1.5px solid var(--border); border-radius:4px;">
                            <option value="completed">Thành công</option>
                            <option value="pending">Đang xử lý</option>
                            <option value="refunded">Hoàn tiền</option>
                            <option value="failed">Thất bại</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display:flex; flex-direction:column; gap:5px; margin-bottom:14px;">
                    <label style="font-size:12px; font-weight:600; color:var(--text-secondary);">Số tiền (USD) <span style="color:var(--danger)">*</span></label>
                    <input type="number" name="amount" id="payment-amount" placeholder="0.00" step="0.01" required style="padding:8px 11px; border:1.5px solid var(--border); border-radius:4px;">
                </div>
            </div>
            <div class="modal-footer" style="display:flex; justify-content:flex-end; gap:10px; padding:15px 20px; border-top:1px solid var(--border); background:var(--surface);">
                <button type="button" class="btn btn-ghost" id="payment-modal-cancel">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL XÓA --}}
<div class="modal-overlay" id="modal-delete" role="dialog" aria-modal="true">
    <div class="modal" style="max-width: 400px;">
        <form id="delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header" style="display:flex; justify-content:space-between; padding:15px 20px; border-bottom:1px solid var(--border);">
                <h2>Xác nhận xóa</h2>
                <button type="button" class="modal-close" onclick="closeDeleteModal()" style="background:none; border:none; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <p>Bạn có chắc chắn muốn xóa giao dịch <strong id="delete-txn-code"></strong> không? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer" style="display:flex; justify-content:flex-end; gap:10px; padding:15px 20px; border-top:1px solid var(--border); background:var(--surface);">
                <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" style="background: var(--danger);"><i class="fa-solid fa-trash"></i> Xóa</button>
            </div>
        </form>
    </div>
</div>

<div class="toast-stack" id="toast-stack" aria-live="polite"></div>

<style>
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal { background: var(--surface); width: 100%; border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; animation: modalFadeIn 0.3s ease; }
    .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--bg); }
    .modal-header h2 { font-size: 16px; font-weight: 700; color: var(--text-primary); }
    .modal-close { background: none; border: none; font-size: 16px; color: var(--text-muted); cursor: pointer; padding: 4px 6px; border-radius: 4px; }
    .modal-close:hover { background: var(--border); color: var(--text-primary); }
    .modal-body { padding: 20px; }
    @keyframes modalFadeIn { from { opacity: 0; transform: translateY(-16px); } to { opacity: 1; transform: translateY(0); } }
    .toast-stack { position: fixed; bottom: 24px; right: 24px; display: flex; flex-direction: column; gap: 10px; z-index: 2000; }
    .toast { display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: var(--radius); background: var(--surface); box-shadow: var(--shadow-lg); color: var(--text-primary); font-size: 14px; font-weight: 500; animation: toastSlideIn 0.3s ease; }
    @keyframes toastSlideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    .toast.success i { color: var(--success); }
    .toast.error i { color: var(--danger); }
</style>
@endsection

@section('scripts')
<script>
(function(){
    'use strict';

    /* Modal Add/Edit */
    const modal       = document.getElementById('payment-modal');
    const modalTitle  = document.getElementById('payment-modal-title');
    const form        = document.getElementById('payment-form');
    const formMethod  = document.getElementById('form-method');

    const openModal   = (title) => { modalTitle.textContent = title; modal.classList.add('open'); };
    const closeModal  = () => modal.classList.remove('open');

    document.getElementById('btn-add-payment').addEventListener('click', () => {
        form.reset();
        form.action = "{{ route('payments.store') }}";
        formMethod.value = "POST";
        openModal('Ghi nhận thanh toán');
    });

    document.getElementById('payment-modal-close').addEventListener('click', closeModal);
    document.getElementById('payment-modal-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

    // Auto-fill amount based on selected order
    document.getElementById('payment-order').addEventListener('change', function() {
        if(formMethod.value === "POST") {
            const opt = this.options[this.selectedIndex];
            if(opt && opt.dataset.total) {
                document.getElementById('payment-amount').value = opt.dataset.total;
            }
        }
    });

    window.editPayment = (payment) => {
        form.action = `/admin/payments/${payment.id}`;
        formMethod.value = "PUT";
        
        document.getElementById('payment-order').value = payment.order_id;
        document.getElementById('payment-method').value = payment.payment_method;
        document.getElementById('payment-status').value = payment.status;
        document.getElementById('payment-amount').value = payment.amount;
        
        openModal('Sửa thanh toán: ' + (payment.transaction_id || 'N/A'));
    };

    /* Modal Delete */
    const modalDelete = document.getElementById('modal-delete');
    const deleteForm = document.getElementById('delete-form');
    const deleteTxnCode = document.getElementById('delete-txn-code');

    window.confirmDeleteModal = function(id, txn) {
        deleteTxnCode.textContent = txn;
        deleteForm.action = `/admin/payments/${id}`;
        modalDelete.classList.add('open');
    }
    window.closeDeleteModal = () => modalDelete.classList.remove('open');
    modalDelete.addEventListener('click', e => { if (e.target === modalDelete) closeDeleteModal(); });

    /* Search Debounce */
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

    /* Toasts */
    window.showToast = function(msg, type=''){
        const stack = document.getElementById('toast-stack');
        const el    = document.createElement('div');
        el.className = 'toast ' + type;
        el.innerHTML = `<i class="fa-solid fa-${type==='success'?'circle-check':type==='error'?'circle-xmark':'circle-info'}"></i> ${msg}`;
        stack.appendChild(el);
        setTimeout(()=>{ el.style.opacity = '0'; setTimeout(()=>el.remove(),300); }, 3000);
    }

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
