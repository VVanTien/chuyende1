@extends('admin.layouts.master')

@section('title', 'Dashboard — Tổng quan')

@section('styles')
<style>
    /* ====================================
       SHARED PAGE UTILITIES
    ==================================== */
    .page-header {
        margin-bottom: 24px;
    }
    .page-header h1 {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -.5px;
        line-height: 1.2;
    }
    .page-header p {
        color: var(--text-secondary);
        font-size: 13.5px;
        margin-top: 4px;
    }

    /* ====================================
       STAT CARDS
    ==================================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: box-shadow var(--transition), transform var(--transition);
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .stat-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }
    .stat-icon.blue   { background: #dbeafe; color: #1d4ed8; }
    .stat-icon.green  { background: #d1fae5; color: #059669; }
    .stat-icon.amber  { background: #fef3c7; color: #d97706; }
    .stat-icon.purple { background: #ede9fe; color: #7c3aed; }

    .stat-change {
        font-size: 11.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
    }
    .stat-change.up   { background: #d1fae5; color: #065f46; }
    .stat-change.down { background: #fee2e2; color: #991b1b; }

    .stat-card-bottom {}
    .stat-label {
        font-size: 10.5px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: .8px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -1.2px;
        line-height: 1;
    }

    /* ====================================
       MIDDLE ROW
    ==================================== */
    .middle-row {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 16px;
        margin-bottom: 22px;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px 22px;
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-title h2 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
    }
    .card-title p {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* Period selector */
    .period-select {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: inherit;
        font-size: 12.5px;
        color: var(--text-secondary);
        background: var(--bg);
        cursor: pointer;
        outline: none;
        transition: border-color var(--transition);
    }
    .period-select:focus { border-color: var(--primary); }

    /* Chart container */
    .chart-wrap {
        position: relative;
        height: 220px;
    }

    /* ====================================
       PLATFORM TRAFFIC
    ==================================== */
    .traffic-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .traffic-item {}
    .traffic-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .traffic-item-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: .6px;
        text-transform: uppercase;
    }
    .traffic-item-pct {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--text-secondary);
    }

    .progress-bar {
        height: 6px;
        background: var(--border);
        border-radius: 6px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 6px;
        transition: width .6s ease;
    }
    .fill-blue   { background: var(--primary); }
    .fill-green  { background: var(--success); }
    .fill-orange { background: #f97316; }
    .fill-gray   { background: #94a3b8; }

    /* ====================================
       POPULAR INVENTORY TABLE
    ==================================== */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .section-header h2 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }
    .section-header p {
        font-size: 12.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .link-btn {
        font-size: 13px;
        font-weight: 600;
        color: var(--primary);
        transition: opacity var(--transition);
    }
    .link-btn:hover { opacity: .72; }

    .inv-table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .inv-table {
        width: 100%;
        border-collapse: collapse;
    }
    .inv-table thead th {
        padding: 11px 18px;
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
    .inv-table tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background var(--transition);
    }
    .inv-table tbody tr:last-child { border-bottom: none; }
    .inv-table tbody tr:hover { background: #fafbff; }
    .inv-table td {
        padding: 14px 18px;
        font-size: 13.5px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .vehicle-cell { display: flex; align-items: center; gap: 12px; }
    .vehicle-thumb {
        width: 52px;
        height: 38px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 18px;
        flex-shrink: 0;
        overflow: hidden;
    }
    .vehicle-name { font-size: 13.5px; font-weight: 600; color: var(--text-primary); }
    .vehicle-vin  { font-size: 11.5px; color: var(--text-muted); margin-top: 1px; }

    .cat-cell { color: var(--text-secondary); font-size: 13px; }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .status-pill::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .pill-booked    { background: #dbeafe; color: #1d4ed8; }
    .pill-booked::before { background: #1d4ed8; }
    .pill-available { background: #f1f5f9; color: #475569; }
    .pill-available::before { background: #94a3b8; }

    .rate-cell    { font-weight: 600; color: var(--text-primary); }
    .revenue-cell { font-weight: 700; color: var(--primary); }

    @media (max-width: 960px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .middle-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <h1>Tổng quan hiệu suất</h1>
    <p>Số liệu thời gian thực cho Kinetic Motors Premium Marketplace.</p>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon blue"><i class="fa-solid fa-car"></i></div>
            <span class="stat-change up">+12%</span>
        </div>
        <div class="stat-card-bottom">
            <div class="stat-label">Tổng xe</div>
            <div class="stat-value">1,284</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon green"><i class="fa-solid fa-user-check"></i></div>
            <span class="stat-change up">+5.4%</span>
        </div>
        <div class="stat-card-bottom">
            <div class="stat-label">Người dùng hoạt động</div>
            <div class="stat-value">8,420</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon amber"><i class="fa-solid fa-calendar-check"></i></div>
            <span class="stat-change down">-2.1%</span>
        </div>
        <div class="stat-card-bottom">
            <div class="stat-label">Đặt xe hàng tháng</div>
            <div class="stat-value">412</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon purple"><i class="fa-solid fa-dollar-sign"></i></div>
            <span class="stat-change up">+18%</span>
        </div>
        <div class="stat-card-bottom">
            <div class="stat-label">Tổng doanh thu</div>
            <div class="stat-value">$2.4M</div>
        </div>
    </div>
</div>

{{-- MIDDLE ROW: Chart + Traffic --}}
<div class="middle-row">

    {{-- Booking Trends --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h2>Xu hướng đặt xe</h2>
                <p>Phân phối volume trong 30 ngày qua</p>
            </div>
            <select class="period-select" id="period-select" aria-label="Chọn khoảng thời gian">
                <option>30 Ngày qua</option>
                <option>7 Ngày qua</option>
                <option>90 Ngày qua</option>
            </select>
        </div>
        <div class="chart-wrap">
            <canvas id="bookingChart" aria-label="Biểu đồ xu hướng đặt xe"></canvas>
        </div>
    </div>

    {{-- Platform Traffic --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h2>Lưu lượng nền tảng</h2>
                <p>Nguồn tiếp cận</p>
            </div>
        </div>
        <div class="traffic-list">
            <div class="traffic-item">
                <div class="traffic-item-header">
                    <span class="traffic-item-label">TRỰC TIẾP</span>
                    <span class="traffic-item-pct">45%</span>
                </div>
                <div class="progress-bar"><div class="progress-fill fill-blue" style="width:45%"></div></div>
            </div>
            <div class="traffic-item">
                <div class="traffic-item-header">
                    <span class="traffic-item-label">GIỚI THIỆU</span>
                    <span class="traffic-item-pct">28%</span>
                </div>
                <div class="progress-bar"><div class="progress-fill fill-green" style="width:28%"></div></div>
            </div>
            <div class="traffic-item">
                <div class="traffic-item-header">
                    <span class="traffic-item-label">MẠNG XÃ HỘI</span>
                    <span class="traffic-item-pct">17%</span>
                </div>
                <div class="progress-bar"><div class="progress-fill fill-orange" style="width:17%"></div></div>
            </div>
            <div class="traffic-item">
                <div class="traffic-item-header">
                    <span class="traffic-item-label">TÌM KIẾM</span>
                    <span class="traffic-item-pct">10%</span>
                </div>
                <div class="progress-bar"><div class="progress-fill fill-gray" style="width:10%"></div></div>
            </div>
        </div>
    </div>

</div>

{{-- POPULAR INVENTORY --}}
<div class="section-header">
    <div>
        <h2>Kho xe nổi bật</h2>
        <p>Các xe hoạt động tốt nhất tuần này</p>
    </div>
    <a href="{{ url('/cars') }}" class="link-btn">Xem toàn bộ kho xe →</a>
</div>

<div class="inv-table-card">
    <table class="inv-table" aria-label="Bảng kho xe nổi bật">
        <thead>
            <tr>
                <th>XE</th>
                <th>DANH MỤC</th>
                <th>TRẠNG THÁI</th>
                <th>GIÁ THUÊ / NGÀY</th>
                <th>DOANH THU</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="vehicle-cell">
                        <div class="vehicle-thumb"><i class="fa-solid fa-car-side"></i></div>
                        <div>
                            <div class="vehicle-name">Lucid Air Grand Touring</div>
                            <div class="vehicle-vin">EV-721-AC</div>
                        </div>
                    </div>
                </td>
                <td class="cat-cell">Sedan / Luxury</td>
                <td><span class="status-pill pill-booked">ĐÃ ĐẶT</span></td>
                <td class="rate-cell">$350.00</td>
                <td class="revenue-cell">$12,450</td>
            </tr>
            <tr>
                <td>
                    <div class="vehicle-cell">
                        <div class="vehicle-thumb"><i class="fa-solid fa-car-side"></i></div>
                        <div>
                            <div class="vehicle-name">Porsche Taycan Turbo</div>
                            <div class="vehicle-vin">PZ-390-TS</div>
                        </div>
                    </div>
                </td>
                <td class="cat-cell">Performance / GT</td>
                <td><span class="status-pill pill-available">CÓ SẴN</span></td>
                <td class="rate-cell">$425.00</td>
                <td class="revenue-cell">$8,900</td>
            </tr>
            <tr>
                <td>
                    <div class="vehicle-cell">
                        <div class="vehicle-thumb"><i class="fa-solid fa-car-side"></i></div>
                        <div>
                            <div class="vehicle-name">BMW i7 M70</div>
                            <div class="vehicle-vin">BM-882-LL</div>
                        </div>
                    </div>
                </td>
                <td class="cat-cell">Exec / Luxury</td>
                <td><span class="status-pill pill-booked">ĐÃ ĐẶT</span></td>
                <td class="rate-cell">$380.00</td>
                <td class="revenue-cell">$15,200</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
    'use strict';

    /* ── Booking Trends Chart ── */
    const labels = ['01','03','05','07','09','11','13','15','17','19','21','23','25','27','29'];
    const barData = [28,42,35,55,38,62,48,75,52,44,58,70,45,66,80];
    const lineData = [30,35,33,45,40,52,50,58,54,50,56,62,55,60,72];

    const ctx = document.getElementById('bookingChart').getContext('2d');

    new Chart(ctx, {
        data: {
            labels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Đặt xe',
                    data: barData,
                    backgroundColor: 'rgba(26,86,219,.18)',
                    borderColor:     'rgba(26,86,219,.35)',
                    borderWidth: 1,
                    borderRadius: 5,
                    borderSkipped: 'bottom',
                    order: 2,
                },
                {
                    type: 'line',
                    label: 'Xu hướng',
                    data: lineData,
                    borderColor:     'rgba(100,130,200,.65)',
                    backgroundColor: 'transparent',
                    borderWidth: 2.5,
                    tension: 0.45,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    order: 1,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f8fafc',
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 10, family: 'Inter' } }
                },
                y: {
                    grid: { color: '#f0f2f8' },
                    ticks: { color: '#94a3b8', font: { size: 10, family: 'Inter' }, maxTicksLimit: 5 },
                    border: { display: false }
                }
            }
        }
    });

    /* ── Period Selector ── */
    document.getElementById('period-select').addEventListener('change', function () {
        // demo: re-shuffle data
        const newBar  = barData.map(() => Math.floor(Math.random()*60)+20);
        const newLine = newBar.map(v => v - Math.floor(Math.random()*10));
        ctx.chart && ctx.chart.destroy();
    });

})();
</script>
@endsection
