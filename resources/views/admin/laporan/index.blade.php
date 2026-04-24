@extends('layouts.admin')

@section('title', 'Laporan Servis | CRM Cahaya Mandiri')

@section('content')
<div class="page-header d-print-none">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h2 class="mb-0">Laporan Operasional</h2>
                <p class="text-muted">Rekapitulasi data servis dan penggunaan suku cadang.</p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4 d-print-none">
    <div class="card-body">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold small">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small">Status Unit</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Proses" {{ $status == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Diambil" {{ $status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="ti ti-filter me-1"></i> Filter</button>
                <button type="button" onclick="window.print()" class="btn btn-light-secondary px-3"><i class="ti ti-printer"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="d-none d-print-block p-4 text-center">
            <h3 class="mb-1">LAPORAN SERVIS CAHAYA MANDIRI AUDIO & ELEKTRONIK</h3>
            <p class="mb-0">Periode: {{ date('d M Y', strtotime($start_date)) }} s/d {{ date('d M Y', strtotime($end_date)) }}</p>
            <hr>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tgl Masuk</th>
                        <th>Unit / Merk</th>
                        <th>Pelanggan</th>
                        <th>Teknisi</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-end">Suku Cadang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $l)
                    <tr>
                        <td class="ps-4">{{ $l->created_at->format('d/m/Y') }}</td>
                        <td><span class="fw-bold">{{ $l->nama_unit }}</span></td>
                        <td>{{ $l->pelanggan->nama }}</td>
                        <td>{{ $l->teknisi->name ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $l->status == 'Selesai' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }}">
                                {{ $l->status }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            @foreach($l->suku_cadang as $s)
                                <div class="small text-muted">{{ $s->nama_part }} ({{ $s->pivot->jumlah }})</div>
                            @endforeach
                            @if($l->suku_cadang->isEmpty()) - @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-5 text-muted">Data tidak ditemukan untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    body { background-color: #ffffff !important; font-size: 12px; }
    .pc-sidebar, .pc-header, .page-header, .pc-footer, .btn-print-hide { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection