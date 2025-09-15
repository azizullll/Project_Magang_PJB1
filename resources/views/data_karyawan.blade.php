@extends('layouts/layout')

@section('title', 'Data Karyawan')

@section('content')


 <!-- Main Content Card -->
    <div class="main-content-card">
        <div class="content-header" style="display:flex;flex-direction:column;align-items:flex-start;gap:12px;margin-bottom:18px;">
            <h2 class="content-title" style="margin:0;">Manajemen Data Karyawan</h2>
            <div style="display:flex;align-items:center;gap:10px;">
                <form action="{{ route('employees.index') }}" method="get" style="display:flex;align-items:center;gap:8px;">
                    <input type="text" name="q" placeholder="Cari karyawan..." value="{{ request('q') }}" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:8px;outline:none;min-width:220px;">
                    <button type="submit" style="padding:9px 14px;border:none;background:#1e40af;color:#fff;border-radius:8px;cursor:pointer;">Search</button>
                </form>
                <a href="{{ route('employees.create') }}" style="padding:9px 14px;border:none;background:#16a34a;color:#fff;border-radius:8px;text-decoration:none;">+ Tambah Data Karyawan</a>
            </div>
        </div>

    <table class="employee-table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Divisi</th>
                <th>Masa Kerja</th>
                <th>Sertifikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>123456</td>
                <td>Andi Saputra</td>
                <td>Software Engineer</td>
                <td>IT</td>
                <td>3 Tahun</td>
                <td>Laravel, Flutter</td>
                <td>
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
