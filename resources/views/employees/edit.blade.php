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
                <label for="divisi" class="form-label">Divisi <span style="color: #dc2626;">*</span></label>
                <select id="divisi" name="divisi" class="form-select @error('divisi') is-invalid @enderror" required onchange="loadJobPositions()">
                    <option value="">Pilih Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ old('divisi', $employee->divisi) == $division->name ? 'selected' : '' }}>{{ $division->name }}</option>
                    @endforeach
                </select>
                @error('divisi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jabatan" class="form-label">Jabatan <span style="color: #dc2626;">*</span></label>
                <select id="jabatan" name="jabatan" class="form-select @error('jabatan') is-invalid @enderror" required onchange="loadCompetencyLevel()">
                    <option value="">Pilih Divisi terlebih dahulu</option>
                </select>
                @error('jabatan')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="masa_kerja_tahun" class="form-label">Masa Kerja (Tahun) <span style="color: #dc2626;">*</span></label>
                <input type="number" id="masa_kerja_tahun" name="masa_kerja_tahun" class="form-control @error('masa_kerja_tahun') is-invalid @enderror" 
                       value="{{ old('masa_kerja_tahun', $employee->masa_kerja_tahun) }}" placeholder="0" min="0" required>
                @error('masa_kerja_tahun')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="level_kompetensi" class="form-label">Level Kompetensi</label>
                <select id="level_kompetensi" name="level_kompetensi" class="form-select @error('level_kompetensi') is-invalid @enderror">
                    <option value="">Otomatis dari jabatan</option>
                    @foreach($competencyLevels as $level)
                        <option value="{{ $level->name }}" {{ old('level_kompetensi', $employee->level_kompetensi) == $level->name ? 'selected' : '' }}>Level {{ $level->level }} - {{ $level->name }}</option>
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
                                <div class="form-group" style="position: relative;">
                                    <label class="form-label">Kode Sertifikasi <span style="color: #dc2626;">*</span></label>
                                    <input type="text" name="certificates[{{ $index }}][code]" class="form-control cert-code-input" data-index="{{ $index }}" value="{{ $cert->code }}" autocomplete="off" required>
                                    <div class="cert-suggestions" data-index="{{ $index }}" style="position:absolute; top: 70px; left:0; right:0; background:white; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,.08); z-index:50; display:none; max-height: 180px; overflow:auto;"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Nama Sertifikasi</label>
                                    <input type="text" name="certificates[{{ $index }}][name]" class="form-control cert-name-input" data-index="{{ $index }}" value="{{ $cert->name }}">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Diterbitkan</label>
                                    <input type="date" name="certificates[{{ $index }}][issued_date]" class="form-control cert-issued-input" data-index="{{ $index }}" value="{{ $cert->pivot->issued_date }}">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Aktif Hingga (Tahun)</label>
                                    <input type="number" name="certificates[{{ $index }}][active_years]" class="form-control cert-years-input" data-index="{{ $index }}" placeholder="Contoh: 3" min="0" readonly>
                                    <input type="hidden" name="certificates[{{ $index }}][expiration_date]" class="cert-expiration-hidden" data-index="{{ $index }}" value="{{ $cert->pivot->expiration_date }}">
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
                <div class="form-group" style="position: relative;">
                    <label class="form-label">Kode Sertifikasi <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="certificates[${certificateIndex}][code]" class="form-control cert-code-input" data-index="${certificateIndex}" placeholder="Contoh: K3-001" autocomplete="off" required>
                    <div class="cert-suggestions" data-index="${certificateIndex}" style="position:absolute; top: 70px; left:0; right:0; background:white; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,.08); z-index:50; display:none; max-height: 180px; overflow:auto;"></div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Sertifikasi</label>
                    <input type="text" name="certificates[${certificateIndex}][name]" class="form-control cert-name-input" data-index="${certificateIndex}" placeholder="Contoh: K3 Umum">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Diterbitkan</label>
                    <input type="date" name="certificates[${certificateIndex}][issued_date]" class="form-control cert-issued-input" data-index="${certificateIndex}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Aktif Hingga (Tahun)</label>
                    <input type="number" name="certificates[${certificateIndex}][active_years]" class="form-control cert-years-input" data-index="${certificateIndex}" placeholder="Contoh: 3" min="0" readonly>
                    <input type="hidden" name="certificates[${certificateIndex}][expiration_date]" class="cert-expiration-hidden" data-index="${certificateIndex}">
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
    attachCertAutoComplete(String(certificateIndex));
    attachCompute(String(certificateIndex));
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

// Load job positions based on selected division
function loadJobPositions() {
    const divisionId = document.getElementById('divisi').value;
    const jobPositionSelect = document.getElementById('jabatan');
    const competencyLevelSelect = document.getElementById('level_kompetensi');
    
    // Clear job positions and competency level
    jobPositionSelect.innerHTML = '<option value="">Pilih Jabatan</option>';
    competencyLevelSelect.value = '';
    
    if (divisionId) {
        fetch(`/api/job-positions-by-division?division_id=${divisionId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(job => {
                    const option = document.createElement('option');
                    option.value = job.name;
                    option.textContent = job.name;
                    option.setAttribute('data-competency-level', job.competency_level);
                    jobPositionSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading job positions:', error);
            });
    }
}

function attachCertAutoComplete(index) {
    const codeInput = document.querySelector(`input.cert-code-input[data-index="${index}"]`);
    const nameInput = document.querySelector(`input.cert-name-input[data-index="${index}"]`);
    const suggestionBox = document.querySelector(`.cert-suggestions[data-index="${index}"]`);
    if (!codeInput || !nameInput || !suggestionBox) return;

    function render(items) {
        if (!items || items.length === 0) { suggestionBox.style.display = 'none'; return; }
        suggestionBox.innerHTML = items.map(it => `
            <div class=\"cert-suggestion-item\" data-code=\"${it.kode}\" data-name=\"${it.nama}\" data-years=\"${it.certificate_active_years}\" style=\"padding:10px 12px; cursor:pointer; border-bottom:1px solid #f3f4f6;\">\n                <div style=\"font-weight:600; color:#1f2937;\">${it.kode}</div>\n                <div style=\"font-size:12px; color:#6b7280;\">${it.nama}${it.certificate_active_years != null ? ` • Aktif ${it.certificate_active_years} th` : ''}</div>\n            </div>
        `).join('');
        suggestionBox.style.display = 'block';
        suggestionBox.querySelectorAll('.cert-suggestion-item').forEach(el => {
            el.addEventListener('click', () => {
                codeInput.value = el.getAttribute('data-code');
                nameInput.value = el.getAttribute('data-name');
                const years = el.getAttribute('data-years');
                const yearsInput = document.querySelector(`input.cert-years-input[data-index=\\"${index}\\"]`);
                if (yearsInput && years && years !== 'null') {
                    yearsInput.value = years;
                    const evt = new Event('input');
                    yearsInput.dispatchEvent(evt);
                }
                suggestionBox.style.display = 'none';
            });
        });
    }

    let fetchTimer;
    codeInput.addEventListener('input', function() {
        const q = this.value.trim();
        if (fetchTimer) clearTimeout(fetchTimer);
        if (q.length < 2) { suggestionBox.style.display = 'none'; return; }
        fetchTimer = setTimeout(() => {
            fetch(`/api/trainings/search?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(json => {
                    if (json && json.success && Array.isArray(json.data)) {
                        render(json.data);
                    } else { suggestionBox.style.display = 'none'; }
                })
                .catch(() => { suggestionBox.style.display = 'none'; });
        }, 250);
    });
    document.addEventListener('click', (e) => {
        if (!suggestionBox.contains(e.target) && e.target !== codeInput) {
            suggestionBox.style.display = 'none';
        }
    });
}

