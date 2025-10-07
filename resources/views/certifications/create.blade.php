@extends('layouts.layout')

@section('title', 'Tambah Karyawan ke Pelatihan')

@section('content')
<div class="page-header">
    <h1>Tambah Karyawan ke Pelatihan</h1>
</div>

<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Form Tambah Sertifikasi
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data" id="certificationForm">
                        @csrf
                        
                        <!-- Employee Selection -->
                        <div class="mb-4">
                            <label for="employee_id" class="form-label">
                                <i class="fas fa-user me-1"></i>
                                Pilih Karyawan <span class="text-danger">*</span>
                            </label>
                            <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" 
                                            {{ old('employee_id', request('employee_id')) == $employee->id ? 'selected' : '' }}
                                            data-divisi="{{ $employee->divisi }}"
                                            data-jabatan="{{ $employee->jabatan }}">
                                        {{ $employee->nip }} - {{ $employee->nama }} ({{ $employee->divisi }})
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Training Selection -->
                        <div class="mb-4">
                            <label for="training_id" class="form-label">
                                <i class="fas fa-graduation-cap me-1"></i>
                                Pilih Pelatihan <span class="text-danger">*</span>
                            </label>
                            <select name="training_id" id="training_id" class="form-select @error('training_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pelatihan --</option>
                                @foreach($trainings as $training)
                                    <option value="{{ $training->id }}" 
                                            {{ old('training_id') == $training->id ? 'selected' : '' }}
                                            data-code="{{ $training->code }}"
                                            data-name="{{ $training->name }}"
                                            data-level="{{ $training->level }}"
                                            data-competencies="{{ $training->competencies_gained }}"
                                            data-institution="{{ $training->institution }}"
                                            data-active-years="{{ $training->certificate_active_years }}">
                                        {{ $training->code }} - {{ $training->name }} (Level {{ $training->level }})
                                    </option>
                                @endforeach
                            </select>
                            @error('training_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Training Details (Auto-filled) -->
                        <div class="row mb-4" id="trainingDetails" style="display: none;">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-1"></i> Detail Pelatihan:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Kode:</strong> <span id="detailCode">-</span><br>
                                            <strong>Nama:</strong> <span id="detailName">-</span><br>
                                            <strong>Level:</strong> <span id="detailLevel">-</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Lembaga:</strong> <span id="detailInstitution">-</span><br>
                                            <strong>Masa Aktif:</strong> <span id="detailActiveYears">-</span> tahun<br>
                                            <strong>Kompetensi:</strong> <span id="detailCompetencies">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Certificate Issue Date -->
                        <div class="mb-4">
                            <label for="issued_date" class="form-label">
                                <i class="fas fa-calendar me-1"></i>
                                Tanggal Diterbitkan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="issued_date" id="issued_date" 
                                   class="form-control @error('issued_date') is-invalid @enderror" 
                                   value="{{ old('issued_date') }}" required>
                            @error('issued_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Calculated Expiration Date -->
                        <div class="mb-4" id="expirationInfo" style="display: none;">
                            <label class="form-label">
                                <i class="fas fa-calendar-times me-1"></i>
                                Tanggal Kadaluarsa (Otomatis)
                            </label>
                            <div class="alert alert-warning">
                                <strong>Berlaku hingga:</strong> <span id="calculatedExpiration">-</span>
                            </div>
                        </div>

                        <!-- Certificate Image Upload -->
                        <div class="mb-4">
                            <label for="certificate_image" class="form-label">
                                <i class="fas fa-image me-1"></i>
                                Upload Gambar Sertifikat (Opsional)
                            </label>
                            <input type="file" name="certificate_image" id="certificate_image" 
                                   class="form-control @error('certificate_image') is-invalid @enderror"
                                   accept="image/*">
                            <small class="form-text text-muted">
                                Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                            </small>
                            @error('certificate_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('certifications.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Simpan Sertifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trainingSelect = document.getElementById('training_id');
    const issuedDateInput = document.getElementById('issued_date');
    const trainingDetails = document.getElementById('trainingDetails');
    const expirationInfo = document.getElementById('expirationInfo');

    // Show training details when training is selected
    trainingSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            // Update detail fields
            document.getElementById('detailCode').textContent = selectedOption.dataset.code || '-';
            document.getElementById('detailName').textContent = selectedOption.dataset.name || '-';
            document.getElementById('detailLevel').textContent = selectedOption.dataset.level || '-';
            document.getElementById('detailInstitution').textContent = selectedOption.dataset.institution || '-';
            document.getElementById('detailActiveYears').textContent = selectedOption.dataset.activeYears || '3';
            document.getElementById('detailCompetencies').textContent = selectedOption.dataset.competencies || '-';
            
            trainingDetails.style.display = 'block';
            
            // Calculate expiration if issued date is already filled
            calculateExpiration();
        } else {
            trainingDetails.style.display = 'none';
            expirationInfo.style.display = 'none';
        }
    });

    // Calculate expiration date when issued date changes
    issuedDateInput.addEventListener('change', calculateExpiration);

    function calculateExpiration() {
        const selectedTraining = trainingSelect.options[trainingSelect.selectedIndex];
        const issuedDate = issuedDateInput.value;
        
        if (selectedTraining.value && issuedDate) {
            const activeYears = parseInt(selectedTraining.dataset.activeYears) || 3;
            const issued = new Date(issuedDate);
            const expiration = new Date(issued);
            expiration.setFullYear(expiration.getFullYear() + activeYears);
            
            // Format date to Indonesian format
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const formattedExpiration = expiration.toLocaleDateString('id-ID', options);
            
            document.getElementById('calculatedExpiration').textContent = formattedExpiration;
            expirationInfo.style.display = 'block';
        } else {
            expirationInfo.style.display = 'none';
        }
    }

    // Trigger change event if training is already selected (for editing)
    if (trainingSelect.value) {
        trainingSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
