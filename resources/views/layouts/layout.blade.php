<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillPath')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <span class="logo-text">SkillPath</span>
        </div>
        <ul class="menu">
            <li><a href="dashboard">Dashboard</a></li>
            <li><a href="input">Input Data</a></li>
            <li class="active"><a href="#">Data Karyawan</a></li>
        </ul>
        <div class="sidebar-footer">
            <span class="logout-icon"></span>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="page-header">
            <h1>Manajemen Data Karyawan</h1>
        </header>
        @yield('content')
    </main>
</body>
</html>
