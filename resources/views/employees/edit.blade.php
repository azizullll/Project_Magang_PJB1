@extends('layouts/layout')

@section('title', 'Edit Karyawan')

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

    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
        margin-top: 10px;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .file-input-label:hover {
        background: #e5e7eb;
    }

    .current-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
        margin-top: 10px;
    }
</style>

<div class="main-content-card">
    <div class="content-header">
        <h2 class="content-title">Edit Data Karyawan</h2>
        <p style="color: #6b7280; margin: 0;">Ubah data karyawan: <strong>{{ $employee->nama }}</strong></p>
    </div>

    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label for="nip" class="form-label">NIP <span style="color: #dc2626;">*</span></label>
                <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror" 
                       value="{{ old('nip', $employee->nip) }}" placeholder="Masukkan NIP karyawan" required>
                @error('nip')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                       value="{{ old('nama', $employee->nama) }}" placeholder="Masukkan nama lengkap" required>
                @error('nama')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $employee->email) }}" placeholder="Masukkan email karyawan">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_telp" class="form-label">No. Telepon</label>
                <input type="text" id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" 
                       value="{{ old('no_telp', $employee->no_telp) }}" placeholder="Masukkan nomor telepon">
                @error('no_telp')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                      rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat', $employee->alamat) }}</textarea>
            @error('alamat')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jabatan" class="form-label">Jabatan <span style="color: #dc2626;">*</span></label>
                <select id="jabatan" name="jabatan" class="form-select @error('jabatan') is-invalid @enderror" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Manager" {{ old('jabatan', $employee->jabatan) == 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Supervisor" {{ old('jabatan', $employee->jabatan) == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="Staff" {{ old('jabatan', $employee->jabatan) == 'Staff' ? 'selected' : '' }}>Staff</option>
                    <option value="Operator" {{ old('jabatan', $employee->jabatan) == 'Operator' ? 'selected' : '' }}>Operator</option>
                    <option value="Technician" {{ old('jabatan', $employee->jabatan) == 'Technician' ? 'selected' : '' }}>Technician</option>
                    <option value="Engineer" {{ old('jabatan', $employee->jabatan) == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                    <option value="Analyst" {{ old('jabatan', $employee->jabatan) == 'Analyst' ? 'selected' : '' }}>Analyst</option>
                    <option value="Coordinator" {{ old('jabatan', $employee->jabatan) == 'Coordinator' ? 'selected' : '' }}>Coordinator</option>
                    <option value="Specialist" {{ old('jabatan', $employee->jabatan) == 'Specialist' ? 'selected' : '' }}>Specialist</option>
                    <option value="Assistant" {{ old('jabatan', $employee->jabatan) == 'Assistant' ? 'selected' : '' }}>Assistant</option>
                </select>
                @error('jabatan')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="divisi" class="form-label">Divisi <span style="color: #dc2626;">*</span></label>
                <select id="divisi" name="divisi" class="form-select @error('divisi') is-invalid @enderror">
                    <option value="">Pilih Divisi</option>
                    <option value="IT" {{ old('divisi', $employee->divisi) == 'IT' ? 'selected' : '' }}>IT</option>
                    <option value="HR" {{ old('divisi', $employee->divisi) == 'HR' ? 'selected' : '' }}>HR</option>
                    <option value="Finance" {{ old('divisi', $employee->divisi) == 'Finance' ? 'selected' : '' }}>Finance</option>
                    <option value="Marketing" {{ old('divisi', $employee->divisi) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Operations" {{ old('divisi', $employee->divisi) == 'Operations' ? 'selected' : '' }}>Operations</option>
                    <option value="Maintenance" {{ old('divisi', $employee->divisi) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="Production" {{ old('divisi', $employee->divisi) == 'Production' ? 'selected' : '' }}>Production</option>
                    <option value="Quality Control" {{ old('divisi', $employee->divisi) == 'Quality Control' ? 'selected' : '' }}>Quality Control</option>
                </select>
                @error('divisi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="masa_kerja_tahun" class="form-label">Masa Kerja (Tahun) <span style="color: #dc2626;">*</span></label>
                <input type="number" id="masa_kerja_tahun" name="masa_kerja_tahun" class="form-control @error('masa_kerja_tahun') is-invalid @enderror" 
                       value="{{ old('masa_kerja_tahun', $employee->masa_kerja_tahun) }}" placeholder="0" min="0" required>
                @error('masa_kerja_tahun')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="level_kompetensi" class="form-label">Level Kompetensi (opsional)</label>
                <select id="level_kompetensi" name="level_kompetensi" class="form-select @error('level_kompetensi') is-invalid @enderror">
                    <option value="">Otomatis dari masa kerja</option>
                    @php($levels = ['Pemula','Terampil','Ahli Muda','Ahli Madya'])
                    @foreach($levels as $lv)
                        <option value="{{ $lv }}" {{ old('level_kompetensi', $employee->level_kompetensi) == $lv ? 'selected' : '' }}>{{ $lv }}</option>
                    @endforeach
                </select>
                @error('level_kompetensi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
        </div>

        <div class="form-group">
            <label for="foto" class="form-label">Foto Profil</label>
            
            @if($employee->foto_path)
                <div style="margin-bottom: 10px;">
                    <p style="font-size: 12px; color: #6b7280; margin: 0 0 5px 0;">Foto saat ini:</p>
                    <img src="{{ asset('storage/'.$employee->foto_path) }}" alt="Current Avatar" class="current-avatar">
                </div>
            @endif
            
            <div class="file-input-wrapper">
                <input type="file" id="foto" name="foto" class="file-input" accept="image/*" onchange="previewImage(this)">
                <label for="foto" class="file-input-label">
                    <i class="fas fa-camera"></i>
                    {{ $employee->foto_path ? 'Ganti Foto' : 'Pilih Foto' }}
                </label>
            </div>
            <img id="avatarPreview" class="avatar-preview" style="display: none;" alt="Preview">
            @error('foto')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Certificates Section -->
        <div class="certificates-section" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1f2937;">Sertifikasi</h3>
                <button type="button" onclick="addCertificate()" class="btn" style="background: #10b981; color: white; padding: 8px 16px; font-size: 12px;">
                    <i class="fas fa-plus"></i> Tambah Sertifikasi
                </button>
            </div>
            
            <div id="certificates-container">
                @if($employee->certifications->count() > 0)
                    @foreach($employee->certifications as $index => $cert)
                        <div class="certificate-entry" style="background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Sertifikasi {{ $index + 1 }}</h4>
                                <button type="button" onclick="removeCertificate(this)" class="btn" style="background: #ef4444; color: white; padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Kode Sertifikasi <span style="color: #dc2626;">*</span></label>
                                    <input type="text" name="certificates[{{ $index }}][code]" class="form-control" value="{{ $cert->code }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Nama Sertifikasi</label>
                                    <input type="text" name="certificates[{{ $index }}][name]" class="form-control" value="{{ $cert->name }}">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Diterbitkan</label>
                                    <input type="date" name="certificates[{{ $index }}][issued_date]" class="form-control" value="{{ $cert->pivot->issued_date }}">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Tanggal Berlaku Sampai</label>
                                    <input type="date" name="certificates[{{ $index }}][expiration_date]" class="form-control" value="{{ $cert->pivot->expiration_date }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Gambar Sertifikasi</label>
                                
                                @if($cert->pivot->certificate_image)
                                    <div style="margin-bottom: 10px;">
                                        <p style="font-size: 12px; color: #6b7280; margin: 0 0 5px 0;">Gambar sertifikasi saat ini:</p>
                                        <img src="{{ asset('storage/'.$cert->pivot->certificate_image) }}" alt="Current Certificate" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                                    </div>
                                @endif
                                
                                <div class="file-input-wrapper">
                                    <input type="file" name="certificates[{{ $index }}][image]" class="file-input" accept="image/*" onchange="previewCertificateImageAtIndex(this, {{ $index }})">
                                    <label class="file-input-label">
                                        <i class="fas fa-certificate"></i>
                                        {{ $cert->pivot->certificate_image ? 'Ganti Gambar Sertifikasi' : 'Pilih Gambar Sertifikasi' }}
                                    </label>
                                </div>
                                <small style="color: #6b7280; font-size: 12px; margin-top: 5px; display: block;">Opsional - Upload gambar sertifikasi jika tersedia</small>
                                <img id="certificatePreview{{ $index }}" style="display: none; width: 150px; height: 100px; object-fit: cover; border-radius: 8px; margin-top: 10px;" alt="Certificate Preview">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Data
            </button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('avatarPreview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

function previewCertificateImage(input) {
    const preview = document.getElementById('certificatePreview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

// Certificate management functions
let certificateIndex = {{ $employee->certifications->count() }};

function addCertificate() {
    const container = document.getElementById('certificates-container');
    const certificateHtml = `
        <div class="certificate-entry" style="background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Sertifikasi ${certificateIndex + 1}</h4>
                <button type="button" onclick="removeCertificate(this)" class="btn" style="background: #ef4444; color: white; padding: 4px 8px; font-size: 12px;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kode Sertifikasi <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="certificates[${certificateIndex}][code]" class="form-control" placeholder="Contoh: K3-001" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Sertifikasi</label>
                    <input type="text" name="certificates[${certificateIndex}][name]" class="form-control" placeholder="Contoh: K3 Umum">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Diterbitkan</label>
                    <input type="date" name="certificates[${certificateIndex}][issued_date]" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tanggal Berlaku Sampai</label>
                    <input type="date" name="certificates[${certificateIndex}][expiration_date]" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar Sertifikasi</label>
                <div class="file-input-wrapper">
                    <input type="file" name="certificates[${certificateIndex}][image]" class="file-input" accept="image/*" onchange="previewCertificateImageAtIndex(this, ${certificateIndex})">
                    <label class="file-input-label">
                        <i class="fas fa-certificate"></i>
                        Pilih Gambar Sertifikasi
                    </label>
                </div>
                <small style="color: #6b7280; font-size: 12px; margin-top: 5px; display: block;">Opsional - Upload gambar sertifikasi jika tersedia</small>
                <img id="certificatePreview${certificateIndex}" style="display: none; width: 150px; height: 100px; object-fit: cover; border-radius: 8px; margin-top: 10px;" alt="Certificate Preview">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', certificateHtml);
    certificateIndex++;
}

function removeCertificate(button) {
    button.closest('.certificate-entry').remove();
}

function previewCertificateImageAtIndex(input, index) {
    const preview = document.getElementById(`certificatePreview${index}`);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

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
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
});
</script>
@endsection
