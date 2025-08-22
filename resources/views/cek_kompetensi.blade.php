<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cek Kompetensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f8fafc, #ffffff);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0px 6px 18px rgba(0,0,0,0.08);
    }
    .card-header {
      background: linear-gradient(90deg, #2563eb, #1d4ed8);
      color: #fff;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
      font-weight: 600;
      padding: 16px 20px;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .card-header i {
      font-size: 1.3rem;
    }
    .btn-submit {
      background: linear-gradient(90deg, #2563eb, #1d4ed8);
      color: white;
      font-weight: 500;
      border-radius: 8px;
      padding: 10px 20px;
      border: none;
    }
    .btn-submit:hover {
      background: linear-gradient(90deg, #1d4ed8, #1e40af);
    }
    .btn-reset {
      background-color: #f1f5f9;
      border: 1px solid #cbd5e1;
      font-weight: 500;
      border-radius: 8px;
      padding: 10px 20px;
      color: #1e293b;
    }
    .btn-reset:hover {
      background-color: #e2e8f0;
    }
    .btn-back {
      background-color: #0ea5e9;
      color: white;
      font-weight: 500;
      border-radius: 8px;
      padding: 10px 20px;
    }
    .btn-back:hover {
      background-color: #0284c7;
    }
    h2 {
      font-weight: 700;
      color: #1e293b;
    }
    .table thead {
      background: linear-gradient(90deg, #2563eb, #1d4ed8);
      color: white;
    }
    .table tbody tr:hover {
      background-color: #f1f5ff;
    }
    .form-control, .form-select {
      border-radius: 10px;
      padding: 10px 14px;
      border: 1px solid #cbd5e1;
    }
    .form-label {
      font-weight: 500;
      color: #334155;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-5">Cek Kompetensi Karyawan</h2>

  <!-- Form Input -->
  <div class="card mb-5">
    <div class="card-header">
      <i class="bi bi-person-badge"></i> Form Input Karyawan
    </div>
    <div class="card-body">
      <form>
        <div class="row g-4">
          <div class="col-md-6">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control" placeholder="Masukkan nama lengkap">
          </div>
          <div class="col-md-6">
            <label class="form-label">NIP</label>
            <input type="text" class="form-control" placeholder="Masukkan NIP">
          </div>
          <div class="col-md-6">
            <label class="form-label">Jabatan</label>
            <input type="text" class="form-control" placeholder="Masukkan jabatan">
          </div>
          <div class="col-md-6">
            <label class="form-label">Divisi</label>
            <input type="text" class="form-control" placeholder="Masukkan divisi">
          </div>
          <div class="col-md-6">
            <label class="form-label">Lama Bekerja (tahun)</label>
            <input type="number" class="form-control" placeholder="Masukkan lama bekerja">
          </div>
          <div class="col-md-6">
            <label class="form-label">Riwayat Pelatihan</label>
            <textarea class="form-control" rows="2" placeholder="Contoh: Leadership, Manajemen Proyek"></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-between mt-5">
          <a href="/" class="btn btn-back">⬅ Back</a>
          <div>
            <button type="reset" class="btn btn-reset me-2">Reset</button>
            <button type="submit" class="btn btn-submit">Cek Kompetensi</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Tabel Output -->
  <div class="card">
    <div class="card-header">
      <i class="bi bi-clipboard-data"></i> Hasil Rekomendasi Pelatihan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Karyawan</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Divisi</th>
              <th>Lama Bekerja</th>
              <th>Riwayat Pelatihan</th>
              <th>Rekomendasi Pelatihan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Budi Santoso</td>
              <td>123456</td>
              <td>Staff IT</td>
              <td>Teknologi Informasi</td>
              <td>3 Tahun</td>
              <td>Dasar Keamanan Jaringan</td>
              <td>Pelatihan Advanced Cyber Security</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Siti Aminah</td>
              <td>654321</td>
              <td>Supervisor</td>
              <td>Manajemen</td>
              <td>5 Tahun</td>
              <td>Public Speaking</td>
              <td>Leadership & Communication</td>
            </tr>
            <!-- Data dari backend -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</body>
</html>
