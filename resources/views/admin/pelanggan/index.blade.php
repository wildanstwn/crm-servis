@extends('layouts.admin')

@section('title', 'Data Pelanggan')

@section('content')
<div class="row">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
                        <li class="breadcrumb-item" aria-current="page">Pelanggan</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Pelanggan</h2>
                        <p class="text-muted">Kelola data pelanggan dan informasi kontak Cahaya Mandiri Audio.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5>Tambah Pelanggan</h5></div>
            <div class="card-body">
                <form action="/admin/pelanggan" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control" placeholder="628123xxx" required>
                        <small class="text-muted">Gunakan format 62 (Tanpa + atau 0)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Pelanggan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5>Daftar Pelanggan Cahaya Mandiri</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>WhatsApp</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelanggan as $p)
                            <tr>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->no_wa }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">
                                            <i class="ti ti-edit"></i>
                                        </button>

                                        <form action="/admin/pelanggan/{{ $p->id }}" method="POST" onsubmit="return confirm('Yakin mau hapus pelanggan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger btn-icon">
                                                <i class="ti ti-trash"></i>
                                            </button>
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

@foreach($pelanggan as $p)
<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/pelanggan/{{ $p->id }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="text" name="no_wa" class="form-control" value="{{ $p->no_wa }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required>{{ $p->alamat }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection