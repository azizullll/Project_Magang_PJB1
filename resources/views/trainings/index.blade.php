@extends('layouts/layout')

@section('title', 'Data Pelatihan')

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
    .btn-primary { 
        background: #3b82f6; 
        color: white; 
    }
    .btn-primary:hover { 
        background: #2563eb; 
    }
    .btn-success { 
        background: #16a34a; 
        color: white; 
    }
    .btn-success:hover { 
        background: #15803d; 
    }
    .btn-warning { 
        background: #ea580c; 
        color: white; 
    }
    .btn-warning:hover { 
        background: #dc2626; 
    }
    .btn-danger { 
        background: #dc2626; 
        color: white; 
    }
    .btn-danger:hover { 
        background: #b91c1c; 
    }
    .btn-sm { 
        padding: 6px 12px; 
        font-size: 12px; 
    }
    .training-table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 20px; 
        background: white; 
        border-radius: 8px; 
        overflow: hidden; 
        box-shadow: 0 1px 3px rgba(0,0,0,.1); 
    }
    .training-table th { 
        background: #f8f9fa; 
        padding: 15px 12px; 
        text-align: left; 
        font-weight: 600; 
        color: #374151; 
        border-bottom: 1px solid #e5e7eb; 
        font-size: 14px; 
    }
    .training-table td { 
        padding: 15px 12px; 
        border-bottom: 1px solid #f3f4f6; 
        font-size: 14px; 
        color: #374151; 
    }
    .training-table tr:hover { 
        background: #f9fafb; 
    }
    .training-table tr:last-child td { 
        border-bottom: none; 
    }
    .category-badge { 
        padding: 4px 8px; 
        border-radius: 12px; 
        font-size: 11px; 
        font-weight: 600; 
        text-transform: uppercase;
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
        padding: 2px 6px; 
        border-radius: 4px; 
        font-size: 10px; 
        font-weight: 600; 
        background: #dbeafe; 
        color: #1e40af; 
    }
    .action-buttons { 
        display: flex; 
        gap: 8px; 
    }
    .alert { 
        padding: 12px 16px; 
        border-radius: 8px; 
        margin-bottom: 20px; 
        font-size: 14px; 
    }
    .alert-success { 
        background: #dcfce7; 
        color: #166534; 
        border: 1px solid #bbf7d0; 
    }
    .alert-danger { 
        background: #fef2f2; 
        color: #991b1b; 
        border: 1px solid #fecaca; 
    }
    .empty-state { 
        text-align: center; 
        padding: 40px 20px; 
        color: #6b7280; 
    }
    .empty-state i { 
        font-size: 48px; 
        margin-bottom: 16px; 
        color: #d1d5db; 
    }
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
    .filter-select {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
        min-width: 150px;
    }
</style>

<div class="main-content-card">
    <div class="content-header">
        <h2 class="content-title">Manajemen Data Pelatihan</h2>
        <div class="search-form">
            <form action="{{ route('trainings.index') }}" method="get" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="q" placeholder="Cari pelatihan..." value="{{ request('q') }}" class="search-input">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
            <a href="{{ route('trainings.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Data Pelatihan</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('trainings.index') }}" method="get" class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Kategori</label>
                <select name="category" class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="Teknis" {{ request('category') == 'Teknis' ? 'selected' : '' }}>Teknis</option>
                    <option value="Manajerial" {{ request('category') == 'Manajerial' ? 'selected' : '' }}>Manajerial</option>
                    <option value="K3" {{ request('category') == 'K3' ? 'selected' : '' }}>K3</option>
                    <option value="Softskill" {{ request('category') == 'Softskill' ? 'selected' : '' }}>Softskill</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Level</label>
                <select name="level" class="filter-select">
                    <option value="">Semua Level</option>
                    @for($i = 1; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ request('level') == $i ? 'selected' : '' }}>Level {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('trainings.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    @if($trainings->count() > 0)
        <table class="training-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Pelatihan</th>
                    <th>Kategori</th>
                    <th>Level</th>
                    <th>Divisi Relevan</th>
                    <th>Biaya</th>
                    <th>Aktif Hingga (Tahun)</th>
                    <th>Lembaga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainings as $training)
                <tr>
                    <td><strong>{{ $training->code }}</strong></td>
                    <td>{{ $training->name }}</td>
                    <td>
                        <span class="category-badge category-{{ strtolower($training->category) }}">
                            {{ $training->category }}
                        </span>
                    </td>
                    <td><span class="level-badge">Level {{ $training->level }}</span></td>
                    <td>
                        @php
                            $divisions = \App\Models\Division::whereIn('id', $training->relevant_divisions ?? [])->pluck('name')->toArray();
                        @endphp
                        {{ implode(', ', $divisions) }}
                    </td>
                    <td>
                        @if($training->cost)
                            Rp {{ number_format($training->cost, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if(!is_null($training->certificate_active_years))
                            {{ $training->certificate_active_years }} tahun
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $training->institution ?? '-' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('trainings.show', $training) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('trainings.edit', $training) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('trainings.destroy', $training) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pelatihan ini?')">
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
            {{ $trainings->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-graduation-cap"></i>
            <h3>Tidak ada data pelatihan</h3>
            <p>Belum ada data pelatihan yang tersedia. Silakan tambah data pelatihan terlebih dahulu.</p>
            <a href="{{ route('trainings.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Data Pelatihan</a>
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
