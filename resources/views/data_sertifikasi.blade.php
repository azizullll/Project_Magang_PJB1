@extends('layouts/layout')

@section('title', 'Data Sertifikasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Data Sertifikasi') }}</h4>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCertificationModal">
                        <i class="fas fa-plus"></i> Tambah Sertifikasi
                    </button>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="expired">Expired</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterType">
                                <option value="">Semua Jenis</option>
                                <option value="professional">Professional</option>
                                <option value="technical">Technical</option>
                                <option value="safety">Safety</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari nama karyawan atau sertifikasi...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" onclick="applyFilters()">Filter</button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Jenis Sertifikasi</th>
                                    <th>Nama Sertifikasi</th>
                                    <th>Penyelenggara</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Status</th>
                                    <th>File Sertifikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td><span class="badge bg-primary">Professional</span></td>
                                    <td>Certified Java Developer</td>
                                    <td>Oracle Corporation</td>
                                    <td>2024-01-15</td>
                                    <td>2025-01-15</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editCertification(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCertification(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td><span class="badge bg-info">Technical</span></td>
                                    <td>Microsoft Azure Fundamentals</td>
                                    <td>Microsoft</td>
                                    <td>2023-06-01</td>
                                    <td>2024-06-01</td>
                                    <td><span class="badge bg-warning">Expired</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editCertification(2)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCertification(2)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mike Johnson</td>
                                    <td><span class="badge bg-success">Safety</span></td>
                                    <td>OSHA Safety Training</td>
                                    <td>OSHA Institute</td>
                                    <td>2024-03-10</td>
                                    <td>2025-03-10</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editCertification(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCertification(3)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
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
        </div>
    </div>
</div>

<!-- Add Certification Modal -->
<div class="modal fade" id="addCertificationModal" tabindex="-1" aria-labelledby="addCertificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificationModalLabel">Tambah Sertifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCertificationForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employeeName" class="form-label">Nama Karyawan</label>
                                <select class="form-select" id="employeeName" required>
                                    <option value="">Pilih Karyawan</option>
                                    <option value="1">John Doe</option>
                                    <option value="2">Jane Smith</option>
                                    <option value="3">Mike Johnson</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="certificationType" class="form-label">Jenis Sertifikasi</label>
                                <select class="form-select" id="certificationType" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="professional">Professional</option>
                                    <option value="technical">Technical</option>
                                    <option value="safety">Safety</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="certificationName" class="form-label">Nama Sertifikasi</label>
                                <input type="text" class="form-control" id="certificationName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organizer" class="form-label">Penyelenggara</label>
                                <input type="text" class="form-control" id="organizer" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="startDate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="endDate" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="certificateFile" class="form-label">File Sertifikat</label>
                        <input type="file" class="form-control" id="certificateFile" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    // Implement filter logic here
    console.log('Applying filters...');
}

function editCertification(id) {
    // Implement edit logic here
    console.log('Editing certification:', id);
}

function deleteCertification(id) {
    if (confirm('Apakah Anda yakin ingin menghapus sertifikasi ini?')) {
        // Implement delete logic here
        console.log('Deleting certification:', id);
    }
}

// Form submission
document.getElementById('addCertificationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Implement form submission logic here
    console.log('Submitting certification form...');
    // Close modal after successful submission
    // $('#addCertificationModal').modal('hide');
});
</script>
@endsection
