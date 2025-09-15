<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillPath')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Layout Styling untuk Dashboard */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .logo {
            text-align: center;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #1e40af;
        }

        .menu {
            list-style: none;
            padding: 20px 0;
        }

        .menu li {
            margin-bottom: 5px;
        }

        .menu li a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .menu li a:hover,
        .menu li.active a {
            background: #f3f4f6;
            color: #1e40af;
            border-left-color: #1e40af;
        }

        .menu li a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .logout-icon {
            display: flex;
            align-items: center;
            color: #6b7280;
            font-weight: 500;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .logout-icon:hover {
            color: #dc2626;
        }

        .logout-icon i {
            margin-right: 10px;
        }

        /* Main Content Styling */
        .main-content {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .page-header {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 0;
        }

        .page-header h1 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        /* Custom Styles untuk Halaman Data Sertifikasi dan Rekomendasi */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            border: none;
            padding: 20px 25px;
        }

        .card-header h4 {
            font-weight: 600;
            margin: 0;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: #2c3e50;
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px 12px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.875rem;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            border: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: 1px solid #e1e5e9;
            color: #3b82f6;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border-color: #3b82f6;
        }

        /* Summary Cards Styling */
        .card.bg-primary, .card.bg-success, .card.bg-warning, .card.bg-info {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card.bg-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
        }

        .card.bg-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%) !important;
        }

        .card.bg-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
        }

        .card.bg-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <span class="logo-text">SkillPath</span>
        </div>
        <ul class="menu">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="{{ request()->is('data-karyawan') ? 'active' : '' }}">
                <a href="{{ url('/data-karyawan') }}">
                    <i class="fas fa-users"></i>
                    Data Karyawan
                </a>
            </li>
            <li class="{{ request()->is('pelatihan') ? 'active' : '' }}">
                <a href="{{ url('/pelatihan') }}">
                    <i class="fas fa-graduation-cap"></i>
                    Pelatihan
                </a>
            </li>
            <li class="{{ request()->is('data-sertifikasi') ? 'active' : '' }}">
                <a href="{{ url('/data-sertifikasi') }}">
                    <i class="fas fa-certificate"></i>
                    Data Sertifikasi
                </a>
            </li>
            <li class="{{ request()->is('rekomendasi') ? 'active' : '' }}">
                <a href="{{ url('/rekomendasi') }}">
                    <i class="fas fa-lightbulb"></i>
                    Rekomendasi
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <span class="logout-icon">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </span>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>

</html>
