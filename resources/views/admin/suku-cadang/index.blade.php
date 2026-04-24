@extends('layouts.admin')

@section('title', 'Stok Suku Cadang')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
                    <li class="breadcrumb-item" aria-current="page">Suku Cadang</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Inventaris Suku Cadang</h2>
                    <p class="text-muted">Kelola ketersediaan stok komponen audio di gudang.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Stok</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="ti ti-plus me-1"></i> Tambah Baru
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>Nama Barang</th>
                                <th class="text-center">Jumlah Stok</th>
                                <th>Terakhir Update</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stok as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="fw-bold text-dark">{{ $s->nama_part }}</span></td>
                                <td class="text-center">
                                    @if($s->stok <= 5)
                                        <span class="badge bg-light-danger text-danger">{{ $s->stok }} (Hampir Habis)</span>
                                    @else
                                        <span class="badge bg-light-success text-success">{{ $s->stok }}</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $s->updated_at->format('d/m/Y H:i') }}</small></td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-sm btn-light-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.suku_cadang.destroy', $s->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-sm btn-light-danger rounded-circle" onclick="return confirm('Hapus barang ini?')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center p-5 text-muted">Belum ada data suku cadang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.suku_cadang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Suku Cadang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Suku Cadang</label>
                        <input type="text" name="nama_part" class="form-control border-primary shadow-none" placeholder="Contoh: Elco 4700uF" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Stok Awal</label>
                        <input type="number" name="stok" class="form-control border-primary shadow-none" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($stok as $s)
<div class="modal fade" id="modalEdit{{ $s->id }}" aria-hidden="true" aria-labelledby="modalEditLabel{{ $s->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.suku_cadang.update', $s->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data: {{ $s->nama_part }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Suku Cadang</label>
                        <input type="text" name="nama_part" class="form-control border-primary shadow-none" value="{{ $s->nama_part }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Stok Saat Ini</label>
                        <input type="number" name="stok" class="form-control border-primary shadow-none" value="{{ $s->stok }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection