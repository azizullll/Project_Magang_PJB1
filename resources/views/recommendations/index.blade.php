@extends('layouts/layout')

@section('title', 'Rekomendasi Sertifikasi')

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

    .form-select {
        width: 100%;
        max-width: 400px;
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

    .btn-primary:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    .loading {
        display: none;
        text-align: center;
        padding: 20px;
        color: #6b7280;
    }

    .recommendations-container {
        display: none;
        margin-top: 30px;
    }

    .recommendation-card {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.2s ease;
    }

    .recommendation-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .recommendation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .recommendation-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .priority-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-high {
        background: #fef2f2;
        color: #dc2626;
    }

    .priority-medium {
        background: #fef3c7;
        color: #d97706;
    }

    .priority-low {
        background: #dbeafe;
        color: #2563eb;
    }

    .recommendation-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
    }

    .detail-value {
        font-size: 14px;
        color: #1f2937;
        font-weight: 500;
    }

    .category-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .category-teknis {
        background: #dbeafe;
        color: #1e40af;
    }

    .category-manajerial {
        background: #dcfce7;
        color: #166534;
    }

    .category-k3 {
        background: #fef3c7;
        color: #92400e;
    }

    .category-softskill {
        background: #fce7f3;
        color: #be185d;
    }

    .level-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        background: #dbeafe;
        color: #1e40af;
        display: inline-block;
    }

    .reasons {
        background: #f1f5f9;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #3b82f6;
    }

    .reasons-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 10px;
    }

    .reasons-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .reasons-list li {
        font-size: 13px;
        color: #374151;
        margin-bottom: 5px;
        padding-left: 20px;
        position: relative;
    }

    .reasons-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: bold;
    }

    .no-recommendations {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }

    .employee-info {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .employee-info h3 {
        margin: 0 0 10px 0;
        color: #0369a1;
        font-size: 16px;
    }

    .employee-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
        font-size: 14px;
        color: #374151;
    }
</style>

