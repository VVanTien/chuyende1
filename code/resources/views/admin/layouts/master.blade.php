<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kinetic Motors - Hệ thống quản lý bán ô tô chuyên nghiệp">
    <title>@yield('title', 'Kinetic Motors') — Admin Panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ============================
           CSS RESET & BASE
        ============================ */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary:        #1a56db;
            --primary-dark:   #1344b5;
            --primary-light:  #eef3fd;
            --primary-mid:    #dbeafe;
            --accent:         #0ea5e9;
            --success:        #10b981;
            --danger:         #ef4444;
            --warning:        #f59e0b;
            --info:           #6366f1;

            --bg:             #f4f6fb;
            --surface:        #ffffff;
            --border:         #e5e9f2;
            --border-light:   #f0f2f8;

            --text-primary:   #0f172a;
            --text-secondary: #64748b;
            --text-muted:     #94a3b8;

            --sidebar-w:      210px;
            --header-h:       64px;
            --radius:         12px;
            --radius-sm:      8px;
            --shadow:         0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
            --shadow-lg:      0 8px 32px rgba(0,0,0,.10);
            --transition:     .18s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a           { text-decoration: none; color: inherit; }
        ul          { list-style: none; }
        button      { cursor: pointer; border: none; background: none; font-family: inherit; }
        img         { max-width: 100%; display: block; }

        /* ============================
           LAYOUT SHELL
        ============================ */
        .admin-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ============================
           SIDEBAR
        ============================ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: relative;
            z-index: 100;
        }

        /* Brand / Logo */
        .sidebar-brand {
            height: var(--header-h);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 18px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-brand-icon {
            width: 34px;
            height: 34px;
            background: var(--primary);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(26,86,219,.35);
        }

        .sidebar-brand-icon i {
            color: #fff;
            font-size: 15px;
        }

        .sidebar-brand-text strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -.2px;
            line-height: 1.2;
        }

        .sidebar-brand-text span {
            display: block;
            font-size: 9.5px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 14px 10px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar           { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb     { background: var(--border); border-radius: 4px; }
        .sidebar-nav::-webkit-scrollbar-track     { background: transparent; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: 9px;
            color: var(--text-secondary);
            font-size: 13.5px;
            font-weight: 500;
            transition:
                background var(--transition),
                color var(--transition),
                transform var(--transition);
            margin-bottom: 2px;
            position: relative;
            white-space: nowrap;
        }

        .nav-item i {
            width: 17px;
            text-align: center;
            font-size: 14.5px;
            flex-shrink: 0;
            transition: color var(--transition);
        }

        .nav-item span { flex: 1; }

        /* Hover state */
        .nav-item:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        /*
         * ACTIVE STATE — theo ảnh mẫu:
         * Nền xanh nhạt, text & icon xanh đậm, không có đường kẻ bên phải
         */
        .nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        .nav-item.active i {
            color: var(--primary);
        }

        /* Sidebar bottom */
        .sidebar-bottom {
            padding: 14px 10px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .add-listing-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: var(--primary);
            color: #fff;
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            transition:
                background var(--transition),
                transform var(--transition),
                box-shadow var(--transition);
            box-shadow: 0 2px 8px rgba(26,86,219,.32);
            margin-bottom: 2px;
        }

        .add-listing-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(26,86,219,.4);
        }

        .help-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: 9px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            transition: color var(--transition), background var(--transition);
        }

        .help-link:hover { background: var(--bg); color: var(--text-secondary); }

        /* ============================
           MAIN AREA
        ============================ */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        /* ============================
           TOPBAR / HEADER
        ============================ */
        .topbar {
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 26px;
            gap: 14px;
            flex-shrink: 0;
        }

        .topbar-search {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .topbar-search i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13.5px;
            pointer-events: none;
        }

        .topbar-search input {
            width: 100%;
            padding: 8.5px 14px 8.5px 38px;
            border: 1.5px solid var(--border);
            border-radius: 24px;
            background: var(--bg);
            font-family: inherit;
            font-size: 13px;
            color: var(--text-primary);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
        }

        .topbar-search input::placeholder { color: var(--text-muted); }

        .topbar-search input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,86,219,.11);
            background: var(--surface);
        }

        .topbar-spacer { flex: 1; }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .icon-btn {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 15.5px;
            transition: background var(--transition), color var(--transition);
            position: relative;
            cursor: pointer;
        }

        .icon-btn:hover { background: var(--bg); color: var(--text-primary); }

        .notif-badge {
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--surface);
        }

        .topbar-divider {
            width: 1px;
            height: 26px;
            background: var(--border);
            margin: 0 6px;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 4px 10px 4px 4px;
            border-radius: 40px;
            cursor: pointer;
            transition: background var(--transition);
        }

        .user-badge:hover { background: var(--bg); }

        .user-avatar-placeholder {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12.5px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info { line-height: 1.25; }

        .user-info strong {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .user-info span {
            display: block;
            font-size: 10.5px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ============================
           PAGE CONTENT
        ============================ */
        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 26px;
            min-width: 0;
        }

        .page-content::-webkit-scrollbar       { width: 5px; }
        .page-content::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* ============================
           FOOTER
        ============================ */
        .admin-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 13px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            color: var(--text-muted);
            flex-shrink: 0;
            letter-spacing: .3px;
        }

        .footer-links {
            display: flex;
            gap: 18px;
        }

        .footer-links a {
            color: var(--text-muted);
            font-weight: 500;
            transition: color var(--transition);
        }

        .footer-links a:hover { color: var(--text-secondary); }

        /* ============================
           GLOBAL UTILITIES (shared)
        ============================ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .badge-blue   { background: #dbeafe; color: #1d4ed8; }
        .badge-purple { background: #ede9fe; color: #6d28d9; }
        .badge-gray   { background: #f1f5f9; color: #475569; }
        .badge-green  { background: #d1fae5; color: #065f46; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-amber  { background: #fef3c7; color: #92400e; }
    </style>

    @yield('styles')
</head>
<body>

<div class="admin-shell">

    {{-- ① SIDEBAR (tách ra layouts/sidebar.blade.php) --}}
    @include('admin.layouts.sidebar')

    {{-- MAIN AREA --}}
    <div class="main-area">

        {{-- ② HEADER (tách ra layouts/header.blade.php) --}}
        @include('admin.layouts.header')

        {{-- PAGE CONTENT --}}
        <main class="page-content" id="main-content">
            @yield('content')
        </main>

        {{-- ③ FOOTER (tách ra layouts/footer.blade.php) --}}
        @include('admin.layouts.footer')

    </div>{{-- /.main-area --}}

</div>{{-- /.admin-shell --}}

@yield('scripts')
</body>
</html>
