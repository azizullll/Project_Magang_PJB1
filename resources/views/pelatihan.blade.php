@extends('layouts/layout')

@section('title', 'Pelatihan')

@section('content')
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
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
            background: linear-gradient(135deg, #28a745);
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

        /* Horizontal Scroll Container for Table */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
            border-radius: 10px;
        }

        /* Ensure table has a minimum width for neat columns */
        .table-container .data-table {
            min-width: 1200px;
        }

        /* Keep cells on a single line for consistency */
        .data-table th,
        .data-table td {
            white-space: nowrap;
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
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .edit-button {
            background: #1e40af;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }

        .edit-button:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }

        .delete-button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }

        .delete-button:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        .show-button {
            background: #059669;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }

        .show-button:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        /* Tooltip styling */
        .action-buttons button[title] {
            position: relative;
        }

        .action-buttons button[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        }

        .action-buttons button[title]:hover::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-bottom-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            pointer-events: none;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #1e40af);
            color: white;
            padding: 20px 30px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .close-button {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .close-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 30px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: white;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-group select {
            cursor: pointer;
        }

        .modal-footer {
            padding: 20px 30px 30px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn-cancel {
            background: #6b7280;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #4b5563;
            transform: translateY(-1px);
        }

        .btn-save {
            background: linear-gradient(135deg, #28a745);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(5, 150, 105, 0.3);
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

            /* Modal responsive */
            .modal-content {
                margin: 10% auto;
                width: 95%;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 20px;
            }

            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            .btn-cancel,
            .btn-save {
                width: 100%;
                padding: 15px;
            }

            /* Responsive untuk penjelasan level */
            .level-explanation {
                margin-top: 15px !important;
                padding: 12px !important;
            }

            .level-explanation h3 {
                font-size: 14px !important;
                margin-bottom: 10px !important;
            }

            .level-cards {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }

            .level-card {
                padding: 10px !important;
            }

            .level-card h4 {
                font-size: 12px !important;
            }

            .level-card p {
                font-size: 11px !important;
            }

            /* Search responsive */
            #searchInput {
                width: 100% !important;
                margin-bottom: 10px;
            }

            .search-buttons {
                display: flex;
                gap: 8px;
                width: 100%;
            }

            .search-buttons button {
                flex: 1;
                padding: 12px !important;
            }

            /* Show modal responsive */
            .detail-container {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
            }

            .detail-section {
                margin-top: 15px !important;
            }

            .detail-section h4 {
                font-size: 14px !important;
                margin-bottom: 10px !important;
            }

            .detail-item {
                margin-bottom: 10px !important;
            }

            .detail-item label {
                font-size: 12px !important;
            }

            .detail-item span {
                font-size: 13px !important;
            }

            /* Action buttons responsive */
            .action-buttons {
                flex-direction: column !important;
                gap: 4px !important;
            }

            .action-buttons button {
                min-width: 32px !important;
                height: 32px !important;
                font-size: 12px !important;
            }

            .action-buttons button[title]:hover::after {
                bottom: -30px !important;
                font-size: 10px !important;
                padding: 3px 6px !important;
            }
        }
    </style>

    <div class="pelatihan-container">

        <!-- Main Content Card -->
        <div class="main-content-card">
            <div class="content-header">        
                <h2 class="content-title">Manajemen Data Pelatihan</h2>
                <button class="add-button" onclick="openModal()">
                    <i class="fas fa-plus"></i>
                    Tambah Pelatihan
                </button>
            </div>

            <!-- Search Section -->
            <div style="margin-bottom: 20px;">
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, kategori, divisi, jabatan, level, masa aktif"
                        style="
                    padding: 10px 15px;
                    border: 2px solid #e5e7eb;
                    border-radius: 25px;
                    font-size: 14px;
                    width: 350px;
                    outline: none;
                    transition: border-color 0.3s ease;
                "
                        onfocus="this.style.borderColor='#1e40af'" onblur="this.style.borderColor='#e5e7eb'"
                        onkeyup="searchPelatihan()">
                    <div class="search-buttons" style="display: flex; gap: 10px;">
                        <button onclick="searchPelatihan()"
                            style="
                        background: #1e40af;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 25px;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 500;
                        transition: background 0.3s ease;
                    "
                            onmouseover="this.style.background='#1e3a8a'" onmouseout="this.style.background='#1e40af'">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button onclick="clearSearch()"
                            style="
                        background: #6b7280;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 25px;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 500;
                        transition: background 0.3s ease;
                    "
                            onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            <i class="fas fa-times"></i> Reset
                        </button>
                    </div>
                </div>
                <div id="searchResults" style="margin-top: 10px; font-size: 12px; color: #6b7280;">
                    <!-- Search results info will appear here -->
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Bidang</th>
                            <th>Kompetensi Inti</th>
                            <th>Kompetensi Pilihan</th>
                            <th>Level</th>
                            <th>Masa Aktif Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat secara dinamis dari database -->
                    </tbody>
                </table>
            </div>

            <!-- Penjelasan Level Pelatihan -->
            <div class="level-explanation" style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px; ">
                <h3 style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px; font-weight: 600;">
                    <i class="fas fa-info-circle" style="margin-right: 6px; color: #1e40af;"></i>
                    Penjelasan Level Pelatihan
                </h3>
                <div class="level-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                    <div class="level-card" style="background: white; padding: 12px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                            <span class="level-pill level-1" style="margin-right: 8px; font-size: 10px; padding: 4px 8px;">LEVEL 1</span>
                            <h4 style="margin: 0; color: #059669; font-size: 13px; font-weight: 600;">Dasar</h4>
                        </div>
                        <p style="margin: 0; color: #6b7280; font-size: 12px; line-height: 1.4;">
                            Untuk pemula dan karyawan baru. Mencakup pengetahuan dasar dan konsep fundamental.
                        </p>
                    </div>
                    
                    <div class="level-card" style="background: white; padding: 12px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                            <span class="level-pill level-2" style="margin-right: 8px; font-size: 10px; padding: 4px 8px;">LEVEL 2</span>
                            <h4 style="margin: 0; color: #ea580c; font-size: 13px; font-weight: 600;">Menengah</h4>
                        </div>
                        <p style="margin: 0; color: #6b7280; font-size: 12px; line-height: 1.4;">
                            Untuk karyawan berpengalaman. Mengembangkan keterampilan praktis dan aplikasi.
                        </p>
                    </div>
                    
                    <div class="level-card" style="background: white; padding: 12px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                            <span class="level-pill level-3" style="margin-right: 8px; font-size: 10px; padding: 4px 8px;">LEVEL 3</span>
                            <h4 style="margin: 0; color: #dc2626; font-size: 13px; font-weight: 600;">Lanjutan</h4>
                        </div>
                        <p style="margin: 0; color: #6b7280; font-size: 12px; line-height: 1.4;">
                            Untuk profesional senior. Keahlian khusus dan kemampuan analisis mendalam.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Show Detail Pelatihan -->
        <div id="showPelatihanModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Detail Pelatihan</h3>
                    <button class="close-button" onclick="closeShowModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="detail-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="detail-section">
                            <h4 style="color: #1e40af; margin-bottom: 15px; font-size: 16px; font-weight: 600;">
                                <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Informasi Dasar
                            </h4>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Kode Pelatihan:</label>
                                <span id="showKode" style="color: #1f2937;"></span>
                            </div>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Nama Pelatihan:</label>
                                <span id="showNama" style="color: #1f2937;"></span>
                            </div>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Kategori:</label>
                                <span id="showKategori" style="color: #1f2937;"></span>
                            </div>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Level:</label>
                                <span id="showLevel" style="color: #1f2937;"></span>
                            </div>
                        </div>
                        
                        <div class="detail-section">
                            <h4 style="color: #1e40af; margin-bottom: 15px; font-size: 16px; font-weight: 600;">
                                <i class="fas fa-building" style="margin-right: 8px;"></i>Organisasi & Biaya
                            </h4>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Divisi:</label>
                                <span id="showDivisi" style="color: #1f2937;"></span>
                            </div>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Jabatan:</label>
                                <span id="showJabatan" style="color: #1f2937;"></span>
                            </div>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Biaya:</label>
                                <span id="showBiaya" style="color: #1f2937;"></span>
                            </div>
                            <div class="detail-item" style="margin-bottom: 12px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Durasi:</label>
                                <span id="showDurasi" style="color: #1f2937;"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section" style="margin-top: 20px;">
                        <h4 style="color: #1e40af; margin-bottom: 15px; font-size: 16px; font-weight: 600;">
                            <i class="fas fa-certificate" style="margin-right: 8px;"></i>Informasi Sertifikat
                        </h4>
                        <div class="detail-item" style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Kode Sertifikat:</label>
                            <span id="showSertifikat" style="color: #1f2937;"></span>
                        </div>
                        <div class="detail-item" style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Masa Aktif Sertifikat:</label>
                            <span id="showTenggat" style="color: #1f2937;"></span>
                        </div>
                        <div class="detail-item">
                            <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 4px;">Status Sertifikat:</label>
                            <span id="showStatusSertifikat" style="color: #1f2937;"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeShowModal()">Tutup</button>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pelatihan -->
        <div id="pelatihanModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalTitle">Tambah Data Pelatihan</h3>
                    <button class="close-button" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="pelatihanForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="kode">Kode Pelatihan</label>
                                <input type="text" id="kode" name="kode" placeholder="Contoh: CM001" required>
                            </div>
                            <div class="form-group">
                                <label for="bidang">Bidang</label>
                                <input type="text" id="bidang" name="bidang" placeholder="Contoh: Proyek" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" id="judul" name="judul" placeholder="Masukkan judul pelatihan" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="kompetensi_inti">Kompetensi Inti</label>
                                <input type="text" id="kompetensi_inti" name="kompetensi_inti" placeholder="Kompetensi inti" required>
                            </div>
                            <div class="form-group">
                                <label for="kompetensi_pilihan">Kompetensi Pilihan</label>
                                <input type="text" id="kompetensi_pilihan" name="kompetensi_pilihan" placeholder="Kompetensi pilihan (opsional)">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select id="level" name="level" required>
                                    <option value="">Pilih Level</option>
                                    <option value="1">Level 1</option>
                                    <option value="2">Level 2</option>
                                    <option value="3">Level 3</option>
                                    <option value="4">Level 4</option>
                                    <option value="5">Level 5</option>
                                    <option value="6">Level 6</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tidak ada durasi/biaya/sertifikat pada skema baru -->

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tenggat_sertifikat">Masa Aktif Sertifikat (Tahun)</label>
                                <select id="tenggat_sertifikat" name="tenggat_sertifikat">
                                    <option value="">Pilih Masa Aktif</option>
                                    <option value="1">1 Tahun</option>
                                    <option value="2">2 Tahun</option>
                                    <option value="3">3 Tahun</option>
                                    <option value="4">4 Tahun</option>
                                    <option value="5">5 Tahun</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="button" class="btn-save" id="saveButton" onclick="savePelatihan()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        let isEditMode = false;
        let currentEditRow = null;
        let allRows = []; // Store all table rows for search functionality
        let pelatihanData = []; // Store pelatihan data from API

        // Initialize data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadPelatihanData();
        });

        // Load pelatihan data from API
        async function loadPelatihanData() {
            try {
                const response = await fetch('/api/pelatihan');
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                const items = Array.isArray(result) ? result : (result && result.data ? result.data : []);
                pelatihanData = items;
                renderTable(items);
            } catch (error) {
                console.error('Error loading pelatihan data:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal memuat data pelatihan',
                    confirmButtonColor: '#dc2626'
                });
            }
        }

        // Render table with data
        function renderTable(data) {
            try {
                const tbody = document.querySelector('.data-table tbody');
                if (!tbody) {
                    console.error('Table body not found');
                    return;
                }

                tbody.innerHTML = '';

                if (data && Array.isArray(data)) {
                    data.forEach(pelatihan => {
                        const row = createTableRow(pelatihan);
                        if (row) {
                            tbody.appendChild(row);
                        }
                    });
                }

                // Update allRows array for search functionality
                allRows = Array.from(tbody.querySelectorAll('tr'));
            } catch (error) {
                console.error('Error rendering table:', error);
            }
        }

        // Create table row element
        function createTableRow(pelatihan) {
            try {
                if (!pelatihan || typeof pelatihan !== 'object') {
                    console.error('Invalid pelatihan data:', pelatihan);
                    return null;
                }

                const row = document.createElement('tr');
                row.setAttribute('data-id', pelatihan.id || '');
                
                row.innerHTML = `
                    <td>${pelatihan.kode || ''}</td>
                    <td>${pelatihan.judul || ''}</td>
                    <td>${pelatihan.bidang || ''}</td>
                    <td>${pelatihan.kompetensi_inti || ''}</td>
                    <td>${pelatihan.kompetensi_pilihan || ''}</td>
                    <td><span class="level-pill level-${pelatihan.level || 1}">LEVEL ${pelatihan.level || 1}</span></td>
                    <td>${pelatihan.tenggat_sertifikat ? pelatihan.tenggat_sertifikat + ' Tahun' : ''}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="show-button" onclick="showPelatihanDetail(this)" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="edit-button" onclick="openEditModal(this)" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-button" onclick="deleteRow(this)" title="Hapus Data">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                
                return row;
            } catch (error) {
                console.error('Error creating table row:', error);
                return null;
            }
        }

        // Fungsi untuk membuka modal tambah
        function openModal() {
            isEditMode = false;
            document.getElementById('modalTitle').textContent = 'Tambah Data Pelatihan';
            document.getElementById('saveButton').textContent = 'Simpan';
            document.getElementById('pelatihanForm').reset();
            document.getElementById('pelatihanModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Fungsi untuk membuka modal edit
        function openEditModal(button) {
            isEditMode = true;
            currentEditRow = button.closest('tr');
            const pelatihanId = currentEditRow.getAttribute('data-id');

            // Cari data pelatihan berdasarkan ID
            const pelatihan = pelatihanData.find(p => p.id == pelatihanId);
            if (!pelatihan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Data pelatihan tidak ditemukan',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }


            // Isi form dengan data
            document.getElementById('kode').value = pelatihan.kode || '';
            document.getElementById('judul').value = pelatihan.judul || '';
            document.getElementById('bidang').value = pelatihan.bidang || '';
            document.getElementById('kompetensi_inti').value = pelatihan.kompetensi_inti || '';
            document.getElementById('kompetensi_pilihan').value = pelatihan.kompetensi_pilihan || '';
            document.getElementById('level').value = pelatihan.level ? pelatihan.level.toString() : '';
            document.getElementById('tenggat_sertifikat').value = pelatihan.tenggat_sertifikat || '';

            // Update modal title dan button
            document.getElementById('modalTitle').textContent = 'Edit Data Pelatihan';
            document.getElementById('saveButton').textContent = 'Update';

            document.getElementById('pelatihanModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('pelatihanModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('pelatihanForm').reset();
            isEditMode = false;
            currentEditRow = null;
        }

        // Fungsi untuk menampilkan detail pelatihan
        function showPelatihanDetail(button) {
            const row = button.closest('tr');
            const pelatihanId = row.getAttribute('data-id');

            // Cari data pelatihan berdasarkan ID
            const pelatihan = pelatihanData.find(p => p.id == pelatihanId);
            if (!pelatihan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Data pelatihan tidak ditemukan',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            // Isi data ke modal show
            document.getElementById('showKode').textContent = pelatihan.kode || '-';
            document.getElementById('showNama').textContent = pelatihan.judul || '-';
            document.getElementById('showKategori').textContent = pelatihan.bidang || '-';
            document.getElementById('showLevel').innerHTML = `<span class="level-pill level-${pelatihan.level || 1}">LEVEL ${pelatihan.level || 1}</span>`;
            document.getElementById('showDivisi').textContent = pelatihan.kompetensi_inti || '-';
            document.getElementById('showJabatan').textContent = pelatihan.kompetensi_pilihan || '-';
            document.getElementById('showBiaya').textContent = '-';
            document.getElementById('showDurasi').textContent = '-';
            document.getElementById('showSertifikat').textContent = '-';
            
            // Tampilkan masa aktif sertifikat
            const tenggatSertifikat = pelatihan.tenggat_sertifikat;
            if (tenggatSertifikat) {
                document.getElementById('showTenggat').textContent = `${tenggatSertifikat} Tahun`;
                
                // Status sertifikat berdasarkan masa aktif
                let statusText = '';
                let statusColor = '';
                
                const masaAktif = parseInt(tenggatSertifikat);
                
                if (masaAktif >= 3) {
                    statusText = 'Masa Aktif Panjang';
                    statusColor = '#059669';
                } else if (masaAktif === 2) {
                    statusText = 'Masa Aktif Sedang';
                    statusColor = '#d97706';
                } else if (masaAktif === 1) {
                    statusText = 'Masa Aktif Pendek';
                    statusColor = '#ea580c';
                } else {
                    statusText = 'Masa Aktif Tidak Valid';
                    statusColor = '#dc2626';
                }
                
                document.getElementById('showStatusSertifikat').innerHTML = 
                    `<span style="color: ${statusColor}; font-weight: 600;">${statusText}</span>`;
            } else {
                document.getElementById('showTenggat').textContent = '-';
                document.getElementById('showStatusSertifikat').textContent = '-';
            }

            // Tampilkan modal
            document.getElementById('showPelatihanModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Fungsi untuk menutup modal show
        function closeShowModal() {
            document.getElementById('showPelatihanModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fungsi untuk menyimpan data pelatihan
        async function savePelatihan() {
            const form = document.getElementById('pelatihanForm');
            const formData = new FormData(form);

            // Validasi form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Ambil data dari form
            const data = {
                bidang: formData.get('bidang'),
                kode: formData.get('kode'),
                judul: formData.get('judul'),
                kompetensi_inti: formData.get('kompetensi_inti'),
                kompetensi_pilihan: formData.get('kompetensi_pilihan'),
                level: parseInt(formData.get('level')),
                tenggat_sertifikat: formData.get('tenggat_sertifikat') ? parseInt(formData.get('tenggat_sertifikat')) : null
            };


            try {
                let response;
                let url = '/api/pelatihan';
                let method = 'POST';

                if (isEditMode && currentEditRow) {
                    const pelatihanId = currentEditRow.getAttribute('data-id');
                    url = `/api/pelatihan/${pelatihanId}`;
                    method = 'PUT';
                }

                response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();


                if (result.success) {
                    // Reload data dari server
                    await loadPelatihanData();
                    
                    if (isEditMode) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data pelatihan berhasil diperbarui!',
                            confirmButtonColor: '#28a745'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data pelatihan berhasil ditambahkan!',
                            confirmButtonColor: '#28a745'
                        });
                    }
                    closeModal();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: result.message,
                        confirmButtonColor: '#dc2626'
                    });
                    if (result.errors) {
                        console.error('Validation errors:', result.errors);
                    }
                }
            } catch (error) {
                console.error('Error saving pelatihan:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal menyimpan data pelatihan',
                    confirmButtonColor: '#dc2626'
                });
            }
        }


        // Fungsi untuk menghapus row
        async function deleteRow(button) {
            const result = await Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pelatihan akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                const row = button.closest('tr');
                const pelatihanId = row.getAttribute('data-id');

                try {
                    const response = await fetch(`/api/pelatihan/${pelatihanId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Reload data dari server
                        await loadPelatihanData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: result.message,
                            confirmButtonColor: '#28a745'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: result.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                } catch (error) {
                    console.error('Error deleting pelatihan:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Gagal menghapus data pelatihan',
                        confirmButtonColor: '#dc2626'
                    });
                }
            }
        }

        // Menutup modal ketika user klik di luar modal
        window.onclick = function(event) {
            const modal = document.getElementById('pelatihanModal');
            const showModal = document.getElementById('showPelatihanModal');
            if (event.target == modal) {
                closeModal();
            }
            if (event.target == showModal) {
                closeShowModal();
            }
        }

        // Menutup modal dengan tombol Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
                closeShowModal();
            }
        });

        // Fungsi untuk mencari pelatihan
        async function searchPelatihan() {
            try {
                const searchInput = document.getElementById('searchInput');
                const searchResults = document.getElementById('searchResults');
                
                if (!searchInput || !searchResults) {
                    console.error('Search elements not found');
                    return;
                }

                const searchTerm = searchInput.value.trim();

                let url = '/api/pelatihan';
                if (searchTerm !== '') {
                    url = `/api/pelatihan/search?q=${encodeURIComponent(searchTerm)}`;
                }

                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();

                if ((Array.isArray(result)) || (result && result.success)) {
                    const items = Array.isArray(result) ? result : (result.data || []);
                    pelatihanData = items;
                    renderTable(items);
                    
                    // Update search results info
                    if (searchTerm === '') {
                        searchResults.innerHTML = '';
                    } else {
                        const total = result.total || 0;
                        if (total === 0) {
                            searchResults.innerHTML = '<i class="fas fa-info-circle"></i> Tidak ada data yang sesuai dengan pencarian "' + searchTerm + '"';
                            searchResults.style.color = '#dc2626';
                        } else {
                            searchResults.innerHTML = '<i class="fas fa-check-circle"></i> Ditemukan ' + total + ' data yang sesuai dengan pencarian "' + searchTerm + '"';
                            searchResults.style.color = '#059669';
                        }
                    }
                } else {
                    const errorMessage = result && result.message ? result.message : 'Unknown error occurred';
                    console.error('API Error:', result);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonColor: '#dc2626'
                    });
                }
            } catch (error) {
                console.error('Error searching pelatihan:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal melakukan pencarian: ' + error.message,
                    confirmButtonColor: '#dc2626'
                });
            }
        }

        // Fungsi untuk membersihkan pencarian
        function clearSearch() {
            try {
                const searchInput = document.getElementById('searchInput');
                const searchResults = document.getElementById('searchResults');
                
                if (searchInput) {
                    searchInput.value = '';
                }
                
                if (searchResults) {
                    searchResults.innerHTML = '';
                }
                
                // Reload semua data
                loadPelatihanData();
            } catch (error) {
                console.error('Error in clearSearch:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal membersihkan pencarian',
                    confirmButtonColor: '#dc2626'
                });
            }
        }
    </script>

@endsection
