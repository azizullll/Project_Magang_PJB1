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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Form Tambah Sertifikasi
                    </h4>
                    <a href="{{ route('certifications.show', $employee->id) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
                <div class="card-body">
                    
                    <!-- Pilih Karyawan (non-editable) -->
                    <div class="mb-4">
                        <label for="employee_display" class="form-label">
                            <i class="fas fa-user me-1"></i>
                            Pilih Karyawan <span class="text-danger">*</span>
                        </label>
                        <select id="employee_display" class="form-select" disabled>
                            <option selected>{{ $employee->nip }} - {{ $employee->nama }} ({{ $employee->divisi }})</option>
                        </select>
                    </div>

                    <!-- Pilih Pelatihan (non-editable) -->
                    <div class="mb-4">
                        <label for="training_display" class="form-label">
                            <i class="fas fa-graduation-cap me-1"></i>
                            Pilih Pelatihan <span class="text-danger">*</span>
                        </label>
                        <select id="training_display" class="form-select" disabled>
                            <option selected>{{ $training->code }} - {{ $training->name }} (Level {{ $training->level }})</option>
                        </select>
                        <small class="form-text text-muted">
                            Pelatihan yang ditampilkan disesuaikan dengan jabatan <strong>{{ $employee->jabatan }}</strong>.
                        </small>
                    </div>

                    <form action="{{ route('certifications.updateTraining', [$employee->id, $training->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tanggal Diterbitkan -->
                        <div class="mb-4">
                            <label for="issued_date" class="form-label">
                                <i class="fas fa-calendar me-1"></i>
                                Tanggal Diterbitkan <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="issued_date" id="issued_date"
                                   class="form-control @error('issued_date') is-invalid @enderror"
                                   value="{{ old('issued_date', optional(\Carbon\Carbon::parse($pivot->issued_date))->toDateString()) }}" required>
                            @error('issued_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Kadaluarsa (otomatis) -->
                        <div class="mb-4" id="expirationInfo" style="display:none;">
                            <label class="form-label">
                                <i class="fas fa-calendar-times me-1"></i>
                                Tanggal Kadaluarsa (Otomatis)
                            </label>
                            <div class="alert alert-warning">
                                <strong>Berlaku hingga:</strong> <span id="calculatedExpiration">-</span>
                            </div>
                        </div>

                        <!-- Gambar Sertifikat -->
                        <div class="mb-4">
                            <label for="certificate_image" class="form-label">
                                <i class="fas fa-image me-1"></i>
                                Upload Gambar Sertifikat (Opsional)
                            </label>
                            <input type="file" name="certificate_image" id="certificate_image"
                                   class="form-control @error('certificate_image') is-invalid @enderror"
                                   accept="image/*">
                            <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</small>
                            @error('certificate_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($pivot->certificate_image)
                            <div class="mb-4">
                                <label class="form-label d-block">Sertifikat Saat Ini</label>
                                <img src="{{ asset('storage/' . $pivot->certificate_image) }}" alt="Sertifikat" class="img-fluid rounded" style="max-height: 240px;">
                                <div class="text-muted mt-2">Anda dapat mengunggah file baru untuk mengganti gambar ini.</div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('certifications.show', $employee->id) }}" class="btn btn-secondary">
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
    const issuedDateInput = document.getElementById('issued_date');
    const expirationInfo = document.getElementById('expirationInfo');
    const activeYears = {{ (int) ($training->certificate_active_years ?? 3) }};

    function calculateExpiration() {
        const issuedDate = issuedDateInput.value;
        if (!issuedDate) {
            expirationInfo.style.display = 'none';
            return;
        }
        const issued = new Date(issuedDate);
        const expiration = new Date(issued);
        expiration.setFullYear(expiration.getFullYear() + activeYears);

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('calculatedExpiration').textContent = expiration.toLocaleDateString('id-ID', options);
        expirationInfo.style.display = 'block';
    }

    issuedDateInput.addEventListener('change', calculateExpiration);
    calculateExpiration();
});
</script>


