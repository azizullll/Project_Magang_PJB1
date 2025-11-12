@extends('layouts/layout')

@section('title', 'Data Sertifikasi')

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
        margin-bottom: 18px; 
    }
    .content-title { 
        margin: 0; 
        font-size: 24px; 
        font-weight: 700; 
        color: #1f2937; 
    }
    .search-form { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        margin-bottom: 20px; 
        flex-wrap: wrap;
    }
    .search-input { 
        padding: 10px 15px; 
        border: 1px solid #e5e7eb; 
        border-radius: 8px; 
        outline: none; 
        min-width: 250px; 
        font-size: 14px; 
    }
    .search-input:focus { 
        border-color: #3b82f6; 
        box-shadow: 0 0 0 3px rgba(59,130,246,.1); 
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
    .btn-primary { background: #3b82f6; color: white; }
    .btn-primary:hover { background: #2563eb; }
    .btn-success { background: #16a34a; color: white; }
    .btn-success:hover { background: #15803d; }
    .btn-warning { background: #ea580c; color: white; }
    .btn-warning:hover { background: #dc2626; }
    .btn-danger { background: #dc2626; color: white; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-sm { padding: 6px 12px; font-size: 12px; }
    .employee-table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 20px; 
        background: white; 
        border-radius: 8px; 
        overflow: hidden; 
        box-shadow: 0 1px 3px rgba(0,0,0,.1); 
    }
    .employee-table th { 
        background: #f8f9fa; 
        padding: 15px 12px; 
        text-align: left; 
        font-weight: 600; 
        color: #374151; 
        border-bottom: 1px solid #e5e7eb; 
        font-size: 14px; 
    }
    .employee-table td { 
        padding: 15px 12px; 
        border-bottom: 1px solid #f3f4f6; 
        font-size: 14px; 
        color: #374151; 
        vertical-align: middle;
    }
    .employee-table tr:hover { background: #f9fafb; }
    .employee-table tr:last-child td { border-bottom: none; }
    .avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 50%; 
        object-fit: cover; 
        border: 2px solid #e5e7eb;
        display: block;
    }
    .level-badge { 
        padding: 2px 6px; 
        border-radius: 4px; 
        font-size: 10px; 
        font-weight: 600; 
        background: #dbeafe; 
        color: #1e40af; 
    }
    .action-buttons { display: flex; gap: 8px; }
    .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 48px; margin-bottom: 16px; color: #d1d5db; }
    .avatar-cell { display: flex; align-items: center; gap: 10px; }
    .avatar-meta { display: flex; flex-direction: column; }
    .status-dot { display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 6px; vertical-align: middle; }
    .status-green { background: #16a34a; }
    .status-yellow { background: #f59e0b; }
    .status-red { background: #dc2626; }
    .filter-select {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        min-width: 150px;
    }
    .filter-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,.1);
    }
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-primary { background: #dbeafe; color: #1e40af; }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-danger { background: #fef2f2; color: #991b1b; }
    .badge-secondary { background: #f1f5f9; color: #64748b; }
    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .filter-row {
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
    }
    .btn-secondary {
        background: #6b7280;
        color: white;
    }
    .btn-secondary:hover {
        background: #4b5563;
    }
</style>

<div class="main-content-card">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="content-header">
        <h2 class="content-title">Data Sertifikat Karyawan</h2>
        <div class="search-form">
            <input type="text" name="search" placeholder="Cari nama, NIP, atau email..." value="{{ request('search') }}" class="search-input" form="searchForm">
            <button type="submit" form="searchForm" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            <a href="{{ route('certifications.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah ke Pelatihan</a>
            <form id="searchForm" action="{{ route('certifications.index') }}" method="get" style="display: none;"></form>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('certifications.index') }}" method="get" class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Divisi</label>
                <select name="division" class="filter-select">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $divisionName)
                        <option value="{{ $divisionName }}" {{ request('division') == $divisionName ? 'selected' : '' }}>
                            {{ $divisionName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="expiring" {{ request('status') == 'expiring' ? 'selected' : '' }}>Segera Habis</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    <option value="none" {{ request('status') == 'none' ? 'selected' : '' }}>Belum Ada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request()->hasAny(['search', 'division', 'status']))
                <a href="{{ route('certifications.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <table class="employee-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Divisi</th>
                <th>Jabatan</th>
                <th>Sertifikasi Terbaru</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
             @forelse($employees as $index => $employee)
                 @php
                     // Count total from both trainings and certifications (for backward compatibility)
                     $totalTrainings = $employee->trainings->count();
                     $totalLegacyCertifications = $employee->certifications->count();
                     $totalCertifications = $totalTrainings + $totalLegacyCertifications;
                     
                     $expiredCount = 0;
                     $expiringSoonCount = 0;
                     $activeCount = 0;
                     $latestCertification = null;
                     $nearestExpiration = null;
                     $nearestExpirationDays = null;
 
                    // Process trainings (new system)
                    foreach ($employee->trainings as $training) {
                        // Penyesuaian logika untuk Asmen/Supervisor: boleh "Umum" (level 0) dan level 1-4
                        if ($employee->jabatan === 'Supervisor(Asmen)') {
                            $categoryNorm = is_string($training->category) ? mb_strtolower(trim($training->category)) : '';
                            $levelNorm = (int) ($training->level ?? 0);
                            // Level 0 (Umum) atau level 1-4 diizinkan
                            $isAllowed = ($levelNorm == 0) || ($levelNorm >= 1 && $levelNorm <= 4);
                            if (!$isAllowed) {
                                continue; // abaikan pelatihan yang tidak sesuai
                            }
                        }
                         $expirationDate = \Carbon\Carbon::parse($training->pivot->expiration_date);
                         $issuedDate = \Carbon\Carbon::parse($training->pivot->issued_date);
                         $today = \Carbon\Carbon::now();
                         $diffDays = $expirationDate->diffInDays($today, false);
                         $diffMonths = $expirationDate->diffInMonths($today, false);
                         
                         if ($diffDays >= 0) {
                             $expiredCount++;
                         } elseif ($diffDays >= -7) {
                             // H-7 hari atau kurang
                             $expiringSoonCount++;
                         } elseif ($diffMonths >= -3) {
                             // H-3 bulan atau kurang
                             $expiringSoonCount++;
                         } else {
                             $activeCount++;
                         }
 
                         // Find latest certification
                         if ($latestCertification === null || $issuedDate->gt(\Carbon\Carbon::parse($latestCertification->pivot->issued_date))) {
                             $latestCertification = $training;
                         }
 
                         // Find nearest expiration
                         if ($nearestExpiration === null || $expirationDate->lt($nearestExpiration)) {
                             $nearestExpiration = $expirationDate;
                             $nearestExpirationDays = abs($diffDays);
                         }
                     }
                     
                     // Process legacy certifications (old system)
                     foreach ($employee->certifications as $certification) {
                         $expirationDate = \Carbon\Carbon::parse($certification->pivot->expiration_date);
                         $issuedDate = \Carbon\Carbon::parse($certification->pivot->issued_date);
                         $today = \Carbon\Carbon::now();
                         $diffDays = $expirationDate->diffInDays($today, false);
                         $diffMonths = $expirationDate->diffInMonths($today, false);
                         
                         if ($diffDays >= 0) {
                             $expiredCount++;
                         } elseif ($diffDays >= -7) {
                             // H-7 hari atau kurang
                             $expiringSoonCount++;
                         } elseif ($diffMonths >= -3) {
                             // H-3 bulan atau kurang
                             $expiringSoonCount++;
                         } else {
                             $activeCount++;
                         }
 
                         // Find latest certification (compare with trainings)
                         if ($latestCertification === null || $issuedDate->gt(\Carbon\Carbon::parse($latestCertification->pivot->issued_date))) {
                             $latestCertification = $certification;
                         }
 
                         // Find nearest expiration
                         if ($nearestExpiration === null || $expirationDate->lt($nearestExpiration)) {
                             $nearestExpiration = $expirationDate;
                             $nearestExpirationDays = abs($diffDays);
                         }
                     }
 
                     // Determine status color and dot
                     $statusClass = 'success';
                     $statusText = 'Semua Aktif';
                     $statusDot = 'status-green';
 
                     if ($expiredCount > 0) {
                         $statusClass = 'danger';
                         $statusText = $expiredCount . ' Kadaluarsa';
                         $statusDot = 'status-red';
                     } elseif ($expiringSoonCount > 0) {
                         $statusClass = 'warning';
                         $statusText = $expiringSoonCount . ' Segera Habis';
                         $statusDot = 'status-yellow';
                     } elseif ($totalCertifications == 0) {
                         $statusClass = 'secondary';
                         $statusText = 'Belum Ada';
                         $statusDot = 'status-red';
                     }
                 @endphp
                <tr>
                    <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $index + 1 }}</td>
                    <td>
                        <div class="avatar-cell">
                            @php
                                $avatarUrl = '';
                                $fotoExists = false;
                                
                                if ($employee->foto_path) {
                                    $fullPath = storage_path('app/public/' . $employee->foto_path);
                                    $fotoExists = file_exists($fullPath);
                                    
                                    if ($fotoExists) {
                                        $avatarUrl = asset('storage/' . $employee->foto_path);
                                        if (strpos($avatarUrl, 'localhost') !== false && strpos($avatarUrl, ':8000') === false) {
                                            $avatarUrl = str_replace('http://localhost', 'http://localhost:8000', $avatarUrl);
                                        }
                                    }
                                }
                            @endphp
                            @if($employee->foto_path && $fotoExists)
                                <img src="{{ $avatarUrl }}" alt="{{ $employee->nama }}" class="avatar" 
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif
                            @if(!$fotoExists || !$employee->foto_path)
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: #3b82f6; display: {{ $employee->foto_path && $fotoExists ? 'none' : 'flex' }}; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                    {{ strtoupper(substr($employee->nama, 0, 1)) }}
                                </div>
                            @endif
                            <div class="avatar-meta">
                                <strong>{{ $employee->nama }}</strong>
                                <small style="color: #6b7280;">{{ $employee->nip }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ $employee->divisi }}</span>
                    </td>
                    <td>{{ $employee->jabatan }}</td>
                    <td>
                        @if($latestCertification)
                            <div>
                                <strong>{{ $latestCertification->name }}</strong>
                                <br>
                                <small style="color: #6b7280;">
                                    <i class="fas fa-calendar"></i> 
                                    Diterbitkan: {{ \Carbon\Carbon::parse($latestCertification->pivot->issued_date)->format('d/m/Y') }}
                                </small>
                                <br>
                                @if(isset($latestCertification->level))
                                    <span class="level-badge">{{ $latestCertification->level == 0 ? 'Umum' : 'Level ' . $latestCertification->level }}</span>
                                @endif
                            </div>
                        @else
                            <span style="color: #6b7280;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ $totalCertifications }}</span> sertifikat
                    </td>
                    <td>
                        <span class="status-dot {{ $statusDot }}"></span>
                        <span class="badge badge-{{ $statusClass }}">{{ $statusText }}</span>
                        @if($nearestExpiration && $totalCertifications > 0)
                             <br><small style="color: #6b7280;">
                                 @php
                                     $today = \Carbon\Carbon::now();
                                     $diffDays = (int) $nearestExpiration->diffInDays($today, false); // negatif jika di masa depan
                                     $absDays = abs($diffDays);
                                     $absMonths = abs((int) $nearestExpiration->diffInMonths($today, false));
                                     $suffix = $diffDays < 0 ? 'lagi' : 'lalu';
                                 @endphp
                                 @if($absDays > 30)
                                     {{ $absMonths }} bulan {{ $suffix }}
                                 @else
                                     {{ $absDays }} hari {{ $suffix }}
                                 @endif
                             </small>
                         @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('certifications.show', $employee->id) }}" class="btn btn-primary btn-sm" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('certifications.create') }}?employee_id={{ $employee->id }}" class="btn btn-success btn-sm" title="Tambah Sertifikasi">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada data karyawan ditemukan.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($employees->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $employees->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
