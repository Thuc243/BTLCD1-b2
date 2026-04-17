<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Lý Sinh Viên')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --rose-50: #fff1f2;
            --rose-100: #ffe4e6;
            --rose-200: #fecdd3;
            --rose-400: #fb7185;
            --rose-500: #f43f5e;
            --rose-600: #e11d48;
            --amber-50: #fffbeb;
            --amber-100: #fef3c7;
            --amber-400: #fbbf24;
            --amber-500: #f59e0b;
            --amber-600: #d97706;
            --emerald-50: #ecfdf5;
            --emerald-100: #d1fae5;
            --emerald-400: #34d399;
            --emerald-500: #10b981;
            --emerald-600: #059669;
            --violet-50: #f5f3ff;
            --violet-100: #ede9fe;
            --violet-400: #a78bfa;
            --violet-500: #8b5cf6;
            --violet-600: #7c3aed;
            --sky-400: #38bdf8;
            --sky-500: #0ea5e9;

            --bg-body: #faf8f6;
            --bg-card: rgba(255, 255, 255, 0.72);
            --bg-card-solid: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #5a5a7a;
            --text-muted: #9a9ab0;
            --border: rgba(0, 0, 0, 0.06);
            --border-strong: rgba(0, 0, 0, 0.1);

            --gradient-brand: linear-gradient(135deg, #f43f5e, #f59e0b);
            --gradient-cool: linear-gradient(135deg, #8b5cf6, #0ea5e9);
            --gradient-nature: linear-gradient(135deg, #10b981, #38bdf8);
            --gradient-warm: linear-gradient(135deg, #f59e0b, #ef4444);

            --shadow-sm: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.06), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.04);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated mesh background */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle at 20% 20%, rgba(244,63,94,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139,92,246,0.06) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(245,158,11,0.07) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16,185,129,0.05) 0%, transparent 50%);
            animation: meshMove 20s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes meshMove {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-2%, -1%) rotate(1deg); }
            50% { transform: translate(1%, -2%) rotate(-1deg); }
            75% { transform: translate(-1%, 1%) rotate(0.5deg); }
        }

        /* ===== TOP NAVBAR ===== */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .topbar-logo {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--gradient-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            box-shadow: 0 4px 12px rgba(244,63,94,0.3);
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 700;
            background: var(--gradient-brand);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .topbar-subtitle {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .topbar-nav::-webkit-scrollbar { display: none; }

        .topbar-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            position: relative;
        }

        .topbar-link:hover {
            color: var(--rose-600);
            background: var(--rose-50);
        }

        .topbar-link.active {
            color: white;
            background: var(--gradient-brand);
            box-shadow: 0 4px 12px rgba(244,63,94,0.25);
        }

        .topbar-link i {
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 32px 32px 48px;
        }

        /* ===== PAGE HEADER ===== */
        .page-header { margin-bottom: 32px; }

        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .page-header h1 i {
            background: var(--gradient-brand);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-right: 8px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 400;
        }

        /* ===== BREADCRUMB ===== */
        .breadcrumb {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--rose-500);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .breadcrumb a:hover { color: var(--rose-600); }

        /* ===== CARDS – Glassmorphism ===== */
        .card {
            background: var(--bg-card);
            backdrop-filter: blur(16px) saturate(160%);
            -webkit-backdrop-filter: blur(16px) saturate(160%);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-md);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-primary);
        }

        .card-title i { color: var(--rose-500); font-size: 18px; }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card-solid);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1), box-shadow 0.35s ease;
            box-shadow: var(--shadow-sm);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 0 0 20px 20px;
        }

        .stat-card:nth-child(1)::after { background: var(--gradient-brand); }
        .stat-card:nth-child(2)::after { background: var(--gradient-cool); }
        .stat-card:nth-child(3)::after { background: var(--gradient-nature); }
        .stat-card:nth-child(4)::after { background: var(--gradient-warm); }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }

        .stat-card:nth-child(1) .stat-icon { background: var(--rose-100); color: var(--rose-500); }
        .stat-card:nth-child(2) .stat-icon { background: var(--violet-100); color: var(--violet-500); }
        .stat-card:nth-child(3) .stat-icon { background: var(--emerald-100); color: var(--emerald-500); }
        .stat-card:nth-child(4) .stat-icon { background: var(--amber-100); color: var(--amber-500); }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 6px;
            font-weight: 500;
        }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            background: linear-gradient(135deg, #fef2f2, #fef3c7);
            padding: 14px 18px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 2px solid var(--border-strong);
        }

        tbody td {
            padding: 14px 18px;
            font-size: 14px;
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }

        tbody tr {
            transition: background 0.25s ease;
        }

        tbody tr:hover {
            background: rgba(244, 63, 94, 0.03);
        }

        tbody tr:last-child td { border-bottom: none; }

        /* ===== BADGES ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            gap: 5px;
            letter-spacing: 0.2px;
        }

        .badge-success { background: var(--emerald-100); color: var(--emerald-600); }
        .badge-danger { background: var(--rose-100); color: var(--rose-600); }
        .badge-primary { background: var(--violet-100); color: var(--violet-600); }
        .badge-warning { background: var(--amber-100); color: var(--amber-600); }
        .badge-accent { background: linear-gradient(135deg, #e0f2fe, #ede9fe); color: var(--violet-600); }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            font-family: 'Outfit', sans-serif;
        }

        .btn-primary {
            background: var(--gradient-brand);
            color: white;
            box-shadow: 0 4px 12px rgba(244,63,94,0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244,63,94,0.35);
        }

        .btn-outline {
            background: transparent;
            color: var(--rose-500);
            border: 1.5px solid var(--rose-200);
        }

        .btn-outline:hover {
            background: var(--rose-50);
            border-color: var(--rose-400);
        }

        .btn-sm { padding: 7px 16px; font-size: 12.5px; border-radius: 10px; }

        .btn-success {
            background: var(--gradient-nature);
            color: white;
            box-shadow: 0 4px 12px rgba(16,185,129,0.25);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16,185,129,0.35);
        }

        /* ===== FORMS ===== */
        .form-group { margin-bottom: 22px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .form-select, .form-input {
            width: 100%;
            padding: 12px 18px;
            background: var(--bg-card-solid);
            border: 1.5px solid var(--border-strong);
            border-radius: 14px;
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Outfit', sans-serif;
            transition: all 0.25s ease;
        }

        .form-select:focus, .form-input:focus {
            outline: none;
            border-color: var(--rose-400);
            box-shadow: 0 0 0 4px rgba(244,63,94,0.1);
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 16px 22px;
            border-radius: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(56,189,248,0.05));
            border: 1px solid rgba(16,185,129,0.2);
            color: var(--emerald-600);
        }

        /* ===== CODE BLOCKS ===== */
        .code-block {
            background: #1e1e2e;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 22px;
            margin: 18px 0;
            overflow-x: auto;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.2);
        }

        .code-block pre {
            font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;
            font-size: 13px;
            line-height: 1.7;
            color: #cdd6f4;
        }

        .code-block .keyword { color: #f38ba8; }
        .code-block .string { color: #a6e3a1; }
        .code-block .method { color: #89b4fa; }
        .code-block .comment { color: #6c7086; font-style: italic; }

        /* ===== TABS ===== */
        .tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 24px;
            padding: 5px;
            background: rgba(0,0,0,0.03);
            border-radius: 14px;
            width: fit-content;
        }

        .tab {
            padding: 10px 22px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            border: none;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            background: none;
            font-family: 'Outfit', sans-serif;
        }

        .tab:hover {
            color: var(--text-secondary);
            background: rgba(255,255,255,0.5);
        }

        .tab.active {
            color: white;
            background: var(--gradient-brand);
            box-shadow: 0 4px 12px rgba(244,63,94,0.2);
        }

        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* ===== AVATAR ===== */
        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            color: white;
            flex-shrink: 0;
        }

        .avatar-rose { background: var(--gradient-brand); }
        .avatar-cool { background: var(--gradient-cool); }
        .avatar-nature { background: var(--gradient-nature); }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-in {
            animation: fadeInUp 0.5s cubic-bezier(0.4,0,0.2,1) forwards;
        }

        .animate-in:nth-child(1) { animation-delay: 0s; }
        .animate-in:nth-child(2) { animation-delay: 0.08s; }
        .animate-in:nth-child(3) { animation-delay: 0.16s; }
        .animate-in:nth-child(4) { animation-delay: 0.24s; }

        /* ===== MOBILE MENU ===== */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--text-primary);
            cursor: pointer;
            padding: 8px;
            border-radius: 10px;
            transition: background 0.2s;
        }

        .mobile-toggle:hover { background: var(--rose-50); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .topbar { padding: 0 16px; }
            .topbar-nav { display: none; }
            .topbar-nav.open { 
                display: flex; 
                flex-direction: column;
                position: absolute;
                top: 68px;
                left: 0;
                right: 0;
                background: rgba(255,255,255,0.96);
                backdrop-filter: blur(20px);
                padding: 12px 16px;
                border-bottom: 1px solid var(--border);
                box-shadow: var(--shadow-lg);
                gap: 4px;
            }
            .mobile-toggle { display: block; }
            .main-content { padding: 20px 16px 40px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 24px; }
            .topbar-title { font-size: 17px; }
            .topbar-subtitle { display: none; }
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <nav class="topbar">
        <a href="{{ route('students.index') }}" class="topbar-brand">
            <div class="topbar-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div class="topbar-title">QLSV System</div>
                <div class="topbar-subtitle">Quản Lý Sinh Viên</div>
            </div>
        </a>

        <button class="mobile-toggle" onclick="document.querySelector('.topbar-nav').classList.toggle('open')">
            <i class="fas fa-bars"></i>
        </button>

        <div class="topbar-nav">
            <a href="{{ route('students.index') }}" class="topbar-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('students.byClassName') }}" class="topbar-link {{ request()->routeIs('students.byClassName') ? 'active' : '' }}">
                <i class="fas fa-search"></i> SV theo lớp
            </a>
            <a href="{{ route('students.subjects', 5) }}" class="topbar-link {{ request()->routeIs('students.subjects') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Môn học SV
            </a>
            <a href="{{ route('students.countByClass') }}" class="topbar-link {{ request()->routeIs('students.countByClass') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Đếm SV
            </a>
            <a href="{{ route('students.withSubjectCount') }}" class="topbar-link {{ request()->routeIs('students.withSubjectCount') ? 'active' : '' }}">
                <i class="fas fa-list-ol"></i> SV + Môn ĐK
            </a>
            <a href="{{ route('students.index') }}?tab=active" class="topbar-link">
                <i class="fas fa-user-check"></i> SV Active
            </a>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success animate-in">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>