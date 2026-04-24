@extends('layouts.teknisi')

@section('title', 'Riwayat Pekerjaan Selesai')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/teknisi/dashboard">Teknisi</a></li>
                    <li class="breadcrumb-item" aria-current="page">Riwayat Selesai</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Riwayat Pekerjaan Selesai</h2>
                    <p class="text-muted">Pantau semua unit yang telah Anda perbaiki dengan sukses.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Arsip Unit Selesai</h5>
                <span class="badge bg-light-success text-success">{{ count($riwayat) }} Unit Berhasil Diperbaiki</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal Selesai</th>
                                <th>Unit / Merk</th>
                                <th>Pelanggan</th>
                                <th>Status Akhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                            <tr>
                                <td>
                                    <i class="ti ti-calendar-check me-1 text-success"></i>
                                    {{ $r->updated_at->format('d/m/Y') }}
                                </td>
                                <td><b>{{ $r->nama_unit }}</b></td>
                                <td>{{ $r->pelanggan->nama }}</td>
                                <td>
                                    @if($r->status == 'Selesai')
                                        <span class="badge bg-light-success text-success">Selesai</span>
                                    @else
                                        <span class="badge bg-light-primary text-primary">Sudah Diambil</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $r->id }}">
                                        <i class="ti ti-eye me-1 f-18"></i> Lihat Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center p-5 text-muted">
                                    <i class="ti ti-database-off f-30 d-block mb-2"></i>
                                    Belum ada unit yang diselesaikan. Semangat bekerja!
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

@foreach($riwayat as $r)
<div class="modal fade" id="modalDetail{{ $r->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Servis: {{ $r->nama_unit }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold text-primary">Informasi Unit & Pelanggan</label>
                        <div class="p-3 bg-gray-100 rounded">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td width="100">Pelanggan</td><td>: {{ $r->pelanggan->nama }}</td></tr>
                                <tr><td>Unit</td><td>: {{ $r->nama_unit }}</td></tr>
                                <tr><td>Tgl Masuk</td><td>: {{ $r->created_at->format('d M Y') }}</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Keluhan Awal:</label>
                        <p class="text-muted border-start border-4 ps-2">{{ $r->keluhan }}</p>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-success">Catatan Perbaikan Teknisi:</label>
                        <div class="p-3 bg-light-success rounded border border-success border-opacity-25">
                            {{ $r->catatan_teknisi ?? 'Teknisi tidak meninggalkan catatan.' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection