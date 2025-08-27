<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillPath')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            padding: 25px 20px;
            border-bottom: 1px solid #e5e7eb;
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
            <li class="{{ request()->is('input') ? 'active' : '' }}">
                <a href="{{ url('/input') }}">
                    <i class="fas fa-plus-circle"></i>
                    Input Data
                </a>
            </li>
            <li class="{{ request()->is('data-karyawan') ? 'active' : '' }}">
                <a href="{{ url('/data-karyawan') }}">
                    <i class="fas fa-users"></i>
                    Data Karyawan
                </a>
            </li>
            <li class="{{ request()->is('kompetensi') ? 'active' : '' }}">
                <a href="{{ url('/kompetensi') }}">
                    <i class="fas fa-chart-bar"></i>
                    Kompetensi
                </a>
            </li>
            <li class="{{ request()->is('pelatihan') ? 'active' : '' }}">
                <a href="{{ url('/pelatihan') }}">
                    <i class="fas fa-graduation-cap"></i>
                    Pelatihan
                </a>
            </li>
            <li class="{{ request()->is('pengaturan') ? 'active' : '' }}">
                <a href="{{ url('/pengaturan') }}">
                    <i class="fas fa-cog"></i>
                    Pengaturan
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

    <script>
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>

</html>
