@extends('layouts/layout')

@section('title', 'Detail Pelatihan')

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
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .content-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }
    .btn {
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all .2s ease;
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
    .detail-section {
        margin-bottom: 30px;
    }
    .detail-section h3 {
        color: #1e40af;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
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
    .description-text {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #3b82f6;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
    }
</style>

<div class="main-content-card">
    <div class="content-header">
        <h2 class="content-title">Detail Pelatihan</h2>
        <div>
            <a href="{{ route('trainings.edit', $training) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('trainings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="detail-section">
        <h3>Informasi Dasar</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Kode Pelatihan</span>
                <span class="detail-value">{{ $training->code }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Nama Pelatihan</span>
                <span class="detail-value">{{ $training->name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Kategori</span>
                <span class="detail-value">
                    <span class="category-badge category-{{ strtolower($training->category) }}">
                        {{ $training->category }}
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Level</span>
                <span class="detail-value">
                    <span class="level-badge">{{ $training->level == 0 ? 'Umum' : 'Level ' . $training->level }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <h3>Detail Pelatihan</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Biaya</span>
                <span class="detail-value">
                    {{ $training->cost ? 'Rp ' . number_format($training->cost, 0, ',', '.') : 'TBD' }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Durasi (Hari)</span>
                <span class="detail-value">{{ $training->duration_days ? $training->duration_days . ' hari' : 'TBD' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Sertifikat Aktif Hingga (Tahun)</span>
                <span class="detail-value">{{ !is_null($training->certificate_active_years) ? $training->certificate_active_years . ' tahun' : 'TBD' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Lembaga</span>
                <span class="detail-value">{{ $training->institution ?? 'TBD' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Kontak Lembaga</span>
                <span class="detail-value">
                    @php
                        $contacts = [];
                        if ($training->institution_phone) $contacts[] = 'Telp: ' . $training->institution_phone;
                        if ($training->institution_email) $contacts[] = 'Email: ' . $training->institution_email;
                        if ($training->institution_address) $contacts[] = 'Alamat: ' . $training->institution_address;
                    @endphp
                    {{ count($contacts) ? implode(' | ', $contacts) : 'TBD' }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Kode Sertifikasi</span>
                <span class="detail-value">{{ $training->certification_code ?? 'TBD' }}</span>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <h3>Divisi & Jabatan Relevan</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Divisi Relevan</span>
                <span class="detail-value">
                    {{ implode(', ', $training->relevant_divisions ?? []) }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Jabatan Relevan</span>
                <span class="detail-value">
                    {{ implode(', ', $training->relevant_job_positions ?? []) }}
                </span>
            </div>
        </div>
    </div>

    @if($training->competencies_gained)
    <div class="detail-section">
        <h3>Kompetensi yang Didapat</h3>
        <div class="description-text">{{ $training->competencies_gained }}</div>
    </div>
    @endif

    @if($training->next_competencies)
    <div class="detail-section">
        <h3>Kompetensi Lanjutan</h3>
        <div class="description-text">{{ $training->next_competencies }}</div>
    </div>
    @endif

    @if($training->description)
    <div class="detail-section">
        <h3>Deskripsi</h3>
        <div class="description-text">{{ $training->description }}</div>
    </div>
    @endif
</div>
@endsection
