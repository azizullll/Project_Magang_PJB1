@extends('layouts.layout')

@section('title', 'Perpanjang Sertifikasi - ' . $employee->nama)

@section('content')
<div class="page-header">
    <h1>Perpanjang Sertifikasi - {{ $employee->nama }}</h1>
</div>

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Form Perpanjang Sertifikasi
                    </h4>
                    <a href="{{ route('certifications.show', $employee->id) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
                <div class="card-body">
                    
                    <!-- Info Karyawan & Pelatihan (read-only) -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Karyawan:</strong> {{ $employee->nip }} - {{ $employee->nama }}</div>
                                <div class="mb-2"><strong>Divisi:</strong> {{ $employee->divisi }}</div>
                                <div class="mb-2"><strong>Jabatan:</strong> {{ $employee->jabatan }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Pelatihan:</strong> {{ $training->code }} - {{ $training->name }}</div>
                                <div class="mb-2"><strong>Level:</strong> {{ $training->level }}</div>
                                <div class="mb-2"><strong>Lembaga:</strong> {{ $training->institution ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('certifications.updateRenew', [$employee->id, $training->id]) }}" method="POST">
                        @csrf

                        <!-- Tanggal Diterbitkan (read-only info) -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-calendar me-1"></i>
                                Tanggal Diterbitkan
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($pivot->issued_date)->format('d/m/Y') }}" 
                                   disabled>
                            <small class="text-muted">Tanggal diterbitkan tidak dapat diubah.</small>
                        </div>

                        <!-- Tanggal Kadaluarsa Saat Ini (read-only info) -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-calendar-times me-1"></i>
                                Tanggal Kadaluarsa Saat Ini
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($pivot->expiration_date)->format('d/m/Y') }}" 
                                   disabled>
                        </div>

                         <!-- Tanggal Perpanjangan Sertifikasi (editable) -->
                         <div class="mb-4">
                             <label for="new_issued_date" class="form-label">
                                 <i class="fas fa-calendar-plus me-1"></i>
                                 Tanggal Perpanjangan Sertifikasi <span class="text-danger">*</span>
                             </label>
                             <input type="date" name="new_issued_date" id="new_issued_date"
                                    class="form-control @error('new_issued_date') is-invalid @enderror"
                                    value="{{ old('new_issued_date', \Carbon\Carbon::parse($pivot->expiration_date)->toDateString()) }}" 
                                    required>
                             @error('new_issued_date')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                             <small class="form-text text-muted">
                                 Masukkan tanggal untuk perpanjangan sertifikasi.
                             </small>
                         </div>

                         <!-- Info Tanggal Kadaluarsa (otomatis dihitung) -->
                         <div class="mb-4" id="expirationInfo">
                             <label class="form-label">
                                 <i class="fas fa-calendar-times me-1"></i>
                                 Tanggal Kadaluarsa (Otomatis)
                             </label>
                             <div class="alert alert-warning">
                                 <strong>Berlaku hingga:</strong> <span id="calculatedExpiration">-</span>
                             </div>
                         </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('certifications.show', $employee->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Simpan Perpanjangan
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
    const newIssuedDateInput = document.getElementById('new_issued_date');
    const expirationInfo = document.getElementById('expirationInfo');
    const activeYears = {{ (int) ($training->certificate_active_years ?? 3) }};

    function calculateExpiration() {
        const issuedDate = newIssuedDateInput.value;
        if (!issuedDate) {
            expirationInfo.style.display = 'none';
            return;
        }
        const issued = new Date(issuedDate);
        const expiration = new Date(issued);
        expiration.setFullYear(expiration.getFullYear() + activeYears);
        
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        document.getElementById('calculatedExpiration').textContent = expiration.toLocaleDateString('id-ID', options);
        expirationInfo.style.display = 'block';
    }

    newIssuedDateInput.addEventListener('change', calculateExpiration);
    calculateExpiration();
});
</script>
@endsection

