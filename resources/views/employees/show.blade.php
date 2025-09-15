@extends('layouts/layout')

@section('title', 'Detail Karyawan')

@section('content')
<style>
    .main-content-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 30px; }
    .content-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; padding-bottom:20px; border-bottom:1px solid #e5e7eb; }
    .content-title { margin:0; font-size:24px; font-weight:700; color:#1f2937; }
    .btn { padding:10px 16px; border:none; border-radius:8px; cursor:pointer; font-size:14px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s ease; }
    .btn-primary { background:#3b82f6; color:#fff; }
    .btn-primary:hover { background:#2563eb; }
    .btn-secondary { background:#6b7280; color:#fff; }
    .btn-secondary:hover { background:#4b5563; }
    .btn-warning { background:#ea580c; color:#fff; }
    .btn-warning:hover { background:#dc2626; }
    .employee-profile { display:flex; align-items:center; gap:20px; margin-bottom:30px; padding:20px; background:#f8f9fa; border-radius:12px; }
    .employee-avatar { width:100px; height:100px; border-radius:50%; object-fit:cover; border:4px solid white; box-shadow:0 4px 8px rgba(0,0,0,.1); }
    .employee-info h2 { margin:0 0 8px 0; font-size:28px; font-weight:700; color:#1f2937; }
    .employee-info p { margin:0 0 4px 0; font-size:16px; color:#6b7280; }
    .employee-info .position { font-size:18px; font-weight:600; color:#3b82f6; }
    .info-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:20px; margin-bottom:30px; }
    .info-card { background:#f8f9fa; border-radius:8px; padding:20px; }
    .info-card h3 { margin:0 0 15px 0; font-size:16px; font-weight:600; color:#1f2937; text-transform:uppercase; letter-spacing:.5px; }
    .info-item { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e5e7eb; }
    .info-item:last-child { border-bottom:none; }
    .info-label { font-size:14px; color:#6b7280; font-weight:500; }
    .info-value { font-size:14px; color:#1f2937; font-weight:600; }
    .level-badge { padding:4px 8px; border-radius:4px; font-size:12px; font-weight:600; background:#dbeafe; color:#1e40af; }
    .certifications-section { margin-top:30px; }
    .section-title { font-size:20px; font-weight:600; color:#1f2937; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
    .certification-card { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:15px; margin-bottom:10px; transition:all .2s ease; cursor:pointer; position:relative; }
    .certification-card:hover { box-shadow:0 2px 8px rgba(0,0,0,.1); border-color:#3b82f6; }
    .certification-card:hover .delete-certificate-btn { opacity:1; visibility:visible; }
    .delete-certificate-btn { position:absolute; top:10px; right:10px; background:#dc2626; color:white; border:none; border-radius:50%; width:30px; height:30px; display:flex; align-items:center; justify-content:center; cursor:pointer; opacity:0; visibility:hidden; transition:all .2s ease; font-size:14px; z-index:10; }
    .delete-certificate-btn:hover { background:#b91c1c; transform:scale(1.1); }
    .certification-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px; }
    .certification-name { font-size:16px; font-weight:600; color:#1f2937; margin:0; }
    .certification-details { display:flex; justify-content:space-between; align-items:center; margin-top:10px; }
    .certification-status { display:flex; align-items:center; gap:8px; }
    .status-indicator { width:12px; height:12px; border-radius:50%; display:inline-block; }
    .status-active { background-color:#10b981; }
    .status-warning { background-color:#f59e0b; }
    .status-critical { background-color:#dc2626; }
    .status-expired { background-color:#ef4444; }
    .status-text { font-size:12px; font-weight:500; }
    .status-active-text { color:#10b981; }
    .status-warning-text { color:#f59e0b; }
    .status-critical-text { color:#dc2626; }
    .status-expired-text { color:#ef4444; }
    .cert-date { font-size:12px; color:#6b7280; }
    .empty-certifications { text-align:center; padding:40px 20px; color:#6b7280; }
    
    /* Modal Styles */
    .modal { display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8); }
    .modal-content { position:relative; margin:5% auto; padding:0; width:90%; max-width:800px; background:white; border-radius:12px; overflow:hidden; }
    .modal-header { padding:20px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center; }
    .modal-title { margin:0; font-size:18px; font-weight:600; color:#1f2937; }
    .modal-close { background:none; border:none; font-size:24px; cursor:pointer; color:#6b7280; }
    .modal-close:hover { color:#1f2937; }
    .modal-body { padding:20px; text-align:center; }
    .certificate-image { max-width:100%; height:auto; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
    .no-image { padding:40px; color:#6b7280; font-style:italic; }
</style>

<div class="main-content-card">
    <div class="content-header">
        <h2 class="content-title">Detail Karyawan</h2>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="employee-profile">
        @php
            $avatar = $employee->foto_path
                ? asset('storage/'.$employee->foto_path)
                : 'https://ui-avatars.com/api/?name=' . urlencode(mb_substr($employee->nama,0,1)) . '&background=1e40af&color=fff&size=100';
        @endphp
        <img src="{{ $avatar }}" alt="{{ $employee->nama }}" class="employee-avatar">
        <div class="employee-info">
            <h2>{{ $employee->nama }}</h2>
            <p class="position">{{ $employee->jabatan ?? '-' }}</p>
            <p>{{ $employee->divisi ?? '-' }} • NIP: {{ $employee->nip }}</p>
            <p>Masa kerja: {{ $employee->masa_kerja_tahun }} tahun</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3>Informasi Personal</h3>
            <div class="info-item"><span class="info-label">NIP</span><span class="info-value">{{ $employee->nip }}</span></div>
            <div class="info-item"><span class="info-label">Nama Lengkap</span><span class="info-value">{{ $employee->nama }}</span></div>
            <div class="info-item"><span class="info-label">Email</span><span class="info-value">{{ $employee->email ?? '-' }}</span></div>
            <div class="info-item"><span class="info-label">No. Telepon</span><span class="info-value">{{ $employee->no_telp ?? '-' }}</span></div>
            <div class="info-item"><span class="info-label">Alamat</span><span class="info-value">{{ $employee->alamat ?? '-' }}</span></div>
        </div>
        <div class="info-card">
            <h3>Informasi Pekerjaan</h3>
            <div class="info-item"><span class="info-label">Jabatan</span><span class="info-value">{{ $employee->jabatan ?? '-' }}</span></div>
            <div class="info-item"><span class="info-label">Divisi</span><span class="info-value">{{ $employee->divisi ?? '-' }}</span></div>
            <div class="info-item"><span class="info-label">Masa Kerja</span><span class="info-value">{{ $employee->masa_kerja_tahun }} tahun</span></div>
            <div class="info-item"><span class="info-label">Level Kompetensi</span><span class="level-badge">{{ $employee->level_kompetensi }}</span></div>
        </div>
    </div>

    <div class="certifications-section">
        <h3 class="section-title">Sertifikasi yang Dimiliki</h3>
        @if($employee->certifications->count())
            @foreach($employee->certifications as $cert)
                @php
                    $expirationDate = $cert->pivot->expiration_date;
                    $issuedDate = $cert->pivot->issued_date;
                    $certificateImage = $cert->pivot->certificate_image;
                    
                    // Calculate status
                    $status = 'active';
                    $statusClass = 'status-active';
                    $statusText = 'status-active-text';
                    $statusLabel = 'Aktif';
                    
                    if ($expirationDate) {
                        $today = now();
                        $expiration = \Carbon\Carbon::parse($expirationDate);
                        $twoMonthsBefore = $expiration->copy()->subMonths(2);
                        $oneMonthBefore = $expiration->copy()->subMonth();
                        
                        if ($today->gt($expiration)) {
                            $status = 'expired';
                            $statusClass = 'status-expired';
                            $statusText = 'status-expired-text';
                            $statusLabel = 'Kadaluarsa';
                        } elseif ($today->gte($twoMonthsBefore) && $today->lt($oneMonthBefore)) {
                            $status = 'warning';
                            $statusClass = 'status-warning';
                            $statusText = 'status-warning-text';
                            $statusLabel = 'Akan Kadaluarsa (H-2 Bulan)';
                        } elseif ($today->gte($oneMonthBefore)) {
                            $status = 'critical';
                            $statusClass = 'status-critical';
                            $statusText = 'status-critical-text';
                            $statusLabel = 'Akan Kadaluarsa (H-1 Bulan)';
                        }
                    }
                @endphp
                
                <div class="certification-card" onclick="openCertificateModal('{{ $cert->name }}', '{{ $cert->code }}', '{{ $certificateImage ? asset('storage/' . $certificateImage) : '' }}', '{{ $issuedDate }}', '{{ $expirationDate }}', '{{ $statusLabel }}', '{{ $cert->bidang ?? '' }}', '{{ $cert->kompetensi_inti ?? '' }}', '{{ $cert->kompetensi_pilihan ?? '' }}', '{{ $cert->level ?? '' }}')">
                    <button class="delete-certificate-btn" onclick="event.stopPropagation(); deleteCertificate({{ $employee->id }}, {{ $cert->id }}, '{{ $cert->name }}')" title="Hapus Sertifikat">
                        <i class="fas fa-trash"></i>
                    </button>
                    <div class="certification-header">
                        <h4 class="certification-name">{{ $cert->name }}</h4>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                            <span class="level-badge">Kode: {{ $cert->code }}</span>
                            @if($cert->level)
                                <span class="level-badge" style="background: #fef3c7; color: #92400e;">Level: {{ $cert->level }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="certification-details">
                        <div class="certification-status">
                            <span class="status-indicator {{ $statusClass }}"></span>
                            <span class="status-text {{ $statusText }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="cert-date">
                            @if($issuedDate)
                                Diterbitkan: {{ \Carbon\Carbon::parse($issuedDate)->format('d M Y') }}
                            @endif
                            @if($expirationDate)
                                @if($issuedDate) • @endif
                                Berlaku sampai: {{ \Carbon\Carbon::parse($expirationDate)->format('d M Y') }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-certifications">
                <h4>Belum Ada Sertifikasi</h4>
                <p>Karyawan ini belum memiliki sertifikasi apapun.</p>
            </div>
        @endif
    </div>
</div>

<!-- Certificate Modal -->
<div id="certificateModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Detail Sertifikat</h3>
            <button class="modal-close" onclick="closeCertificateModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div id="modalCertificateImage">
                <!-- Certificate image will be inserted here -->
            </div>
            <div id="modalCertificateInfo" style="margin-top: 20px; text-align: left;">
                <!-- Certificate information will be inserted here -->
            </div>
        </div>
    </div>
</div>

<script>
function openCertificateModal(name, code, imageUrl, issuedDate, expirationDate, status) {
    const modal = document.getElementById('certificateModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalImage = document.getElementById('modalCertificateImage');
    const modalInfo = document.getElementById('modalCertificateInfo');
    
    // Set modal title
    modalTitle.textContent = name;
    
    // Set certificate image
    if (imageUrl) {
        modalImage.innerHTML = `<img src="${imageUrl}" alt="${name}" class="certificate-image">`;
    } else {
        modalImage.innerHTML = `<div class="no-image">Gambar sertifikat tidak tersedia</div>`;
    }
    
    // Set certificate information
    let infoHtml = `
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
            <div style="margin-bottom: 10px;"><strong>Kode Sertifikat:</strong> ${code}</div>
            <div style="margin-bottom: 10px;"><strong>Status:</strong> ${status}</div>
    `;
    
    if (issuedDate) {
        const issued = new Date(issuedDate).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        infoHtml += `<div style="margin-bottom: 10px;"><strong>Tanggal Diterbitkan:</strong> ${issued}</div>`;
    }
    
    if (expirationDate) {
        const expiration = new Date(expirationDate).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        infoHtml += `<div><strong>Tanggal Kadaluarsa:</strong> ${expiration}</div>`;
    }
    
    infoHtml += `</div>`;
    modalInfo.innerHTML = infoHtml;
    
    // Show modal
    modal.style.display = 'block';
}

function closeCertificateModal() {
    document.getElementById('certificateModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('certificateModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCertificateModal();
    }
});

// Delete certificate function
function deleteCertificate(employeeId, certificateId, certificateName) {
    if (confirm(`Apakah Anda yakin ingin menghapus sertifikat "${certificateName}"?`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/employees/${employeeId}/certificates/${certificateId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Update openCertificateModal function to include pelatihan data
function openCertificateModal(name, code, imageUrl, issuedDate, expirationDate, status, bidang, kompetensiInti, kompetensiPilihan, level) {
    const modal = document.getElementById('certificateModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalImage = document.getElementById('modalCertificateImage');
    const modalInfo = document.getElementById('modalCertificateInfo');
    
    // Set modal title
    modalTitle.textContent = name;
    
    // Set certificate image
    if (imageUrl) {
        modalImage.innerHTML = `<img src="${imageUrl}" alt="${name}" class="certificate-image">`;
    } else {
        modalImage.innerHTML = `<div class="no-image">Gambar sertifikat tidak tersedia</div>`;
    }
    
    // Set certificate information with pelatihan data
    let infoHtml = `
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
            <div style="margin-bottom: 10px;"><strong>Kode Sertifikat:</strong> ${code}</div>
            <div style="margin-bottom: 10px;"><strong>Status:</strong> ${status}</div>
    `;
    
    if (bidang) {
        infoHtml += `<div style="margin-bottom: 10px;"><strong>Bidang:</strong> ${bidang}</div>`;
    }
    
    if (level) {
        infoHtml += `<div style="margin-bottom: 10px;"><strong>Level:</strong> ${level}</div>`;
    }
    
    if (kompetensiInti) {
        infoHtml += `<div style="margin-bottom: 10px;"><strong>Kompetensi Inti:</strong> ${kompetensiInti}</div>`;
    }
    
    if (kompetensiPilihan) {
        infoHtml += `<div style="margin-bottom: 10px;"><strong>Kompetensi Pilihan:</strong> ${kompetensiPilihan}</div>`;
    }
    
    if (issuedDate) {
        const issued = new Date(issuedDate).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        infoHtml += `<div style="margin-bottom: 10px;"><strong>Tanggal Diterbitkan:</strong> ${issued}</div>`;
    }
    
    if (expirationDate) {
        const expiration = new Date(expirationDate).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        infoHtml += `<div><strong>Tanggal Kadaluarsa:</strong> ${expiration}</div>`;
    }
    
    infoHtml += `</div>`;
    modalInfo.innerHTML = infoHtml;
    
    // Show modal
    modal.style.display = 'block';
}
</script>
@endsection