<div class="main-content-card">
    <div class="content-header">
        <h2 class="content-title">Rekomendasi Sertifikasi Cerdas</h2>
        <p style="color: #6b7280; margin: 0;">Sistem akan menganalisis profil karyawan dan memberikan rekomendasi pelatihan yang tepat</p>
    </div>

    <div class="form-group">
        <label for="employee_id" class="form-label">Pilih Karyawan</label>
        <select id="employee_id" name="employee_id" class="form-select">
            <option value="">Pilih karyawan untuk melihat rekomendasi</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">
                    {{ $employee->nama }} - {{ $employee->jabatan }} ({{ $employee->divisi }})
                </option>
            @endforeach
        </select>
    </div>

    <button id="getRecommendations" class="btn btn-primary" disabled>
        <i class="fas fa-search"></i> Dapatkan Rekomendasi
    </button>

    <div class="loading" id="loading">
        <i class="fas fa-spinner fa-spin"></i> Menganalisis data karyawan...
    </div>

    <div class="recommendations-container" id="recommendationsContainer">
        <!-- Employee info will be inserted here -->
        <div class="employee-info" id="employeeInfo" style="display: none;">
            <h3>Informasi Karyawan</h3>
            <div class="employee-details" id="employeeDetails"></div>
        </div>

        <!-- Recommendations will be inserted here -->
        <div id="recommendationsList"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.getElementById('employee_id');
    const getRecommendationsBtn = document.getElementById('getRecommendations');
    const loading = document.getElementById('loading');
    const recommendationsContainer = document.getElementById('recommendationsContainer');
    const employeeInfo = document.getElementById('employeeInfo');
    const employeeDetails = document.getElementById('employeeDetails');
    const recommendationsList = document.getElementById('recommendationsList');

    // Enable/disable button based on selection
    employeeSelect.addEventListener('change', function() {
        getRecommendationsBtn.disabled = !this.value;
        if (!this.value) {
            recommendationsContainer.style.display = 'none';
        }
    });

    // Get recommendations
    getRecommendationsBtn.addEventListener('click', function() {
        const employeeId = employeeSelect.value;
        if (!employeeId) return;

        // Show loading
        loading.style.display = 'block';
        recommendationsContainer.style.display = 'none';
        getRecommendationsBtn.disabled = true;

        // Fetch recommendations
        fetch(`/api/recommendations?employee_id=${employeeId}`)
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                getRecommendationsBtn.disabled = false;
                
                if (data.success) {
                    displayEmployeeInfo(data.employee);
                    displayRecommendations(data.recommendations);
                    recommendationsContainer.style.display = 'block';
                } else {
                    alert('Error: ' + (data.message || 'Gagal mendapatkan rekomendasi'));
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                getRecommendationsBtn.disabled = false;
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil rekomendasi');
            });
    });

    function displayEmployeeInfo(employee) {
        employeeDetails.innerHTML = `
            <div><strong>Nama:</strong> ${employee.nama}</div>
            <div><strong>NIP:</strong> ${employee.nip}</div>
            <div><strong>Jabatan:</strong> ${employee.jabatan}</div>
            <div><strong>Divisi:</strong> ${employee.divisi}</div>
            <div><strong>Level Kompetensi:</strong> ${employee.level_kompetensi || '-'}</div>
            <div><strong>Masa Kerja:</strong> ${employee.masa_kerja_tahun || 0} tahun</div>
        `;
        employeeInfo.style.display = 'block';
    }

    function displayRecommendations(recommendations) {
        if (!recommendations || recommendations.length === 0) {
            recommendationsList.innerHTML = `
                <div class="no-recommendations">
                    <i class="fas fa-info-circle" style="font-size: 48px; margin-bottom: 15px; color: #9ca3af;"></i>
                    <h3>Tidak ada rekomendasi</h3>
                    <p>Karyawan ini sudah memiliki semua sertifikasi yang diperlukan atau tidak ada pelatihan yang relevan.</p>
                </div>
            `;
            return;
        }

        let html = '';
        recommendations.forEach(rec => {
            const priorityClass = getPriorityClass(rec.priority);
            const categoryClass = getCategoryClass(rec.training.category);
            const levelText = rec.training.level === 0 ? 'Umum' : `Level ${rec.training.level}`;
            const durationText = rec.training.duration_days 
                ? `${rec.training.duration_days} hari` 
                : (rec.training.duration_hours ? `${rec.training.duration_hours} jam` : 'TBD');
            const priorityText = rec.priority === 'High' ? 'Tinggi' : (rec.priority === 'Medium' ? 'Sedang' : 'Rendah');
            
            html += `
                <div class="recommendation-card">
                    <div class="recommendation-header">
                        <h3 class="recommendation-title">${rec.training.name}</h3>
                        <span class="priority-badge ${priorityClass}">${priorityText}</span>
                    </div>
                    
                    <div class="recommendation-details">
                        <div class="detail-item">
                            <span class="detail-label">Kode</span>
                            <span class="detail-value">${rec.training.code}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kategori</span>
                            <span class="detail-value">
                                <span class="category-badge ${categoryClass}">${rec.training.category}</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Level</span>
                            <span class="detail-value">
                                <span class="level-badge">${levelText}</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Durasi</span>
                            <span class="detail-value">${durationText}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Lembaga</span>
                            <span class="detail-value">${rec.training.institution || 'TBD'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Biaya</span>
                            <span class="detail-value">${rec.training.cost ? 'Rp ' + new Intl.NumberFormat('id-ID').format(rec.training.cost) : 'TBD'}</span>
                        </div>
                    </div>
                    
                    ${rec.training.competencies_gained ? `
                    <div class="detail-item" style="margin-top: 10px;">
                        <span class="detail-label">Kompetensi yang Diperoleh</span>
                        <span class="detail-value" style="font-size: 13px;">${rec.training.competencies_gained}</span>
                    </div>
                    ` : ''}
                    
                    <div class="reasons">
                        <div class="reasons-title">Alasan Rekomendasi:</div>
                        <ul class="reasons-list">
                            ${rec.reasons.map(reason => `<li>${reason}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
        });

        recommendationsList.innerHTML = html;
    }

    function getPriorityClass(priority) {
        // Priority sudah dalam format 'High', 'Medium', 'Low'
        switch(priority) {
            case 'High': return 'priority-high';
            case 'Medium': return 'priority-medium';
            case 'Low': return 'priority-low';
            default: return 'priority-medium';
        }
    }

    function getCategoryClass(category) {
        switch(category.toLowerCase()) {
            case 'teknis': return 'category-teknis';
            case 'manajerial': return 'category-manajerial';
            case 'k3': return 'category-k3';
            case 'softskill': return 'category-softskill';
            default: return 'category-teknis';
        }
    }
});
</script>
@endsection