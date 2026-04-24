@extends('layouts.admin')

@section('title', 'Manajemen Teknisi')

@section('content')
<div class="row">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
                        <li class="breadcrumb-item" aria-current="page">Teknisi</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Teknisi</h2>
                        <p class="text-muted">Kelola akun tim lapangan dan pantau performa teknisi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header"><h5>Tambah Akun Teknisi</h5></div>
            <div class="card-body">
                <form action="/admin/teknisi-list" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama teknisi..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email / Username</label>
                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftarkan Teknisi</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header"><h5>Daftar Teknisi Cahaya Mandiri</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Teknisi</th>
                                <th>Email</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $u->email }}</td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-light-primary btn-icon" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditTeknisi{{ $u->id }}">
                                            <i class="ti ti-edit"></i>
                                        </button>

                                        <form action="/admin/teknisi-list/{{ $u->id }}" method="POST" onsubmit="return confirm('Hapus akun teknisi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger btn-icon"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($users as $u)
<div class="modal fade" id="modalEditTeknisi{{ $u->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/teknisi-list/{{ $u->id }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Akun: {{ $u->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email / Username</label>
                    <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                </div>
                <div class="mb-3 border-top pt-3">
                    <label class="form-label text-danger fw-bold">Ganti Password (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Isi hanya jika ingin ganti password">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password lama.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection