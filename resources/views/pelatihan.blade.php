@extends('layouts/layout')

@section('title', 'Pelatihan')

@section('content')
<style>
/* Pelatihan Page Styling - Same theme as Dashboard */
.pelatihan-container {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Header Section */
.pelatihan-header {
    text-align: center;
    margin-bottom: 30px;
    color: rgb(0, 0, 0);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-bottom: 15px;
}

.logo-container {
    width: 60px;
    height: 60px;
    background: #6b7280;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.logo-icon {
    color: white;
    font-size: 24px;
}

.logo-arrow {
    position: absolute;
    top: -5px;
    right: -5px;
    color: #dc2626;
    font-size: 16px;
}

.main-title {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
}

.subtitle {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
    font-weight: 400;
}

/* Navigation Bar */
.nav-bar {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 15px 25px;
    margin-bottom: 30px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.nav-item {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.nav-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.nav-item.active {
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.nav-item i {
    font-size: 16px;
}

/* Main Content Card */
.main-content-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.content-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.add-button {
    background: linear-gradient(135deg, #1e40af);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.add-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Table Styling */
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.data-table th {
    background: #f8f9fa;
    padding: 15px 12px;
    text-align: left;
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
    border-bottom: 2px solid #e5e7eb;
}

.data-table td {
    padding: 15px 12px;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
    font-size: 14px;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

/* Level Pills */
.level-pill {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: white;
}

.level-1 {
    background: #059669;
}

.level-2 {
    background: #ea580c;
}

.level-3 {
    background: #dc2626;
}

/* Action Buttons */
.delete-button {
    background: #dc2626;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.delete-button:hover {
    background: #b91c1c;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .pelatihan-container {
        padding: 20px 15px;
    }
    
    .header-content {
        flex-direction: column;
        gap: 15px;
    }
    
    .main-title {
        font-size: 24px;
    }
    
    .nav-bar {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .nav-item {
        font-size: 12px;
        padding: 10px 16px;
    }
    
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .data-table {
        font-size: 12px;
    }
    
    .data-table th,
    .data-table td {
        padding: 10px 8px;
    }
}
</style>

<div class="pelatihan-container">
    
    <!-- Main Content Card -->
    <div class="main-content-card">
        <div class="content-header">
            <h2 class="content-title">Manajemen Data Pelatihan</h2>
            <button class="add-button">
                <i class="fas fa-plus"></i>
                 Tambah Pelatihan
            </button>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Pelatihan</th>
                        <th>Level</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th>Sertifikat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>K3-001</td>
                        <td>Pelatihan K3 Dasar</td>
                        <td><span class="level-pill level-1">LEVEL 1</span></td>
                        <td>Umum</td>
                        <td>Umum</td>
                        <td>K3-CERT-001</td>
                        <td>
                            <button class="delete-button">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>PLTU-001</td>
                        <td>Operasi PLTU Dasar</td>
                        <td><span class="level-pill level-1">LEVEL 1</span></td>
                        <td>Operasi</td>
                        <td>Operator</td>
                        <td>PLTU-CERT-001</td>
                        <td>
                            <button class="delete-button">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>PLTU-002</td>
                        <td>Operasi PLTU Menengah</td>
                        <td><span class="level-pill level-2">LEVEL 2</span></td>
                        <td>Operasi</td>
                        <td>Teknisi</td>
                        <td>PLTU-CERT-002</td>
                        <td>
                            <button class="delete-button">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>MAINT-001</td>
                        <td>Pemeliharaan Preventif</td>
                        <td><span class="level-pill level-2">LEVEL 2</span></td>
                        <td>Pemeliharaan</td>
                        <td>Teknisi</td>
                        <td>MAINT-CERT-001</td>
                        <td>
                            <button class="delete-button">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>ENG-001</td>
                        <td>Analisis Sistem Kelistrikan</td>
                        <td><span class="level-pill level-3">LEVEL 3</span></td>
                        <td>Teknik</td>
                        <td>Engineer</td>
                        <td>ENG-CERT-001</td>
                        <td>
                            <button class="delete-button">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
