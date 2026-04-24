@extends('layouts.admin')

@section('title', 'Dashboard Admin | CRM Cahaya Mandiri')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h2 class="mb-0">Ikhtisar Bisnis</h2>
                <p class="text-muted">Pantau performa servis dan stok suku cadang secara real-time.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card bg-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-primary"><i class="ti ti-tool text-primary f-20"></i></div>
                    <h6 class="mb-0 ms-2">Total Servis</h6>
                </div>
                <div class="row align-items-center">
                    <div class="col-7">
                        <div id="spark-servis" style="min-height: 50px;"></div> </div>
                    <div class="col-5 text-end">
                        <h4 class="mb-0">{{ $totalServis }}</h4>
                        <small class="text-primary">Unit</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-warning"><i class="ti ti-users text-warning f-20"></i></div>
                    <h6 class="mb-0 ms-2">Pelanggan</h6>
                </div>
                <div class="row align-items-center">
                    <div class="col-7">
                        <div id="spark-pelanggan" style="min-height: 50px;"></div> </div>
                    <div class="col-5 text-end">
                        <h4 class="mb-0">{{ $totalPelanggan }}</h4>
                        <small class="text-warning">Orang</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-success"><i class="ti ti-circle-check text-success f-20"></i></div>
                    <h6 class="mb-0 ms-2">Unit Selesai</h6>
                </div>
                <div class="row align-items-center">
                    <div class="col-7">
                        <div id="spark-selesai" style="min-height: 50px;"></div> </div>
                    <div class="col-5 text-end">
                        <h4 class="mb-0">{{ $unitSelesai }}</h4>
                        <small class="text-success">Berhasil</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-danger"><i class="ti ti-package text-danger f-20"></i></div>
                    <h6 class="mb-0 ms-2">Suku Cadang</h6>
                </div>
                <div class="row align-items-center">
                    <div class="col-7">
                        <div id="spark-part" style="min-height: 50px;"></div> </div>
                    <div class="col-5 text-end">
                        <h4 class="mb-0">{{ $totalPartTerpakai }}</h4>
                        <small class="text-danger">Terpakai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 bg-transparent">
                <h5>Statistik Servis Bulanan ({{ date('Y') }})</h5>
            </div>
            <div class="card-body">
                <div id="chart-servis-besar" style="min-height: 350px;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Konfigurasi Grafik Kecil (Sparkline)
    var sparkOptions = {
        chart: { type: 'bar', height: 50, sparkline: { enabled: true } },
        plotOptions: { bar: { columnWidth: '80%', borderRadius: 2 } },
        tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
    };

    // Render 4 Grafik Kecil
    new ApexCharts(document.querySelector("#spark-servis"), {...sparkOptions, colors: ['#04A9F5'], series: [{data: {!! json_encode($trenServis) !!}}] }).render();
    new ApexCharts(document.querySelector("#spark-pelanggan"), {...sparkOptions, colors: ['#E58A00'], series: [{data: {!! json_encode($trenPelanggan) !!}}] }).render();
    new ApexCharts(document.querySelector("#spark-selesai"), {...sparkOptions, colors: ['#2CA87F'], series: [{data: {!! json_encode($trenSelesai) !!}}] }).render();
    new ApexCharts(document.querySelector("#spark-part"), {...sparkOptions, colors: ['#DC2626'], series: [{data: {!! json_encode($trenPart) !!}}] }).render();

    // 2. Grafik Besar Bulanan
    var optionsBesar = {
        chart: { height: 350, type: 'area', toolbar: { show: false } },
        colors: ["#04A9F5"],
        series: [{ name: "Jumlah Servis", data: {!! json_encode($listTotal) !!} }],
        stroke: { curve: 'smooth', width: 3 },
        xaxis: { categories: {!! json_encode($listBulan) !!} }
    };
    new ApexCharts(document.querySelector("#chart-servis-besar"), optionsBesar).render();
});
</script>
@endsection