@extends('layouts/layout')

@section('title', 'Dashboard')

@section('content')
    <style>
        /* Dashboard Styling - Clean & Minimalist */
        .dashboard-container {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            background: white;
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-title-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dashboard-icon {
            width: 40px;
            height: 40px;
            background: #1e40af;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .dashboard-title {
            color: #1f2937;
            font-weight: 700;
            margin: 0;
            font-size: 28px;
        }

        .dashboard-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin: 5px 0 0 0;
            font-weight: 400;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            background: #ffffff;
            border-radius: 8px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            margin: 0;
        }

        .user-role {
            color: #6b7280;
            font-size: 12px;
            margin: 0;
        }

        /* Statistik Cards Styling - Horizontal Layout */
        .stats-container {
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-icon-container {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .stat-icon-container.blue {
            background: #1e40af;
        }

        .stat-icon-container.green {
            background: #059669;
        }

        .stat-icon-container.orange {
            background: #ea580c;
        }

        .stat-icon-container.red {
            background: #dc2626;
        }

        .stat-icon {
            color: white;
            font-size: 24px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 8px 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
            margin: 0;
        }

        /* Activity Section */
        .activity-section {
            background: white;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .activity-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .activity-icon {
            width: 24px;
            height: 24px;
            color: #1f2937;
            font-size: 18px;
        }

        .activity-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        /* Chart Card Styling */
        .chart-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            height: 100%;
        }

        .chart-header {
            background: #f8f9fa;
            color: #1f2937;
            padding: 20px;
            border: none;
            border-bottom: 1px solid #e5e7eb;
        }

        .chart-title {
            font-weight: 600;
            margin: 0;
            font-size: 16px;
            color: #1f2937;
        }

        .chart-body {
            padding: 20px;
        }

        /* Employee List Styling */
        .employee-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            height: 100%;
        }

        .employee-header {
            background: #f8f9fa;
            color: #1f2937;
            padding: 20px;
            border: none;
            border-bottom: 1px solid #e5e7eb;
        }

        .employee-title {
            font-weight: 600;
            margin: 0;
            font-size: 16px;
            color: #1f2937;
        }

        .employee-body {
            padding: 0;
        }

        .employee-item {
            padding: 15px 20px;
            border: none;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .employee-item:hover {
            background: #f9fafb;
        }

        .employee-item:last-child {
            border-bottom: none;
        }

        .employee-name {
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            font-size: 14px;
        }

        .employee-position {
            color: #6b7280;
            font-size: 12px;
            margin: 0;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-new {
            background: #3b82f6;
            color: white;
        }

        .status-active {
            background: #059669;
            color: white;
        }

        .status-evaluation {
            background: #ea580c;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px 15px;
            }

            .dashboard-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .dashboard-title {
                font-size: 24px;
            }

            .stat-number {
                font-size: 28px;
            }

            .user-info {
                align-self: flex-end;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* 4 kolom sejajar */
            gap: 20px;
            /* jarak antar kotak */
        }
    </style>

    <div class="dashboard-container">
        <!-- Header Dashboard -->
        <div class="dashboard-header">
            <div class="dashboard-title-section">
                <div class="dashboard-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <div>
                    <h1 class="dashboard-title">Dashboard</h1>
                    <p class="dashboard-subtitle">Selamat datang di sistem rekomendasi kepelatihan karyawan</p>
                </div>
            </div>

            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <p class="user-name">Admin SDM</p>
                    <p class="user-role">Administrator</p>
                </div>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon-container blue">
                    <i class="fas fa-users stat-icon"></i>
                </div>
                <div class="stat-number">156</div>
                <div class="stat-label">Total Karyawan</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-container green">
                    <i class="fas fa-star stat-icon"></i>
                </div>
                <div class="stat-number">24</div>
                <div class="stat-label">Kompetensi Aktif</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-container orange">
                    <i class="fas fa-graduation-cap stat-icon"></i>
                </div>
                <div class="stat-number">89</div>
                <div class="stat-label">Pelatihan Selesai</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-container red">
                    <i class="fas fa-chart-line stat-icon"></i>
                </div>
                <div class="stat-number">92%</div>
                <div class="stat-label">Kinerja Rata-rata</div>
            </div>
        </div>


        <!-- Activity Section -->
        <div class="activity-section">
            <div class="activity-header">
                <i class="fas fa-clock activity-icon"></i>
                <h3 class="activity-title">Aktivitas Terbaru</h3>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h6 class="chart-title">Grafik Kompetensi Karyawan</h6>
                        </div>
                        <div class="chart-body">
                            <canvas id="kompetensiChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="employee-list">
                        <div class="employee-header">
                            <h6 class="employee-title">Karyawan Terbaru</h6>
                        </div>
                        <div class="employee-body">
                            <div class="employee-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="employee-name">Ahmad Rizki</h6>
                                    <p class="employee-position">Software Developer</p>
                                </div>
                                <span class="status-badge status-new">Baru</span>
                            </div>
                            <div class="employee-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="employee-name">Sarah Putri</h6>
                                    <p class="employee-position">UI/UX Designer</p>
                                </div>
                                <span class="status-badge status-active">Aktif</span>
                            </div>
                            <div class="employee-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="employee-name">Budi Santoso</h6>
                                    <p class="employee-position">Project Manager</p>
                                </div>
                                <span class="status-badge status-evaluation">Evaluasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('kompetensiChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Rata-rata Skor Kompetensi',
                        data: [7.5, 8.2, 8.0, 8.5, 8.8, 8.5],
                        backgroundColor: 'rgba(30, 64, 175, 0.8)',
                        borderColor: 'rgba(30, 64, 175, 1)',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 14,
                                    weight: '600'
                                },
                                color: '#1f2937'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                color: '#6b7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                color: '#6b7280'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
