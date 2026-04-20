<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kinetic Motors — Cổng đăng nhập quản trị viên">
    <title>@yield('title', 'Đăng nhập') — Kinetic Motors Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ============================
           RESET & BASE
        ============================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:       #1a56db;
            --primary-dark:  #1344b5;
            --primary-light: #eef3fd;
            --accent:        #0ea5e9;
            --success:       #10b981;
            --danger:        #ef4444;
            --warning:       #f59e0b;

            --bg:            #f0f4ff;
            --surface:       #ffffff;
            --border:        #e2e8f0;
            --border-focus:  #1a56db;

            --text-primary:  #0f172a;
            --text-secondary:#475569;
            --text-muted:    #94a3b8;

            --radius:        14px;
            --radius-sm:     9px;
            --shadow-card:   0 4px 24px rgba(26,86,219,.10), 0 1px 4px rgba(0,0,0,.06);
            --shadow-lg:     0 16px 48px rgba(26,86,219,.16);
            --transition:    .18s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        button { cursor: pointer; border: none; font-family: inherit; }

        /* ============================
           AUTH SHELL — 2 CỘT
        ============================ */
        .auth-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── LEFT PANEL (Brand / Intro) ── */
        .auth-left {
            width: 420px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #1344b5 0%, #1a56db 45%, #0ea5e9 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 44px 40px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .auth-left::before,
        .auth-left::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .auth-left::before {
            width: 320px; height: 320px;
            bottom: -80px; right: -100px;
        }
        .auth-left::after {
            width: 180px; height: 180px;
            top: 60px; right: -40px;
        }

        .left-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .left-brand-icon {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,.25);
        }

        .left-brand-icon i { color: #fff; font-size: 20px; }

        .left-brand-text strong {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .left-brand-text span {
            display: block;
            color: rgba(255,255,255,.65);
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        /* Center welcome copy */
        .left-body {
            position: relative;
            z-index: 1;
        }

        .left-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,.9);
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .left-tag i { font-size: 10px; }

        .left-title {
            font-size: 30px;
            font-weight: 800;
            color: #fff;
            line-height: 1.22;
            letter-spacing: -.7px;
            margin-bottom: 14px;
        }

        .left-desc {
            font-size: 14px;
            color: rgba(255,255,255,.72);
            line-height: 1.65;
            max-width: 300px;
        }

        /* Stats row */
        .left-stats {
            display: flex;
            gap: 24px;
            margin-top: 32px;
        }

        .left-stat {}

        .left-stat-val {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.5px;
        }

        .left-stat-label {
            font-size: 11px;
            color: rgba(255,255,255,.6);
            font-weight: 500;
            margin-top: 1px;
        }

        /* Bottom tagline */
        .left-bottom {
            position: relative;
            z-index: 1;
            font-size: 11.5px;
            color: rgba(255,255,255,.45);
            font-weight: 500;
        }

        /* ── RIGHT PANEL (Form) ── */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
        }

        .auth-card-header {
            margin-bottom: 28px;
        }

        .auth-card-header h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -.4px;
        }

        .auth-card-header p {
            color: var(--text-secondary);
            font-size: 13.5px;
            margin-top: 5px;
            line-height: 1.5;
        }

        /* ============================
           FORM ELEMENTS
        ============================ */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .form-group label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .1px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i.input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
            transition: color var(--transition);
        }

        .input-wrap input {
            width: 100%;
            padding: 10.5px 13px 10.5px 40px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13.5px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .input-wrap input::placeholder { color: var(--text-muted); }

        .input-wrap input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(26,86,219,.12);
        }

        .input-wrap input:focus + .input-icon,
        .input-wrap:focus-within i.input-icon {
            color: var(--primary);
        }

        /* Toggle password eye */
        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            padding: 4px;
            transition: color var(--transition);
        }
        .toggle-pass:hover { color: var(--text-secondary); }

        /* Row utility */
        .form-row-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }

        .checkbox-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            transition: opacity var(--transition);
        }
        .forgot-link:hover { opacity: .72; }

        /* Primary button */
        .btn-auth {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: background var(--transition), box-shadow var(--transition), transform var(--transition);
            box-shadow: 0 2px 8px rgba(26,86,219,.30);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-auth:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 18px rgba(26,86,219,.40);
            transform: translateY(-1px);
        }
        .btn-auth:active { transform: translateY(0); }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
        }
        .auth-divider hr {
            flex: 1;
            border: none;
            border-top: 1px solid var(--border);
        }
        .auth-divider span {
            font-size: 11.5px;
            color: var(--text-muted);
            font-weight: 500;
            white-space: nowrap;
        }

        /* Footer link */
        .auth-footer-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: var(--text-secondary);
        }
        .auth-footer-link a {
            color: var(--primary);
            font-weight: 600;
            transition: opacity var(--transition);
        }
        .auth-footer-link a:hover { opacity: .75; }

        /* Alert banner (errors/success) */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 18px;
            line-height: 1.45;
        }
        .alert i { font-size: 14px; flex-shrink: 0; margin-top: 1px; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 3px solid var(--danger); }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 3px solid var(--success); }
        .alert-info    { background: #dbeafe; color: #1e40af; border-left: 3px solid var(--primary); }

        /* Error text under field */
        .field-error {
            font-size: 11.5px;
            color: var(--danger);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Responsive */
        @media (max-width: 820px) {
            .auth-left { display: none; }
            .auth-right { padding: 32px 20px; }
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="auth-shell">

    {{-- ── LEFT BRAND PANEL ── --}}
    <div class="auth-left">
        {{-- Logo --}}
        <div class="left-brand">
            <div class="left-brand-icon">
                <i class="fa-solid fa-car-side"></i>
            </div>
            <div class="left-brand-text">
                <strong>Kinetic Motors</strong>
                <span>Premium Management</span>
            </div>
        </div>

        {{-- Welcome body --}}
        <div class="left-body">
            <div class="left-tag">
                <i class="fa-solid fa-shield-check"></i>
                Khu vực quản trị viên
            </div>

            <h2 class="left-title">
                Chào mừng trở lại<br>
                hệ thống điều hành!
            </h2>

            <p class="left-desc">
                Bảng quản trị Kinetic Motors — nơi bạn kiểm soát toàn bộ
                kho xe, đơn hàng, khách hàng và doanh thu chỉ trong
                một nền tảng thống nhất, bảo mật và mạnh mẽ.
            </p>

            <div class="left-stats">
                <div class="left-stat">
                    <div class="left-stat-val">1,284</div>
                    <div class="left-stat-label">Xe trong kho</div>
                </div>
                <div class="left-stat">
                    <div class="left-stat-val">8,420</div>
                    <div class="left-stat-label">Người dùng</div>
                </div>
                <div class="left-stat">
                    <div class="left-stat-val">$2.4M</div>
                    <div class="left-stat-label">Doanh thu</div>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="left-bottom">
            © {{ date('Y') }} Kinetic Motors. All rights reserved.
        </div>
    </div>

    {{-- ── RIGHT FORM PANEL ── --}}
    <div class="auth-right">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>

</div>

@yield('scripts')
</body>
</html>
