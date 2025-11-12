@extends('layouts/layout')

@section('title', 'Edit Pelatihan')

@section('content')
<style>
    .main-content-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .content-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 30px;
    }

    .content-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        transition: all 0.2s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .error-message {
        color: #dc2626;
        font-size: 12px;
        margin-top: 5px;
    }

    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .checkbox-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
    }

    .checkbox-item label {
        font-size: 14px;
        color: #374151;
        cursor: pointer;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 30px 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }
</style>

<div class="main-content-card">
    <div class="content-header">
        <h2 class="content-title">Edit Data Pelatihan</h2>
        <p style="color: #6b7280; margin: 0;">Edit data pelatihan yang sudah ada</p>
    </div>

    <form action="{{ route('trainings.update', $training) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label for="code" class="form-label">Kode Pelatihan <span style="color: #dc2626;">*</span></label>
                <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror" 
                       value="{{ old('code', $training->code) }}" placeholder="Contoh: K3-001" required>
                @error('code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nama Pelatihan <span style="color: #dc2626;">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $training->name) }}" placeholder="Masukkan nama pelatihan" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category" class="form-label">Kategori <span style="color: #dc2626;">*</span></label>
                <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $training->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="level" class="form-label">Level Pelatihan <span style="color: #dc2626;">*</span></label>
                <select id="level" name="level" class="form-select @error('level') is-invalid @enderror" required>
                    <option value="">Pilih Level</option>
                    <option value="0" {{ old('level', $training->level) == 0 || old('level', $training->level) == '0' || old('level') == 'umum' ? 'selected' : '' }} data-level="0">Umum</option>
                    @for($i = 1; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ old('level', $training->level) == $i ? 'selected' : '' }} data-level="{{ $i }}">Level {{ $i }}</option>
                    @endfor
                </select>
                @error('level')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="section-title">Divisi & Jabatan Relevan</div>

        <div class="form-group">
            <label class="form-label">Divisi Relevan <span style="color: #dc2626;">*</span></label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="division_lingkungan" name="relevant_divisions[]" 
                           value="LINGKUNGAN" {{ in_array('LINGKUNGAN', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_lingkungan">LINGKUNGAN</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_sinfo" name="relevant_divisions[]" 
                           value="SINFO" {{ in_array('SINFO', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_sinfo">SINFO</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_inventory" name="relevant_divisions[]" 
                           value="INVENTORY" {{ in_array('INVENTORY', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_inventory">INVENTORY</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_sdm" name="relevant_divisions[]" 
                           value="SDM" {{ in_array('SDM', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_sdm">SDM</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_har" name="relevant_divisions[]" 
                           value="HAR" {{ in_array('HAR', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_har">HAR</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_engineering" name="relevant_divisions[]" 
                           value="ENGINEERING TO" {{ in_array('ENGINEERING TO', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_engineering">ENGINEERING TO</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_keuangan" name="relevant_divisions[]" 
                           value="KEUANGAN" {{ in_array('KEUANGAN', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_keuangan">KEUANGAN</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="division_sarana" name="relevant_divisions[]" 
                           value="SARANA" {{ in_array('SARANA', old('relevant_divisions', $training->relevant_divisions ?? [])) ? 'checked' : '' }}>
                    <label for="division_sarana">SARANA</label>
                </div>
            </div>
            @error('relevant_divisions')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Jabatan Relevan (Opsional)</label>
            <div class="checkbox-group" id="jobPositionsGroup">
                <div class="checkbox-item">
                    <input type="checkbox" id="job_manajer" name="relevant_job_positions[]" 
                           value="Manajer" {{ in_array('Manajer', old('relevant_job_positions', $training->relevant_job_positions ?? [])) ? 'checked' : '' }}>
                    <label for="job_manajer">Manajer</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="job_supervisor" name="relevant_job_positions[]" 
                           value="Supervisor(Asmen)" {{ in_array('Supervisor(Asmen)', old('relevant_job_positions', $training->relevant_job_positions ?? [])) ? 'checked' : '' }}>
                    <label for="job_supervisor">Supervisor(Asmen)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="job_staff" name="relevant_job_positions[]" 
                           value="Staff" {{ in_array('Staff', old('relevant_job_positions', $training->relevant_job_positions ?? [])) ? 'checked' : '' }}>
                    <label for="job_staff">Staff</label>
                </div>
            </div>
            <div style="margin-top:8px; font-size:12px; color:#6b7280;">Jabatan yang sama berlaku untuk semua divisi.</div>
            @error('relevant_job_positions')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="section-title">Detail Pelatihan</div>

        <div class="form-row-3">
            <div class="form-group">
                <label for="cost" class="form-label">Biaya Pelatihan</label>
                <input type="number" id="cost" name="cost" class="form-control @error('cost') is-invalid @enderror" 
                       value="{{ old('cost', $training->cost) }}" placeholder="0" min="0" step="0.01">
                @error('cost')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration_days" class="form-label">Durasi (Hari)</label>
                <input type="number" id="duration_days" name="duration_days" class="form-control @error('duration_days') is-invalid @enderror" 
                       value="{{ old('duration_days', $training->duration_days) }}" placeholder="0" min="0">
                @error('duration_days')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="certificate_active_years" class="form-label">Sertifikat Aktif Hingga (Tahun)</label>
                <input type="number" id="certificate_active_years" name="certificate_active_years" class="form-control @error('certificate_active_years') is-invalid @enderror" 
                       value="{{ old('certificate_active_years', $training->certificate_active_years) }}" placeholder="Contoh: 3" min="0">
                @error('certificate_active_years')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="institution" class="form-label">Lembaga Penyelenggara</label>
                <input type="text" id="institution" name="institution" class="form-control @error('institution') is-invalid @enderror" 
                       value="{{ old('institution', $training->institution) }}" placeholder="Nama lembaga penyelenggara">
                @error('institution')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="certification_code" class="form-label">Kode Sertifikasi</label>
                <input type="text" id="certification_code" name="certification_code" class="form-control @error('certification_code') is-invalid @enderror" 
                       value="{{ old('certification_code', $training->certification_code) }}" placeholder="Contoh: K3-CERT-004">
                @error('certification_code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="institution_phone" class="form-label">No. Telepon Lembaga</label>
                <input type="text" id="institution_phone" name="institution_phone" class="form-control @error('institution_phone') is-invalid @enderror" 
                       value="{{ old('institution_phone', $training->institution_phone) }}" placeholder="Contoh: 021-1234567">
                @error('institution_phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="institution_email" class="form-label">Email Lembaga</label>
                <input type="email" id="institution_email" name="institution_email" class="form-control @error('institution_email') is-invalid @enderror" 
                       value="{{ old('institution_email', $training->institution_email) }}" placeholder="email@lembaga.com">
                @error('institution_email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="institution_address" class="form-label">Alamat Lembaga</label>
            <input type="text" id="institution_address" name="institution_address" class="form-control @error('institution_address') is-invalid @enderror" 
                   value="{{ old('institution_address', $training->institution_address) }}" placeholder="Alamat lengkap lembaga">
            @error('institution_address')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="competencies_gained" class="form-label">Kompetensi yang Didapat</label>
            <textarea id="competencies_gained" name="competencies_gained" class="form-control @error('competencies_gained') is-invalid @enderror" 
                      rows="3" placeholder="Jelaskan kompetensi yang akan didapat dari pelatihan ini">{{ old('competencies_gained', $training->competencies_gained) }}</textarea>
            @error('competencies_gained')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="next_competencies" class="form-label">Kompetensi Lanjutan</label>
            <textarea id="next_competencies" name="next_competencies" class="form-control @error('next_competencies') is-invalid @enderror" 
                      rows="3" placeholder="Jelaskan kompetensi lanjutan yang bisa diikuti setelah pelatihan ini">{{ old('next_competencies', $training->next_competencies) }}</textarea>
            @error('next_competencies')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi Pelatihan</label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="4" placeholder="Deskripsi lengkap tentang pelatihan">{{ old('description', $training->description) }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Data
            </button>
            <a href="{{ route('trainings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = '#dc2626';
            } else {
                input.style.borderColor = '#e5e7eb';
            }
        });
        
        // Check if at least one division is selected
        const divisionCheckboxes = form.querySelectorAll('input[name="relevant_divisions[]"]');
        const isDivisionSelected = Array.from(divisionCheckboxes).some(cb => cb.checked);
        
        if (!isDivisionSelected) {
            isValid = false;
            alert('Pilih minimal satu divisi yang relevan.');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
});
</script>
<script>
// Level restrictions based on job positions
document.addEventListener('DOMContentLoaded', function() {
    const levelSelect = document.getElementById('level');
    const jobCheckboxes = Array.from(document.querySelectorAll('input[name="relevant_job_positions[]"]'));
    const levelOptions = Array.from(levelSelect.querySelectorAll('option'));

    function updateLevelOptions() {
        const selectedJobs = jobCheckboxes.filter(cb => cb.checked).map(cb => cb.value);
        
        // Reset all options
        levelOptions.forEach(option => {
            option.style.display = '';
            option.disabled = false;
        });

        if (selectedJobs.length === 0) {
            // If no job selected, show all levels
            return;
        }

        // Define level restrictions
        const restrictions = {
            'Manajer': [], // Can access all levels (0-7)
            'Supervisor(Asmen)': ['0', '1', '2', '3', '4'], // Umum + Level 1-4
            'Staff': ['0', '1', '2'] // Umum + Level 1-2
        };

        // Get allowed levels based on selected jobs
        let allowedLevels = new Set();
        selectedJobs.forEach(job => {
            if (restrictions[job]) {
                restrictions[job].forEach(level => allowedLevels.add(level));
            } else {
                // If job not in restrictions, allow all levels
                levelOptions.forEach(option => {
                    if (option.value !== '') allowedLevels.add(option.value);
                });
            }
        });

        // If Manajer is selected, allow all levels
        if (selectedJobs.includes('Manajer')) {
            levelOptions.forEach(option => {
                if (option.value !== '') allowedLevels.add(option.value);
            });
        }

        // Hide/disable options not allowed
        levelOptions.forEach(option => {
            if (option.value === '') return; // Keep "Pilih Level" option
            
            if (!allowedLevels.has(option.value)) {
                option.style.display = 'none';
                option.disabled = true;
            }
        });

        // If current selection is not allowed, reset it
        if (levelSelect.value && !allowedLevels.has(levelSelect.value)) {
            levelSelect.value = '';
        }
    }

    // Add event listeners
    jobCheckboxes.forEach(cb => cb.addEventListener('change', updateLevelOptions));
    
    // Run on page load
    updateLevelOptions();
});
</script>
@endsection
