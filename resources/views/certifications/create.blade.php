@extends('layouts.layout')

@section('title', 'Tambah Karyawan ke Pelatihan')

@section('content')
<div class="page-header">
    <h1>Tambah Karyawan ke Pelatihan</h1>
</div>

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
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
                                @php
                                    // Define training levels based on job position
                                    function getTrainingLevelsForPosition($jabatan) {
                                        switch($jabatan) {
                                            case 'Staff':
                                                return [
                                                    'Umum' => [0, 1, 2],  // Umum level 0, 1-2
                                                    'Teknis' => [1, 2],
                                                    'Manajerial' => [1, 2],
                                                    'K3' => [1, 2],
                                                    'Softskill' => [1, 2]
                                                ];
                                            case 'Supervisor(Asmen)':
                                                return [
                                                    // Umum boleh semua level (termasuk 0)
                                                    'Umum' => array_merge([0], range(1, 7)),
                                                    // Selain Umum, hanya level 1-4
                                                    'Teknis' => [1, 2, 3, 4],
                                                    'Manajerial' => [1, 2, 3, 4],
                                                    'K3' => [1, 2, 3, 4],
                                                    'Softskill' => [1, 2, 3, 4]
                                                ];
                                            case 'Manajer':
                                                return [
                                                    'Umum' => array_merge([0], range(1, 7)),
                                                    'Teknis' => range(1, 7),
                                                    'Manajerial' => range(1, 7),
                                                    'K3' => range(1, 7),
                                                    'Softskill' => range(1, 7)
                                                ];
                                            default:
                                                return [];
                                        }
                                    }
                                @endphp
                                @foreach($trainings as $training)
                                    @php
                                        // Filter pelatihan berdasar jabatan, level, dan divisi.
                                        // - Level 0 (Umum): boleh untuk semua divisi. Level dibatasi oleh jabatan (Staff: 0,1-2, Asmen: 0,1-7, Manajer: semua)
                                        // - Non-Umum (level > 0): harus match divisi karyawan DAN level sesuai jabatan.
                                        $allowed = true;
                                        if ($selectedEmployee) {
                                            $position = $selectedEmployee->jabatan;
                                            $employeeDivision = $selectedEmployee->divisi;
                                            $trainingLevels = getTrainingLevelsForPosition($position);
                                            $categoryLevels = $trainingLevels[$training->category] ?? [];

                                            // Cek apakah pelatihan level 0 (Umum)
                                            $isGeneralTraining = ($training->level == 0 || $training->level === '0');

                                            if ($isGeneralTraining) {
                                                // Level 0 (Umum): divisi bebas, boleh untuk semua jabatan
                                                // Sesuai aturan: Staff (0,1-2), Supervisor (0,1-7), Manajer (semua)
                                                if ($position === 'Staff') {
                                                    // Staff: level 0 dan 1-2 diizinkan
                                                    $allowed = true; // Level 0 selalu diizinkan untuk Staff
                                                } elseif ($position === 'Supervisor(Asmen)') {
                                                    // Supervisor: level 0 dan 1-7 diizinkan
                                                    $allowed = true; // Level 0 selalu diizinkan untuk Supervisor
                                                } elseif ($position === 'Manajer') {
                                                    // Manajer: semua level diizinkan
                                                    $allowed = true;
                                                } else {
                                                    $allowed = false;
                                                }
                                            } else {
                                                // Non-Umum (level > 0): wajib levelEligible dan divisi cocok
                                                $levelEligible = empty($categoryLevels) ? false : in_array($training->level, $categoryLevels);
                                                
                                                $divisions = is_array($training->relevant_divisions ?? null)
                                                    ? ($training->relevant_divisions ?? [])
                                                    : (is_string($training->relevant_divisions ?? null)
                                                        ? array_filter(array_map('trim', explode(',', $training->relevant_divisions)))
                                                        : []);

                                                $divisionEligible = in_array($employeeDivision, $divisions);
                                                $allowed = $levelEligible && $divisionEligible;
                                            }
                                        }
                                    @endphp
                                    @if($allowed)
                                        <option value="{{ $training->id }}" 
                                                {{ old('training_id') == $training->id ? 'selected' : '' }}
                                                data-code="{{ $training->code }}"
                                                data-name="{{ $training->name }}"
                                                data-level="{{ $training->level }}"
                                                data-competencies="{{ $training->competencies_gained }}"
                                                data-institution="{{ $training->institution }}"
                                                data-active-years="{{ $training->certificate_active_years }}">
                                            {{ $training->code }} - {{ $training->name }} ({{ $training->level == 0 ? 'Umum' : 'Level ' . $training->level }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('training_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="duplicateAlert" class="alert alert-danger mt-2" style="display:none;">
                                Karyawan sudah memiliki sertifikat pelatihan ini.
                            </div>
                            @if($selectedEmployee)
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pelatihan yang ditampilkan disesuaikan dengan jabatan <strong>{{ $selectedEmployee->jabatan }}</strong>:
                                    @if($selectedEmployee->jabatan == 'Staff')
                                        Pelatihan Umum (Level 0) + Level 1-2
                                    @elseif($selectedEmployee->jabatan == 'Supervisor(Asmen)')
                                        Pelatihan Umum (Level 0) + Level 1-7
                                    @elseif($selectedEmployee->jabatan == 'Manajer')
                                        Semua Pelatihan (Level 0 + 1-7)
                                    @endif
                                </small>
                            @else
                                <small class="form-text text-muted">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Pilih karyawan terlebih dahulu untuk melihat pelatihan yang sesuai jabatannya.
                                </small>
                            @endif
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
    const employeeSelect = document.getElementById('employee_id');
    const trainingSelect = document.getElementById('training_id');
    const issuedDateInput = document.getElementById('issued_date');
    const trainingDetails = document.getElementById('trainingDetails');
    const expirationInfo = document.getElementById('expirationInfo');
    const duplicateAlert = document.getElementById('duplicateAlert');
    const submitButton = document.querySelector('#certificationForm button[type="submit"]');

    // Existing trainings for selected employee (ids)
    const existingTrainingIds = @json(($selectedEmployee ? $selectedEmployee->trainings->pluck('id') : collect())->values());

    // Get training levels based on position
    function getTrainingLevelsForPosition(jabatan) {
        switch(jabatan) {
            case 'Staff':
                return {
                    'Umum': [0, 1, 2],  // Umum level 0, 1-2
                    'Teknis': [1, 2],
                    'Manajerial': [1, 2],
                    'K3': [1, 2],
                    'Softskill': [1, 2]
                };
            case 'Supervisor(Asmen)':
                return {
                    // Umum: semua level diperbolehkan (termasuk 0)
                    'Umum': [0, 1, 2, 3, 4, 5, 6, 7],
                    // Selain Umum: hanya level 1-4
                    'Teknis': [1, 2, 3, 4],
                    'Manajerial': [1, 2, 3, 4],
                    'K3': [1, 2, 3, 4],
                    'Softskill': [1, 2, 3, 4]
                };
            case 'Manajer':
                return {
                    'Umum': [0, 1, 2, 3, 4, 5, 6, 7],
                    'Teknis': [1, 2, 3, 4, 5, 6, 7],
                    'Manajerial': [1, 2, 3, 4, 5, 6, 7],
                    'K3': [1, 2, 3, 4, 5, 6, 7],
                    'Softskill': [1, 2, 3, 4, 5, 6, 7]
                };
            default:
                return {};
        }
    }

    // Filter trainings when employee is selected
    employeeSelect.addEventListener('change', function() {
        const selectedEmployee = this.options[this.selectedIndex];
        const jabatan = selectedEmployee.dataset.jabatan || '';
        
        // Reload page with employee_id to filter trainings
        if (selectedEmployee.value) {
            window.location.href = '{{ route("certifications.create") }}?employee_id=' + selectedEmployee.value;
        } else {
            window.location.href = '{{ route("certifications.create") }}';
        }
    });

    // Show training details when training is selected and prevent duplicates
    trainingSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const selectedId = parseInt(selectedOption.value, 10);
            const isDuplicate = Array.isArray(existingTrainingIds) && existingTrainingIds.includes(selectedId);

            if (isDuplicate) {
                // Show alert and block submission
                duplicateAlert.style.display = 'block';
                submitButton.disabled = true;
                trainingDetails.style.display = 'none';
                expirationInfo.style.display = 'none';
                return;
            } else {
                duplicateAlert.style.display = 'none';
                submitButton.disabled = false;
            }
            // Update detail fields
            document.getElementById('detailCode').textContent = selectedOption.dataset.code || '-';
            document.getElementById('detailName').textContent = selectedOption.dataset.name || '-';
            const level = selectedOption.dataset.level || '-';
            document.getElementById('detailLevel').textContent = (level == 0 || level === '0') ? 'Umum' : 'Level ' + level;
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
