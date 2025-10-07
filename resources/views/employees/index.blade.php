@extends('layouts/layout')

@section('title', 'Data Karyawan')

@section('content')
<style>
    .main-content-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); margin-bottom: 30px; }
    .content-header { display:flex; flex-direction:column; align-items:flex-start; gap:12px; margin-bottom:18px; }
    .content-title { margin:0; font-size:24px; font-weight:700; color:#1f2937; }
    .search-form { display:flex; align-items:center; gap:10px; margin-bottom:20px; }
    .search-input { padding:10px 15px; border:1px solid #e5e7eb; border-radius:8px; outline:none; min-width:250px; font-size:14px; }
    .search-input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
    .btn { padding:10px 16px; border:none; border-radius:8px; cursor:pointer; font-size:14px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .2s ease; }
    .btn-primary { background:#3b82f6; color:white; }
    .btn-primary:hover { background:#2563eb; }
    .btn-success { background:#16a34a; color:white; }
    .btn-success:hover { background:#15803d; }
    .btn-warning { background:#ea580c; color:white; }
    .btn-warning:hover { background:#dc2626; }
    .btn-danger { background:#dc2626; color:white; }
    .btn-danger:hover { background:#b91c1c; }
    .btn-sm { padding:6px 12px; font-size:12px; }
    .employee-table { width:100%; border-collapse:collapse; margin-top:20px; background:white; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.1); }
    .employee-table th { background:#f8f9fa; padding:15px 12px; text-align:left; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; font-size:14px; }
    .employee-table td { padding:15px 12px; border-bottom:1px solid #f3f4f6; font-size:14px; color:#374151; }
    .employee-table tr:hover { background:#f9fafb; }
    .employee-table tr:last-child td { border-bottom:none; }
    .avatar { width:40px; height:40px; border-radius:50%; object-fit:cover; }
    .level-badge { padding:2px 6px; border-radius:4px; font-size:10px; font-weight:600; background:#dbeafe; color:#1e40af; }
    .action-buttons { display:flex; gap:8px; }
    .alert { padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
    .alert-success { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
    .alert-danger { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .empty-state { text-align:center; padding:40px 20px; color:#6b7280; }
    .empty-state i { font-size:48px; margin-bottom:16px; color:#d1d5db; }
    .avatar-cell { display:flex; align-items:center; gap:10px; }
    .avatar-meta { display:flex; flex-direction:column; }
    .status-dot { display:inline-block; width:10px; height:10px; border-radius:50%; margin-right:6px; vertical-align:middle; }
    .status-green { background:#16a34a; }
    .status-yellow { background:#f59e0b; }
    .status-red { background:#dc2626; }
</style>

    <div class="main-content-card">
        <div class="content-header">
            <h2 class="content-title">Manajemen Data Karyawan</h2>
            <div class="search-form">
                <form action="{{ route('employees.index') }}" method="get" style="display:flex; align-items:center; gap:10px;">
                    <input type="text" name="q" placeholder="Cari karyawan..." value="{{ request('q') }}" class="search-input">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                </form>
                <a href="{{ route('employees.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Data Karyawan</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @if($employees->count() > 0)
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Masa Kerja</th>
                        <th>Level</th>
                        <th>Sertifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                    <tr>
                        <td>
                            @php
                                $avatar = $emp->foto_path
                                    ? asset('storage/'.$emp->foto_path)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(mb_substr($emp->nama,0,1)) . '&background=1e40af&color=fff&size=40';
                            @endphp
                            <img src="{{ $avatar }}" alt="{{ $emp->nama }}" class="avatar">
                        </td>
                        <td><strong>{{ $emp->nip }}</strong></td>
                        <td>{{ $emp->nama }}</td>
                        <td>{{ $emp->email }}</td>
                        <td>{{ $emp->jabatan }}</td>
                        <td>{{ $emp->divisi }}</td>
                        <td>{{ $emp->masa_kerja_tahun }} tahun</td>
                        <td><span class="level-badge">{{ $emp->level_kompetensi }}</span></td>
                        <td>
                            @php
                                $countCert = $emp->certifications->count();
                                $today = \Carbon\Carbon::today();
                                $nextExpiration = null;
                                // Ambil tanggal kadaluarsa terdekat (bisa lewat atau akan datang)
                                $dates = $emp->certifications->map(function($c){ return $c->pivot->expiration_date ?? null; })
                                    ->filter();
                                if ($dates->count() > 0) {
                                    // Cari yang akan datang terdekat
                                    $upcoming = $dates->filter(function($d) use ($today){ return \Carbon\Carbon::parse($d)->greaterThanOrEqualTo($today); });
                                    if ($upcoming->count() > 0) {
                                        $nextExpiration = $upcoming->sortBy(function($d){ return \Carbon\Carbon::parse($d)->timestamp; })->first();
                                    } else {
                                        // Jika tidak ada yang akan datang, ambil yang paling dekat (namun sudah lewat)
                                        $nextExpiration = $dates->sortByDesc(function($d){ return \Carbon\Carbon::parse($d)->timestamp; })->first();
                                    }
                                }

                                $statusClass = null; $tooltip = null;
                                if ($countCert === 0) {
                                    $statusClass = 'status-red';
                                    $tooltip = 'Belum memiliki sertifikasi';
                                } elseif ($nextExpiration) {
                                    $diff = \Carbon\Carbon::parse($nextExpiration)->diffInDays($today, false); // negatif bila di masa depan
                                    if ($diff < 0) {
                                        $daysRemaining = abs($diff);
                                        if ($daysRemaining <= 30) {
                                            $statusClass = 'status-yellow';
                                        } else {
                                            $statusClass = 'status-green';
                                        }
                                        $tooltip = 'Kadaluarsa pada ' . \Carbon\Carbon::parse($nextExpiration)->format('d M Y') . ' (' . $daysRemaining . ' hari lagi)';
                                    } else {
                                        $statusClass = 'status-red';
                                        $tooltip = 'Kadaluarsa ' . $diff . ' hari yang lalu (' . \Carbon\Carbon::parse($nextExpiration)->format('d M Y') . ')';
                                    }
                                } else {
                                    // Tidak ada tanggal kadaluarsa pada sertifikasi
                                    $statusClass = 'status-green';
                                    $tooltip = 'Sertifikasi tanpa tanggal kadaluarsa';
                                }
                            @endphp

                            <span class="{{ $statusClass }} status-dot" title="{{ $tooltip }}"></span>
                            @if($countCert > 0)
                                <span class="badge bg-primary">{{ $countCert }} sertifikat</span>
                            @else
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('employees.show', $emp) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('employees.edit', $emp) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('employees.destroy', $emp) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                {{ $employees->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>Tidak ada data karyawan</h3>
                <p>Belum ada data karyawan yang tersedia. Silakan tambah data karyawan terlebih dahulu.</p>
                <a href="{{ route('employees.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Data Karyawan</a>
            </div>
        @endif
    </div>

<script>
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        });
    }, 5000);
</script>
@endsection


