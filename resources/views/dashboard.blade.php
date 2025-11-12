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
            @if(($showExpiringAlert ?? false) && [($expiringSoonCount ?? 0), ($expiredCount ?? 0)])
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const soon = Number({{ (int) ($expiringSoonCount ?? 0) }});
                    const expired = Number({{ (int) ($expiredCount ?? 0) }});
                    const parts = [];
                    if (expired > 0) parts.push(`${expired} kadaluarsa`);
                    if (soon > 0) parts.push(`${soon} segera habis (≤ 7 hari)`);
                    const html = `
                        <div style="display:flex; align-items:center; gap:12px; justify-content:center; margin-bottom:6px;">
                            <span style="display:inline-flex; align-items:center; gap:8px; background:#fff6e6; color:#b45309; border:1px solid #fde68a; padding:6px 10px; border-radius:999px; font-weight:600;">
                                <i class="fas fa-triangle-exclamation"></i> Pengingat Sertifikasi
                            </span>
                        </div>
                        <div style="color:#4b5563; font-size:14px; margin-top:4px;">
                            Ada <strong>${parts.join(' + ')}</strong>.
                        </div>
                        <div style="color:#6b7280; font-size:12px; margin-top:8px;">
                            Klik tombol di bawah ini untuk membuka halaman Data Sertifikasi.
                        </div>
                    `;

                    Swal.fire({
                        icon: undefined,
                        iconHtml: '<div style=\"width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#fde68a,#f59e0b);box-shadow:0 4px 16px rgba(245,158,11,.35);\"><i class=\"fas fa-bell\" style=\"color:#92400e;font-size:22px\"></i></div>',
                        title: '<div style=\"font-weight:700;color:#111827;letter-spacing:.3px;\">Notifikasi Sertifikasi</div>',
                        html,
                        timer: 5000,
                        timerProgressBar: true,
                        position: 'center',
                        toast: false,
                        width: '40rem',
                        background: '#ffffff',
                        color: '#111827',
                        confirmButtonText: 'Buka Data Sertifikasi',
                        showConfirmButton: true,
                        showCloseButton: false,
                        focusConfirm: false,
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        backdrop: 'rgba(0,0,0,0.35)',
                        customClass: {
                            popup: 'swal2-rounded swal2-elevated'
                        },
                        buttonsStyling: false,
                        confirmButtonAriaLabel: 'Buka Data Sertifikasi',
                        didRender: () => {
                            const btn = document.querySelector('.swal2-confirm');
                            if (btn) {
                                btn.style.background = 'linear-gradient(135deg,#2563eb,#1e40af)';
                                btn.style.color = '#ffffff';
                                btn.style.border = '0';
                                btn.style.borderRadius = '10px';
                                btn.style.padding = '10px 16px';
                                btn.style.fontWeight = '600';
                                btn.style.boxShadow = '0 6px 16px rgba(30,64,175,.25)';
                            }
                            const popup = document.querySelector('.swal2-popup');
                            if (popup) {
                                popup.style.borderRadius = '16px';
                                popup.style.boxShadow = '0 20px 45px rgba(0,0,0,.12)';
                                popup.style.paddingTop = '22px';
                            }
                        },
                        didOpen: (popup) => {
                            // no-op
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('certifications.index') }}";
                        }
                    });
                });
                </script>
            @endif
            <div class="stat-card">
                <div class="stat-icon-container blue">
                    <i class="fas fa-users stat-icon"></i>
                </div>
                <div class="stat-number">{{ $totalEmployees ?? 0 }}</div>
                <div class="stat-label">Total Karyawan</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-container green">
                    <i class="fas fa-star stat-icon"></i>
                </div>
                <div class="stat-number">{{ $activeCompetencies ?? 0 }}</div>
                <div class="stat-label">Kompetensi Aktif</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-container orange">
                    <i class="fas fa-graduation-cap stat-icon"></i>
                </div>
                <div class="stat-number">{{ $completedTrainings ?? 0 }}</div>
                <div class="stat-label">Pelatihan Selesai</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-container red">
                    <i class="fas fa-database stat-icon"></i>
                </div>
                <div class="stat-number">{{ $totalTrainings ?? 0 }}</div>
                <div class="stat-label">Jumlah Data Pelatihan</div>
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
                            <h6 class="chart-title">Pelatihan Diikuti per Bulan (12 Bulan Terakhir)</h6>
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
                            @forelse(($latestEmployees ?? []) as $emp)
                                <div class="employee-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="employee-name">{{ $emp->nama }}</h6>
                                        <p class="employee-position">{{ $emp->jabatan }}{{ $emp->divisi ? ' • ' . $emp->divisi : '' }}</p>
                                    </div>
                                    <span class="status-badge status-new">Baru</span>
                                </div>
                            @empty
                                <div class="employee-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="employee-name">Belum ada data</h6>
                                        <p class="employee-position">-</p>
                                    </div>
                                </div>
                            @endforelse
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
            const labels = @json($chartLabels ?? []);
            const seriesData = @json($chartData ?? []);
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pelatihan',
                        data: seriesData,
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