function attachCompute(index) {
    const issuedInput = document.querySelector(`input.cert-issued-input[data-index=\"${index}\"]`);
    const yearsInput = document.querySelector(`input.cert-years-input[data-index=\"${index}\"]`);
    const expHidden = document.querySelector(`input.cert-expiration-hidden[data-index=\"${index}\"]`);
    if (!issuedInput || !yearsInput || !expHidden) return;

    function recomputeExpiration() {
        const issued = issuedInput.value ? new Date(issuedInput.value) : null;
        const years = yearsInput.value ? parseInt(yearsInput.value, 10) : null;
        if (issued && years != null && !isNaN(years)) {
            const exp = new Date(issued);
            exp.setFullYear(exp.getFullYear() + years);
            const yyyy = exp.getFullYear();
            const mm = String(exp.getMonth() + 1).padStart(2, '0');
            const dd = String(exp.getDate()).padStart(2, '0');
            expHidden.value = `${yyyy}-${mm}-${dd}`;
        } else {
            expHidden.value = '';
        }
    }
    issuedInput.addEventListener('change', recomputeExpiration);
    yearsInput.addEventListener('input', recomputeExpiration);
}

// Initialize cert behaviors for existing entries
document.addEventListener('DOMContentLoaded', function() {
    const codeInputs = document.querySelectorAll('input.cert-code-input');
    codeInputs.forEach(inp => attachCertAutoComplete(inp.getAttribute('data-index')));
    const issuedInputs = document.querySelectorAll('input.cert-issued-input');
    issuedInputs.forEach(inp => attachCompute(inp.getAttribute('data-index')));
});

// Load competency level based on selected job position
function loadCompetencyLevel() {
    const jobPositionSelect = document.getElementById('jabatan');
    const competencyLevelSelect = document.getElementById('level_kompetensi');
    const selectedOption = jobPositionSelect.options[jobPositionSelect.selectedIndex];
    
    if (selectedOption && selectedOption.getAttribute('data-competency-level')) {
        const competencyLevel = selectedOption.getAttribute('data-competency-level');
        
        // Find and select the matching competency level
        for (let option of competencyLevelSelect.options) {
            if (option.textContent.includes(`Level ${competencyLevel}`)) {
                option.selected = true;
                break;
            }
        }
    }
}

// Initialize form on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load job positions if division is already selected
    const divisionSelect = document.getElementById('divisi');
    if (divisionSelect.value) {
        loadJobPositions();
    }
});

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
