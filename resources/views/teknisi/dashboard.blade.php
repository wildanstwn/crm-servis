@extends('layouts.teknisi')

@section('title', 'Dashboard Teknisi | CRM Cahaya Mandiri')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h2 class="mb-0">Halo, {{ Auth::user()->name }}!</h2>
                <p class="text-muted text-sm">Berikut adalah ringkasan beban kerja kamu hari ini.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @php
        $cards = [
            ['id' => 'spark-aktif', 'title' => 'Tugas Aktif', 'val' => $tugasAktif, 'unit' => 'Unit', 'color' => 'primary', 'icon' => 'ti-clipboard-list'],
            ['id' => 'spark-selesai', 'title' => 'Selesai (Bulan Ini)', 'val' => $selesaiBulanIni, 'unit' => 'Unit', 'color' => 'success', 'icon' => 'ti-circle-check'],
            ['id' => 'spark-pending', 'title' => 'Menunggu Part', 'val' => $pendingPart, 'unit' => 'Pending', 'color' => 'danger', 'icon' => 'ti-alert-circle'],
            ['id' => 'spark-part', 'title' => 'Part Terpasang', 'val' => $partDigunakan, 'unit' => 'Komponen', 'color' => 'warning', 'icon' => 'ti-package'],
        ];
    @endphp

    @foreach($cards as $c)
    <div class="col-md-6 col-xl-3">
        <div class="card bg-white border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <div class="avtar avtar-s bg-light-{{ $c['color'] }} flex-shrink-0">
                        <i class="ti {{ $c['icon'] }} text-{{ $c['color'] }} f-18"></i>
                    </div>
                    <h6 class="mb-0 ms-2 text-muted fw-normal">{{ $c['title'] }}</h6>
                </div>
                
                <div class="d-flex align-items-end justify-content-between mt-2">
                    <div id="{{ $c['id'] }}" style="width: 90px; min-height: 45px;"></div>
                    <div class="text-end">
                        <h3 class="mb-0 fw-bold">{{ $c['val'] }}</h3>
                        <small class="text-{{ $c['color'] }}" style="font-size: 11px;">{{ $c['unit'] }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-0 py-3">
                <h5 class="mb-0">Prioritas Kerja (Unit Terlama)</h5>
                <a href="{{ route('teknisi.jadwal.index') }}" class="btn btn-sm btn-light-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Pelanggan</th>
                                <th>Lama Menginap</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prioritas as $p)
                            <tr>
                                <td><span class="fw-bold">{{ $p->nama_unit }}</span></td>
                                <td>{{ $p->pelanggan->nama }}</td>
                                <td>{{ $p->created_at->diffForHumans() }}</td>
                                <td><span class="badge bg-light-warning text-warning">{{ $p->status }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var sparkOptions = {
        chart: { type: 'bar', height: 45, width: 90, sparkline: { enabled: true } },
        plotOptions: { bar: { columnWidth: '80%', borderRadius: 2 } },
        tooltip: { enabled: false }
    };

    new ApexCharts(document.querySelector("#spark-aktif"), {...sparkOptions, colors: ['#04A9F5'], series: [{data: [5, 8, 4, 10, 7, 12, 9]}] }).render();
    new ApexCharts(document.querySelector("#spark-selesai"), {...sparkOptions, colors: ['#2CA87F'], series: [{data: [2, 5, 3, 7, 6, 10, 8]}] }).render();
    new ApexCharts(document.querySelector("#spark-pending"), {...sparkOptions, colors: ['#DC2626'], series: [{data: [1, 3, 2, 4, 3, 5, 4]}] }).render();
    new ApexCharts(document.querySelector("#spark-part"), {...sparkOptions, colors: ['#E58A00'], series: [{data: [10, 20, 15, 25, 20, 30, 25]}] }).render();
});
</script>
@endsection