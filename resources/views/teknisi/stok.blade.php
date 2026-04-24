@extends('layouts.teknisi')

@section('title', 'Cek Stok Suku Cadang')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="/teknisi/dashboard">Teknisi</a></li>
                    <li class="breadcrumb-item" aria-current="page">Inventaris</li>
                </ul>
                <h2 class="mb-0">Cek Stok Suku Cadang</h2>
                <p class="text-muted text-sm">Cari komponen audio yang tersedia di gudang.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-5">
        <form action="{{ route('teknisi.stok.index') }}" method="GET">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-0">
                    <i class="ti ti-search text-primary f-20"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 ps-0 py-2" 
                       placeholder="Ketik nama atau kode part..." value="{{ request('search') }}">
                <button class="btn btn-primary px-4" type="submit">Cari Barang</button>
            </div>
        </form>
    </div>
    <div class="col-md-auto d-flex align-items-center">
        @if(request('search'))
            <a href="{{ route('teknisi.stok.index') }}" class="btn btn-light-danger btn-sm rounded-pill">
                <i class="ti ti-refresh me-1"></i> Reset Pencarian
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Nama Suku Cadang</th>
                                <th class="text-center">Jumlah Stok</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Update Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stok as $s)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-secondary me-2">
                                            <i class="ti ti-package text-dark f-18"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $s->nama_part }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <h5 class="mb-0">{{ $s->stok }}</h5>
                                </td>
                                <td>
                                    @if($s->stok == 0)
                                        <span class="badge bg-light-danger text-danger">Stok Habis</span>
                                    @elseif($s->stok <= 5)
                                        <span class="badge bg-light-warning text-warning">Hampir Habis</span>
                                    @else
                                        <span class="badge bg-light-success text-success">Tersedia</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 text-muted">
                                    <small>{{ $s->updated_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <i class="ti ti-package-off f-40 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">Barang <b>"{{ request('search') }}"</b> tidak ada di gudang.</h5>
                                    <a href="{{ route('teknisi.stok.index') }}" class="btn btn-primary btn-sm mt-2">Lihat Semua Stok</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection