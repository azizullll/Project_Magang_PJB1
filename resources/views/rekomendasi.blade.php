@extends('layouts/layout')

@section('title', 'Rekomendasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Rekomendasi Pelatihan') }}</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateRecommendationModal">
                        <i class="fas fa-magic"></i> Generate Rekomendasi
                    </button>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <select class="form-select" id="filterDepartment">
                                <option value="">Semua Departemen</option>
                                <option value="it">IT</option>
                                <option value="hr">HR</option>
                                <option value="finance">Finance</option>
                                <option value="marketing">Marketing</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterPriority">
                                <option value="">Semua Prioritas</option>
                                <option value="high">Tinggi</option>
                                <option value="medium">Sedang</option>
                                <option value="low">Rendah</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari nama karyawan atau pelatihan...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" onclick="applyFilters()">Filter</button>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">24</h4>
                                            <p class="mb-0">Total Rekomendasi</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-lightbulb fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">8</h4>
                                            <p class="mb-0">Prioritas Tinggi</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">12</h4>
                                            <p class="mb-0">Sedang Berjalan</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-play-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">4</h4>
                                            <p class="mb-0">Selesai</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Departemen</th>
                                    <th>Jenis Pelatihan</th>
                                    <th>Nama Pelatihan</th>
                                    <th>Prioritas</th>
                                    <th>Alasan Rekomendasi</th>
                                    <th>Status</th>
                                    <th>Tanggal Rekomendasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>IT</td>
                                    <td><span class="badge bg-primary">Technical</span></td>
                                    <td>Advanced JavaScript Development</td>
                                    <td><span class="badge bg-danger">Tinggi</span></td>
                                    <td>Kemampuan JavaScript perlu ditingkatkan untuk proyek baru</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="approveRecommendation(1)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editRecommendation(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="rejectRecommendation(1)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>HR</td>
                                    <td><span class="badge bg-info">Soft Skills</span></td>
                                    <td>Leadership & Team Management</td>
                                    <td><span class="badge bg-warning">Sedang</span></td>
                                    <td>Dipromosikan ke posisi manajer, perlu skill leadership</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>2024-01-10</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewDetails(2)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editRecommendation(2)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mike Johnson</td>
                                    <td>Finance</td>
                                    <td><span class="badge bg-success">Certification</span></td>
                                    <td>CPA Certification Preparation</td>
                                    <td><span class="badge bg-danger">Tinggi</span></td>
                                    <td>Persyaratan untuk posisi senior accountant</td>
                                    <td><span class="badge bg-primary">In Progress</span></td>
                                    <td>2024-01-05</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewDetails(3)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editRecommendation(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Sarah Wilson</td>
                                    <td>Marketing</td>
                                    <td><span class="badge bg-primary">Technical</span></td>
                                    <td>Digital Marketing Analytics</td>
                                    <td><span class="badge bg-success">Rendah</span></td>
                                    <td>Meningkatkan kemampuan analisis data marketing</td>
                                    <td><span class="badge bg-secondary">Completed</span></td>
                                    <td>2023-12-20</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewDetails(4)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="viewCertificate(4)">
                                            <i class="fas fa-certificate"></i>
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

<!-- Generate Recommendation Modal -->
<div class="modal fade" id="generateRecommendationModal" tabindex="-1" aria-labelledby="generateRecommendationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateRecommendationModalLabel">Generate Rekomendasi Pelatihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="generateRecommendationForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employeeSelect" class="form-label">Pilih Karyawan</label>
                                <select class="form-select" id="employeeSelect" required>
                                    <option value="">Pilih Karyawan</option>
                                    <option value="all">Semua Karyawan</option>
                                    <option value="1">John Doe</option>
                                    <option value="2">Jane Smith</option>
                                    <option value="3">Mike Johnson</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="departmentSelect" class="form-label">Departemen</label>
                                <select class="form-select" id="departmentSelect">
                                    <option value="">Semua Departemen</option>
                                    <option value="it">IT</option>
                                    <option value="hr">HR</option>
                                    <option value="finance">Finance</option>
                                    <option value="marketing">Marketing</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trainingType" class="form-label">Jenis Pelatihan</label>
                                <select class="form-select" id="trainingType">
                                    <option value="">Semua Jenis</option>
                                    <option value="technical">Technical</option>
                                    <option value="soft-skills">Soft Skills</option>
                                    <option value="certification">Certification</option>
                                    <option value="leadership">Leadership</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priorityLevel" class="form-label">Level Prioritas</label>
                                <select class="form-select" id="priorityLevel">
                                    <option value="">Semua Level</option>
                                    <option value="high">Tinggi</option>
                                    <option value="medium">Sedang</option>
                                    <option value="low">Rendah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="criteria" class="form-label">Kriteria Rekomendasi</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="performance" id="performanceCheck" checked>
                            <label class="form-check-label" for="performanceCheck">
                                Berdasarkan Performance Review
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="skills" id="skillsCheck" checked>
                            <label class="form-check-label" for="skillsCheck">
                                Gap Analysis Skills
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="career" id="careerCheck">
                            <label class="form-check-label" for="careerCheck">
                                Career Development Plan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="certification" id="certificationCheck">
                            <label class="form-check-label" for="certificationCheck">
                                Sertifikasi yang Diperlukan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-magic"></i> Generate Rekomendasi
                    </button>
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

function approveRecommendation(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui rekomendasi ini?')) {
        // Implement approve logic here
        console.log('Approving recommendation:', id);
    }
}

function rejectRecommendation(id) {
    if (confirm('Apakah Anda yakin ingin menolak rekomendasi ini?')) {
        // Implement reject logic here
        console.log('Rejecting recommendation:', id);
    }
}

function editRecommendation(id) {
    // Implement edit logic here
    console.log('Editing recommendation:', id);
}

function viewDetails(id) {
    // Implement view details logic here
    console.log('Viewing details for recommendation:', id);
}

function viewCertificate(id) {
    // Implement view certificate logic here
    console.log('Viewing certificate for recommendation:', id);
}

// Form submission
document.getElementById('generateRecommendationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Implement form submission logic here
    console.log('Generating recommendations...');
    // Close modal after successful submission
    // $('#generateRecommendationModal').modal('hide');
});
</script>
@endsection
