@extends('layouts.layout')

@section('title', 'Detail Sertifikasi - ' . $employee->nama)

@section('content')
    <div class="page-header">
        <h1>Detail Sertifikasi - {{ $employee->nama }}</h1>
    </div>

    <div class="container-fluid p-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Employee Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informasi Karyawan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        @if ($employee->foto_path)
                            <img src="{{ asset('storage/' . $employee->foto_path) }}" alt="Foto {{ $employee->nama }}"
                                class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px;">
                                <i class="fas fa-user fa-2x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>NIP:</strong> {{ $employee->nip }}</p>
                                <p><strong>Nama:</strong> {{ $employee->nama }}</p>
                                <p><strong>Email:</strong> {{ $employee->email }}</p>
                                <p><strong>No. Telepon:</strong> {{ $employee->no_telp ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Divisi:</strong> {{ $employee->divisi }}</p>
                                <p><strong>Jabatan:</strong> {{ $employee->jabatan }}</p>
                                <p><strong>Masa Kerja:</strong> {{ $employee->masa_kerja_tahun }} tahun</p>
                                <p><strong>Level Kompetensi:</strong> {{ $employee->level_kompetensi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certifications History -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-certificate me-2"></i>
                    Riwayat Sertifikasi ({{ $employee->trainings->count() }})
                </h5>
                <div>
                    <a href="{{ route('certifications.create') }}?employee_id={{ $employee->id }}"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Sertifikasi
                    </a>
                    <a href="{{ route('certifications.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($employee->trainings->count() > 0)
                    <div class="table-responsive">
                        <table class="employee-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pelatihan</th>
                                    <th>Nama Pelatihan</th>
                                    <th>Level</th>
                                    <th>Lembaga</th>
                                    <th>Tanggal Diterbitkan</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Status</th>
                                    <th>Sertifikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee->trainings as $index => $training)
                                    @php
                                        $issuedDate = \Carbon\Carbon::parse($training->pivot->issued_date);
                                        $expirationDate = \Carbon\Carbon::parse($training->pivot->expiration_date);
                                        $diffDays = (int) $expirationDate->diffInDays(\Carbon\Carbon::now(), false); // negatif jika di masa depan
                                        $diffMonths = (int) $expirationDate->diffInMonths(\Carbon\Carbon::now(), false);

                                        // Samakan aturan dengan halaman index
                                        if ($diffDays >= 0) {
                                            $statusClass = 'danger';
                                            $statusIcon = 'times-circle';
                                            $statusText = 'Kadaluarsa';
                                            $statusDot = 'status-red';
                                        } elseif ($diffDays >= -7 || $diffMonths >= -3) {
                                            $statusClass = 'warning';
                                            $statusIcon = 'exclamation-triangle';
                                            $statusText = 'Segera Habis';
                                            $statusDot = 'status-yellow';
                                        } else {
                                            $statusClass = 'success';
                                            $statusIcon = 'check-circle';
                                            $statusText = 'Aktif';
                                            $statusDot = 'status-green';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $training->code }}</td>
                                        <td>{{ $training->name }}</td>
                                        <td>
                                            <span class="badge bg-info">Level {{ $training->level }}</span>
                                        </td>
                                        <td>{{ $training->institution }}</td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $issuedDate->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $issuedDate->format('l, j F Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $expirationDate->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $expirationDate->format('l, j F Y') }}</small>
                                        </td>
                                        <td>
                                            <span class="status-dot {{ $statusDot }}"></span>
                                            <span class="badge bg-{{ $statusClass }}">
                                                <i class="fas fa-{{ $statusIcon }} me-1"></i>
                                                {{ $statusText }}
                                            </span>
                                            <small class="text-muted d-block">
                                                @php
                                                    $absDays = abs($diffDays);
                                                    $absMonths = abs($diffMonths);
                                                    $suffix = $diffDays < 0 ? 'lagi' : 'lalu';
                                                @endphp
                                                @if ($absDays > 30)
                                                    {{ $absMonths }} bulan {{ $suffix }}
                                                @else
                                                    {{ $absDays }} hari {{ $suffix }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            @if ($training->pivot->certificate_image)
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="showCertificateModal('{{ asset('storage/' . $training->pivot->certificate_image) }}', '{{ $training->name }}')">
                                                    <i class="fas fa-image me-1"></i>
                                                    Lihat
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('certifications.editTraining', [$employee->id, $training->id]) }}"
                                                    class="btn btn-sm btn-warning" title="Edit Sertifikasi">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('certifications.renewTraining', [$employee->id, $training->id]) }}"
                                                    class="btn btn-sm btn-info" title="Perpanjang Sertifikasi">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </a>
                                                <form
                                                    action="{{ route('certifications.destroyTraining', [$employee->id, $training->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikasi ini?')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Hapus Sertifikasi">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-certificate fa-3x mb-3"></i>
                        <h5>Belum Ada Sertifikasi</h5>
                        <p>Karyawan ini belum memiliki sertifikasi pelatihan.</p>
                        <a href="{{ route('certifications.create') }}?employee_id={{ $employee->id }}"
                            class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Tambah Sertifikasi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Certificate Image Modal -->
    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificateModalLabel">Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="certificateImage" src="" alt="Sertifikat" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a id="downloadCertificate" href="" download class="btn btn-primary">
                        <i class="fas fa-download me-1"></i>
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-green {
            background-color: #28a745;
        }

        .status-yellow {
            background-color: #ffc107;
        }

        .status-red {
            background-color: #dc3545;
        }

        .badge {
            font-size: 0.75rem;
        }

        .table td {
            vertical-align: middle;
        }
    </style>

    <script>
        function showCertificateModal(imageUrl, trainingName) {
            document.getElementById('certificateModalLabel').textContent = 'Sertifikat - ' + trainingName;
            document.getElementById('certificateImage').src = imageUrl;
            document.getElementById('downloadCertificate').href = imageUrl;

            const modal = new bootstrap.Modal(document.getElementById('certificateModal'));
            modal.show();
        }
    </script>
@endsection
