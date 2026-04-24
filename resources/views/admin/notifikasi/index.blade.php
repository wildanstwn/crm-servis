@extends('layouts.admin')

@section('title', 'Jadwal Perawatan Rutin')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
                    <li class="breadcrumb-item" aria-current="page">Maintenance</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Jadwal Perawatan Rutin</h2>
                    <p class="text-muted">Daftar unit yang sudah waktunya dilakukan perawatan berkala (Maintenance).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Unit Perlu Maintenance Berkala</h5>
                <span class="badge bg-light-info text-info">{{ count($maintenance) }} Unit Terdeteksi</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>Unit / Merk</th>
                                <th>Servis Terakhir</th>
                                <th>Status Jadwal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenance as $m)
                            @php
                                // Persiapan nomor WA
                                $no_wa = $m->pelanggan->no_wa;
                                if (str_starts_with($no_wa, '0')) {
                                    $no_wa = '62' . substr($no_wa, 1);
                                }

                                // Draf Pesan Perawatan Rutin
                                $pesan = "Halo *{$m->pelanggan->nama}*,\n\nKami dari *Cahaya Mandiri Audio* ingin mengingatkan bahwa unit *{$m->nama_unit}* Anda sudah waktunya dilakukan *Perawatan Rutin (Maintenance)*.\n\nServis terakhir dilakukan pada tanggal {$m->updated_at->format('d M Y')}. Agar performa barang tetap maksimal dan awet, kami sarankan untuk melakukan pengecekan berkala kembali. 😊\n\nKami tunggu kedatangannya di toko. Terima kasih!";
                                
                                $wa_link = "https://wa.me/{$no_wa}?text=" . urlencode($pesan);
                            @endphp
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $m->pelanggan->nama }}</span><br>
                                    <small class="text-muted">{{ $m->pelanggan->no_wa }}</small>
                                </td>
                                <td><span class="badge bg-light-primary text-primary">{{ $m->nama_unit }}</span></td>
                                <td>{{ $m->updated_at->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $tglKembali = \Carbon\Carbon::parse($m->tgl_kembali_servis)->startOfDay();
                                        $hariIni = \Carbon\Carbon::today();
                                    @endphp

                                    @if($tglKembali->isPast() && !$tglKembali->isToday())
                                        {{-- Jika tanggal sudah lewat kemarin atau sebelumnya --}}
                                        <span class="badge bg-light-danger text-danger fw-bold">
                                            <i class="ti ti-alert-circle me-1"></i> Telat {{ $tglKembali->diffInDays($hariIni) }} Hari
                                        </span>
                                    @elseif($tglKembali->isToday())
                                        {{-- Jika tepat hari ini --}}
                                        <span class="badge bg-light-warning text-warning fw-bold">
                                            <i class="ti ti-clock me-1"></i> Jadwal Hari Ini
                                        </span>
                                    @else
                                        {{-- Jika masih di masa depan --}}
                                        <span class="badge bg-light-success text-success fw-bold">
                                            <i class="ti ti-calendar-check me-1"></i> {{ $tglKembali->diffInDays($hariIni) }} Hari Lagi
                                        </span>
                                    @endif
                                    <br>
                                    <small class="text-muted text-sm">Target: {{ $tglKembali->format('d M Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ $wa_link }}" target="_blank" class="btn btn-info btn-sm d-inline-flex align-items-center">
                                        <i class="ti ti-brand-whatsapp me-1 f-18"></i> Ingatkan Servis
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center p-5 text-muted">
                                    <i class="ti ti-circle-check f-30 d-block mb-2 text-success"></i>
                                    Belum ada unit yang masuk masa maintenance rutin.
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