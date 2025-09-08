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
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-button:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }

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
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" placeholder="Cari pelatihan..."
                        style="
                    padding: 10px 15px;
                    border: 2px solid #e5e7eb;
                    border-radius: 25px;
                    font-size: 14px;
                    width: 250px;
                    outline: none;
                    transition: border-color 0.3s ease;
                "
                        onfocus="this.style.borderColor='#1e40af'" onblur="this.style.borderColor='#e5e7eb'">
                    <button
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
                        Search
                    </button>
                </div>
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
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="openEditModal(this)">Edit</button>
                                    <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
                                </div>
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
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="openEditModal(this)">Edit</button>
                                    <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
                                </div>
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
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="openEditModal(this)">Edit</button>
                                    <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
                                </div>
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
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="openEditModal(this)">Edit</button>
                                    <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
                                </div>
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
                                <div class="action-buttons">
                                    <button class="edit-button" onclick="openEditModal(this)">Edit</button>
                                    <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                                <input type="text" id="kode" name="kode" placeholder="Contoh: K3-001" required>
                            </div>
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select id="level" name="level" required>
                                    <option value="">Pilih Level</option>
                                    <option value="1">Level 1</option>
                                    <option value="2">Level 2</option>
                                    <option value="3">Level 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama_pelatihan">Nama Pelatihan</label>
                                <input type="text" id="nama_pelatihan" name="nama_pelatihan"
                                    placeholder="Masukkan nama pelatihan" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="divisi">Divisi</label>
                                <select id="divisi" name="divisi" required>
                                    <option value="">Pilih Divisi</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Operasi">Operasi</option>
                                    <option value="Pemeliharaan">Pemeliharaan</option>
                                    <option value="Teknik">Teknik</option>
                                    <option value="Administrasi">Administrasi</option>
                                    <option value="Keuangan">Keuangan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select id="jabatan" name="jabatan" required>
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Operator">Operator</option>
                                    <option value="Teknisi">Teknisi</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="sertifikat">Kode Sertifikat</label>
                                <input type="text" id="sertifikat" name="sertifikat"
                                    placeholder="Contoh: K3-CERT-001" required>
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

    <script>
        let isEditMode = false;
        let currentEditRow = null;

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

            // Ambil data dari row tabel
            const cells = currentEditRow.getElementsByTagName('td');
            const kode = cells[0].textContent.trim();
            const namaPelatihan = cells[1].textContent.trim();
            const levelText = cells[2].querySelector('.level-pill').textContent.trim();
            const divisi = cells[3].textContent.trim();
            const jabatan = cells[4].textContent.trim();
            const sertifikat = cells[5].textContent.trim();

            // Konversi level text ke number
            let levelValue = '';
            if (levelText.includes('1')) levelValue = '1';
            else if (levelText.includes('2')) levelValue = '2';
            else if (levelText.includes('3')) levelValue = '3';

            // Isi form dengan data
            document.getElementById('kode').value = kode;
            document.getElementById('nama_pelatihan').value = namaPelatihan;
            document.getElementById('level').value = levelValue;
            document.getElementById('divisi').value = divisi;
            document.getElementById('jabatan').value = jabatan;
            document.getElementById('sertifikat').value = sertifikat;

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

        // Fungsi untuk menyimpan data pelatihan
        function savePelatihan() {
            const form = document.getElementById('pelatihanForm');
            const formData = new FormData(form);

            // Validasi form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Ambil data dari form
            const data = {
                kode: formData.get('kode'),
                nama_pelatihan: formData.get('nama_pelatihan'),
                level: formData.get('level'),
                divisi: formData.get('divisi'),
                jabatan: formData.get('jabatan'),
                sertifikat: formData.get('sertifikat')
            };

            if (isEditMode && currentEditRow) {
                // Update data di tabel
                updateTableRow(currentEditRow, data);
                alert('Data pelatihan berhasil diupdate!\n\n' +
                    'Kode: ' + data.kode + '\n' +
                    'Nama: ' + data.nama_pelatihan + '\n' +
                    'Level: ' + data.level + '\n' +
                    'Divisi: ' + data.divisi + '\n' +
                    'Jabatan: ' + data.jabatan + '\n' +
                    'Sertifikat: ' + data.sertifikat);
            } else {
                // Tambah data baru ke tabel
                addNewTableRow(data);
                alert('Data pelatihan berhasil ditambahkan!\n\n' +
                    'Kode: ' + data.kode + '\n' +
                    'Nama: ' + data.nama_pelatihan + '\n' +
                    'Level: ' + data.level + '\n' +
                    'Divisi: ' + data.divisi + '\n' +
                    'Jabatan: ' + data.jabatan + '\n' +
                    'Sertifikat: ' + data.sertifikat);
            }

            closeModal();
        }

        // Fungsi untuk update row tabel
        function updateTableRow(row, data) {
            const cells = row.getElementsByTagName('td');
            cells[0].textContent = data.kode;
            cells[1].textContent = data.nama_pelatihan;

            // Update level pill
            const levelPill = cells[2].querySelector('.level-pill');
            levelPill.textContent = 'LEVEL ' + data.level;
            levelPill.className = 'level-pill level-' + data.level;

            cells[3].textContent = data.divisi;
            cells[4].textContent = data.jabatan;
            cells[5].textContent = data.sertifikat;
        }

        // Fungsi untuk menambah row baru ke tabel
        function addNewTableRow(data) {
            const tbody = document.querySelector('.data-table tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
        <td>${data.kode}</td>
        <td>${data.nama_pelatihan}</td>
        <td><span class="level-pill level-${data.level}">LEVEL ${data.level}</span></td>
        <td>${data.divisi}</td>
        <td>${data.jabatan}</td>
        <td>${data.sertifikat}</td>
        <td>
            <div class="action-buttons">
                <button class="edit-button" onclick="openEditModal(this)">Edit</button>
                <button class="delete-button" onclick="deleteRow(this)">Hapus</button>
            </div>
        </td>
    `;

            tbody.appendChild(newRow);
        }

        // Fungsi untuk menghapus row
        function deleteRow(button) {
            if (confirm('Apakah Anda yakin ingin menghapus data pelatihan ini?')) {
                const row = button.closest('tr');
                row.remove();
                alert('Data pelatihan berhasil dihapus!');
            }
        }

        // Menutup modal ketika user klik di luar modal
        window.onclick = function(event) {
            const modal = document.getElementById('pelatihanModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Menutup modal dengan tombol Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>

@endsection
