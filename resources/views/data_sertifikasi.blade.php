@extends('layouts/layout')

@section('title', 'Data Sertifikasi')

@section('content')
    <style>
        /* Data Sertifikasi Page Styling - Same theme as Pelatihan */
        .sertifikasi-container {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        /* Filter Section */
        .filter-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin: 0;
        }

        .filter-input {
            padding: 10px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: white;
            min-width: 150px;
        }

        .filter-input:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .filter-button {
            background: #1e40af;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            height: fit-content;
            margin-top: 20px;
        }

        .filter-button:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }

        /* Table Container */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Table Styling */
        .data-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            background: white;
        }

        .data-table th {
            background: #f8f9fa;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .data-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            font-size: 14px;
            white-space: nowrap;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        /* Column Widths */
        .data-table th:nth-child(1),
        .data-table td:nth-child(1) {
            width: 120px;
            min-width: 120px;
        }

        .data-table th:nth-child(2),
        .data-table td:nth-child(2) {
            width: 250px;
            min-width: 250px;
        }

        .data-table th:nth-child(3),
        .data-table td:nth-child(3) {
            width: 120px;
            min-width: 120px;
        }

        .data-table th:nth-child(4),
        .data-table td:nth-child(4) {
            width: 130px;
            min-width: 130px;
        }

        .data-table th:nth-child(5),
        .data-table td:nth-child(5) {
            width: 100px;
            min-width: 100px;
        }

        .data-table th:nth-child(6),
        .data-table td:nth-child(6) {
            width: 100px;
            min-width: 100px;
        }

        .data-table th:nth-child(7),
        .data-table td:nth-child(7) {
            width: 130px;
            min-width: 130px;
        }

        .data-table th:nth-child(8),
        .data-table td:nth-child(8) {
            width: 100px;
            min-width: 100px;
        }

        .data-table th:nth-child(9),
        .data-table td:nth-child(9) {
            width: 120px;
            min-width: 120px;
        }

        /* Status Pills */
        .status-pill {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .status-aktif {
            background: #059669;
        }

        .status-expired {
            background: #dc2626;
        }

        .status-pending {
            background: #ea580c;
        }

        /* Job Pills - Plain Text Style */
        .job-pill {
            padding: 0;
            font-size: 14px;
            font-weight: 400;
            color: #374151;
            background: none;
            border: none;
            text-transform: none;
            letter-spacing: normal;
        }

        .job-teknisi {
            background: none;
        }

        .job-supervisor {
            background: none;
        }

        .job-manager {
            background: none;
        }

        /* Division Pills - Plain Text Style */
        .division-pill {
            padding: 0;
            font-size: 14px;
            font-weight: 400;
            color: #374151;
            background: none;
            border: none;
            text-transform: none;
            letter-spacing: normal;
        }

        .division-maintenance {
            background: none;
        }

        .division-operasi {
            background: none;
        }

        .division-engineering {
            background: none;
        }

        /* Experience Pills - Plain Text Style */
        .experience-pill {
            padding: 0;
            font-size: 14px;
            font-weight: 400;
            color: #374151;
            background: none;
            border: none;
            text-transform: none;
            letter-spacing: normal;
        }

        .experience-6 {
            background: none;
        }

        .experience-8 {
            background: none;
        }

        .experience-12 {
            background: none;
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
            background: #10b981;
        }

        .level-2 {
            background: #f59e0b;
        }

        .level-3 {
            background: #ef4444;
        }

        /* Certification Pills - Plain Text Style */
        .certification-pill {
            padding: 0;
            font-size: 14px;
            font-weight: 400;
            color: #374151;
            background: none;
            border: none;
            text-transform: none;
            letter-spacing: normal;
        }

        .certification-2 {
            background: none;
        }

        .certification-3 {
            background: none;
        }

        .certification-5 {
            background: none;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .edit-button {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .edit-button:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .delete-button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .delete-button:hover {
            background: #b91c1c;
            transform: translateY(-1px);
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
            max-width: 700px;
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

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        .page-link {
            color: #1e40af;
            border: 1px solid #e5e7eb;
            padding: 10px 15px;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .page-item.active .page-link {
            background-color: #1e40af;
            border-color: #1e40af;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sertifikasi-container {
                padding: 20px 15px;
            }

            .content-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
            }

            .filter-input {
                min-width: auto;
            }

            .table-container {
                margin: 0 -15px;
                border-radius: 0;
            }

            .data-table {
                font-size: 12px;
                min-width: 1000px;
            }

            .data-table th,
            .data-table td {
                padding: 10px 8px;
            }

            /* Adjust column widths for mobile */
            .data-table th:nth-child(1),
            .data-table td:nth-child(1) {
                width: 100px;
                min-width: 100px;
            }

            .data-table th:nth-child(2),
            .data-table td:nth-child(2) {
                width: 200px;
                min-width: 200px;
            }

            .data-table th:nth-child(3),
            .data-table td:nth-child(3) {
                width: 100px;
                min-width: 100px;
            }

            .data-table th:nth-child(4),
            .data-table td:nth-child(4) {
                width: 110px;
                min-width: 110px;
            }

            .data-table th:nth-child(5),
            .data-table td:nth-child(5) {
                width: 90px;
                min-width: 90px;
            }

            .data-table th:nth-child(6),
            .data-table td:nth-child(6) {
                width: 90px;
                min-width: 90px;
            }

            .data-table th:nth-child(7),
            .data-table td:nth-child(7) {
                width: 110px;
                min-width: 110px;
            }

            .data-table th:nth-child(8),
            .data-table td:nth-child(8) {
                width: 90px;
                min-width: 90px;
            }

            .data-table th:nth-child(9),
            .data-table td:nth-child(9) {
                width: 100px;
                min-width: 100px;
            }

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
        }

        @media (max-width: 480px) {
            .data-table {
                min-width: 900px;
            }

            .data-table th,
            .data-table td {
                padding: 8px 6px;
                font-size: 11px;
            }

            .action-buttons {
                gap: 4px;
            }

            .view-button,
            .edit-button,
            .delete-button {
                width: 28px;
                height: 28px;
                padding: 6px;
                font-size: 10px;
            }
        }
    </style>

    <div class="sertifikasi-container">
        <!-- Main Content Card -->
        <div class="main-content-card">
            <div class="content-header">
                <h2 class="content-title">Data Sertifikasi</h2>
                <button class="add-button" data-bs-toggle="modal" data-bs-target="#addCertificationModal">
                    <i class="fas fa-plus"></i>
                    Tambah Sertifikasi
                    </button>
                </div>
                    <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-group">
                    <label>Status</label>
                    <select class="filter-input" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="expired">Expired</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                <div class="filter-group">
                    <label>Jenis</label>
                    <select class="filter-input" id="filterType">
                                <option value="">Semua Jenis</option>
                                <option value="professional">Professional</option>
                                <option value="technical">Technical</option>
                                <option value="safety">Safety</option>
                            </select>
                        </div>
                <div class="filter-group">
                    <label>Pencarian</label>
                    <input type="text" class="filter-input" id="searchInput" placeholder="Cari nama karyawan atau sertifikasi...">
                        </div>
                <button class="filter-button" onclick="applyFilters()">Filter</button>
                    </div>

            <!-- Data Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th>Masa Kerja</th>
                            <th>Level</th>
                            <th>Sertifikasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                            <td>10012349</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 40px; height: 40px; background: #1e40af; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                        A
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1f2937;">Ahmad Rizki</div>
                                        <div style="font-size: 12px; color: #6b7280;">ahmad.rizki@company.com</div>
                                    </div>
                                </div>
                                    </td>
                            <td><span class="job-pill job-teknisi">Teknisi</span></td>
                            <td><span class="division-pill division-maintenance">Maintenance</span></td>
                            <td><span class="experience-pill experience-6">6 tahun</span></td>
                            <td><span class="level-pill level-3">Level 3</span></td>
                            <td><span class="certification-pill certification-2">2 sertifikasi</span></td>
                            <td><span class="status-pill status-aktif">Aktif</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="editEmployee(1)">Edit</button>
                                    <button class="delete-button" onclick="deleteEmployee(1)">Hapus</button>
                                </div>
                                    </td>
                                </tr>
                                <tr>
                            <td>10012345</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 40px; height: 40px; background: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                        B
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1f2937;">Budi Santoso</div>
                                        <div style="font-size: 12px; color: #6b7280;">budi.santoso@company.com</div>
                                    </div>
                                </div>
                                    </td>
                            <td><span class="job-pill job-supervisor">Supervisor</span></td>
                            <td><span class="division-pill division-operasi">Operasi</span></td>
                            <td><span class="experience-pill experience-8">8 tahun</span></td>
                            <td><span class="level-pill level-2">Level 2</span></td>
                            <td><span class="certification-pill certification-3">3 sertifikasi</span></td>
                            <td><span class="status-pill status-aktif">Aktif</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="editEmployee(2)">Edit</button>
                                    <button class="delete-button" onclick="deleteEmployee(2)">Hapus</button>
                                </div>
                                    </td>
                                </tr>
                                <tr>
                            <td>10012350</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 40px; height: 40px; background: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                        S
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1f2937;">Siti Nurhaliza</div>
                                        <div style="font-size: 12px; color: #6b7280;">siti.nurhaliza@company.com</div>
                                    </div>
                                </div>
                                    </td>
                            <td><span class="job-pill job-manager">Manager</span></td>
                            <td><span class="division-pill division-engineering">Engineering</span></td>
                            <td><span class="experience-pill experience-12">12 tahun</span></td>
                            <td><span class="level-pill level-1">Level 1</span></td>
                            <td><span class="certification-pill certification-5">5 sertifikasi</span></td>
                            <td><span class="status-pill status-aktif">Aktif</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="editEmployee(3)">Edit</button>
                                    <button class="delete-button" onclick="deleteEmployee(3)">Hapus</button>
                                </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
    </div>
</div>

<!-- Add Certification Modal -->
    <div class="modal" id="addCertificationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Sertifikasi</h3>
                <button type="button" class="close-button" data-bs-dismiss="modal">&times;</button>
            </div>
            <form id="addCertificationForm">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="employeeName">Nama Karyawan</label>
                            <select id="employeeName" required>
                                    <option value="">Pilih Karyawan</option>
                                    <option value="1">John Doe</option>
                                    <option value="2">Jane Smith</option>
                                    <option value="3">Mike Johnson</option>
                                </select>
                            </div>
                        <div class="form-group">
                            <label for="certificationType">Jenis Sertifikasi</label>
                            <select id="certificationType" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="professional">Professional</option>
                                    <option value="technical">Technical</option>
                                    <option value="safety">Safety</option>
                                </select>
                            </div>
                        </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="certificationName">Nama Sertifikasi</label>
                            <input type="text" id="certificationName" required>
                        </div>
                        <div class="form-group">
                            <label for="organizer">Penyelenggara</label>
                            <input type="text" id="organizer" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="startDate">Tanggal Mulai</label>
                            <input type="date" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="endDate">Tanggal Berakhir</label>
                            <input type="date" id="endDate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="certificateFile">File Sertifikat</label>
                        <input type="file" id="certificateFile" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
    </div>
</div>

<script>
function applyFilters() {
    // Implement filter logic here
    console.log('Applying filters...');
}

function editEmployee(id) {
    // Implement edit employee logic here
    console.log('Editing employee:', id);
    alert('Fitur edit karyawan akan segera tersedia!');
}

function deleteEmployee(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')) {
        // Implement delete logic here
        console.log('Deleting employee:', id);
        alert('Data karyawan berhasil dihapus!');
    }
}

// Form submission
document.getElementById('addCertificationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Implement form submission logic here
    console.log('Submitting certification form...');
    alert('Data sertifikasi berhasil ditambahkan!');
    // Close modal after successful submission
    const modal = document.getElementById('addCertificationModal');
    modal.style.display = 'none';
});
</script>
@endsection
