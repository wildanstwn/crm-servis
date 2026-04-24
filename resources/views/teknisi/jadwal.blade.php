@extends('layouts.teknisi')

@section('title', 'Tugas Aktif & Update')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="/teknisi/dashboard">Teknisi</a></li>
                    <li class="breadcrumb-item" aria-current="page">Tugas Aktif</li>
                </ul>
                <h2 class="mb-0">Daftar Tugas Aktif</h2>
                <p class="text-muted text-sm">Kelola progress servis unit pelanggan yang ditugaskan ke Anda.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Meja Kerja Teknisi</h5>
                <span class="badge bg-light-primary text-primary">{{ count($tugas) }} Unit Perlu Dicek</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Unit / Merk</th>
                                <th>Pelanggan</th>
                                <th>Suku Cadang</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $t)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">{{ $t->nama_unit }}</span> <br>
                                    <small class="text-muted">Masuk: {{ $t->created_at->format('d M Y') }}</small>
                                </td>
                                <td>{{ $t->pelanggan->nama }}</td>
                                <td>
                                    @foreach($t->suku_cadang as $part)
                                        <span class="badge bg-light-info text-info mb-1">{{ $part->nama_part }} ({{ $part->pivot->jumlah }})</span>
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $color = ['Masuk'=>'secondary','Proses'=>'warning','Cek Komponen'=>'danger','Selesai'=>'success'][$t->status] ?? 'info';
                                    @endphp
                                    <span class="badge bg-light-{{ $color }} text-{{ $color }}">{{ $t->status }}</span>
                                </td>
                                <td class="text-center pe-4">
                                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $t->id }}">
                                        <i class="ti ti-edit me-1 f-18"></i> Update Progress
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center p-5 text-muted">Semua tugas beres! Tidak ada antrean aktif.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($tugas as $t)
<div class="modal fade" id="modalUpdate{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-start">
            <form action="{{ route('teknisi.jadwal.update', $t->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Update Unit: {{ $t->nama_unit }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Status Pengerjaan</label>
                        <select name="status" class="form-select shadow-none border-primary">
                            <option value="Masuk" {{ $t->status == 'Masuk' ? 'selected' : '' }}>Masuk (Antrean)</option>
                            <option value="Proses" {{ $t->status == 'Proses' ? 'selected' : '' }}>Proses Dikerjakan</option>
                            <option value="Cek Komponen" {{ $t->status == 'Cek Komponen' ? 'selected' : '' }}>Menunggu Part</option>
                            <option value="Selesai" {{ $t->status == 'Selesai' ? 'selected' : '' }}>Selesai / Jadi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Catatan & Diagnosa</label>
                        <textarea name="catatan_teknisi" class="form-control" rows="3" placeholder="Apa kerusakannya?">{{ $t->catatan_teknisi }}</textarea>
                    </div>

                    <hr class="my-3">
                    <h6 class="mb-3 text-primary small fw-bold"><i class="ti ti-package me-1"></i> Penggunaan Suku Cadang</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <select name="suku_cadang_id" class="form-select shadow-none">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($spareparts as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_part }} (Stok: {{ $s->stok }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="number" name="jumlah" class="form-control shadow-none" min="1" value="1">
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="sw_tek_{{ $t->id }}" 
                               onchange="toggleCrm(this, 'wr_tek_{{ $t->id }}', 'in_tek_{{ $t->id }}')" 
                               {{ $t->tgl_kembali_servis ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold small text-primary" for="sw_tek_{{ $t->id }}">Sarankan Servis Rutin (CRM)</label>
                    </div>
                    <div id="wr_tek_{{ $t->id }}" style="display: {{ $t->tgl_kembali_servis ? 'block' : 'none' }};">
                        <label class="form-label small">Target Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali_servis" id="in_tek_{{ $t->id }}" 
                               class="form-control" value="{{ $t->tgl_kembali_servis }}">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    window.toggleCrm = function(checkbox, wrapperId, inputId) {
        const wrapper = document.getElementById(wrapperId);
        const input = document.getElementById(inputId);
        if(checkbox.checked) {
            wrapper.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            wrapper.style.display = 'none';
            input.removeAttribute('required');
            input.value = '';
        }
    }
</script>
@endpush