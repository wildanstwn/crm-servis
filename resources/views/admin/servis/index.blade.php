@extends('layouts.admin')

@section('title', 'Manajemen Servis & CRM')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
                    <li class="breadcrumb-item" aria-current="page">Jadwal Servis</li>
                </ul>
                <h2 class="mb-0">Antrean Servis Aktif</h2>
                <p class="text-muted text-sm">Monitoring pengerjaan unit dan penjadwalan CRM.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-0 py-3">
                <h5 class="mb-0">Daftar Riwayat & Antrean</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="ti ti-plus me-1"></i> Tambah Antrean
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Unit / Keluhan</th>
                                <th>Pelanggan</th>
                                <th>Teknisi</th> 
                                <th>Status</th>
                                <th>Jadwal Kembali</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servis as $s)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">{{ $s->nama_unit }}</span><br>
                                    <small class="text-muted">{{ Str::limit($s->keluhan, 40) }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $s->pelanggan->nama }}</div>
                                    <small class="text-success">{{ $s->pelanggan->no_wa }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-user-cog me-2 text-primary"></i>
                                        <span class="small">{{ $s->teknisi->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $color = ['Masuk'=>'secondary','Proses'=>'warning','Selesai'=>'success','Diambil'=>'primary'][$s->status] ?? 'info';
                                    @endphp
                                    <span class="badge bg-light-{{ $color }} text-{{ $color }}">{{ $s->status }}</span>
                                </td>
                                <td>
                                    @if($s->tgl_kembali_servis)
                                        <small class="text-muted"><i class="ti ti-calendar-time me-1"></i>{{ \Carbon\Carbon::parse($s->tgl_kembali_servis)->format('d M Y') }}</small>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}"><i class="ti ti-edit"></i></button>
                                        <form action="/admin/jadwal/{{ $s->id }}" method="POST" onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger btn-icon"><i class="ti ti-trash"></i></button>
                                        </form>
                                        <a href="{{ route('admin.jadwal.cetak', $s->id) }}" target="_blank" class="btn btn-sm btn-light-secondary btn-icon"><i class="ti ti-printer"></i></a>
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

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/jadwal" method="POST" class="modal-content">
            @csrf
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Input Servis Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Pelanggan</label>
                    <select name="pelanggan_id" class="form-select shadow-none" required>
                        <option value="">-- Pilih --</option>
                        @foreach($pelanggan as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Teknisi</label>
                    <select name="user_id" class="form-select shadow-none" required>
                        <option value="">-- Pilih --</option>
                        @foreach($list_teknisi as $tek)
                            <option value="{{ $tek->id }}">{{ $tek->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Unit & Keluhan</label>
                    <input type="text" name="nama_unit" class="form-control mb-2" placeholder="Nama Unit" required>
                    <textarea name="keluhan" class="form-control" rows="2" placeholder="Keluhan..." required></textarea>
                </div>
                <hr>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="sw_tambah" onchange="toggleCrm(this, 'wr_tambah', 'in_tambah')">
                    <label class="form-check-label fw-bold small" for="sw_tambah">Aktifkan CRM?</label>
                </div>
                <div id="wr_tambah" style="display: none;" class="mt-2">
                    <label class="form-label small text-primary">Jadwal Servis Rutin</label>
                    <input type="date" name="tgl_kembali_servis" id="in_tambah" class="form-control">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100">Simpan Antrean</button>
            </div>
        </form>
    </div>
</div>

@foreach($servis as $s)
<div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/admin/jadwal/{{ $s->id }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Update Pengerjaan: {{ $s->nama_unit }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Status & Teknisi</label>
                    <select name="status" class="form-select mb-2">
                        <option value="Masuk" {{ $s->status=='Masuk'?'selected':'' }}>Masuk</option>
                        <option value="Proses" {{ $s->status=='Proses'?'selected':'' }}>Proses</option>
                        <option value="Selesai" {{ $s->status=='Selesai'?'selected':'' }}>Selesai</option>
                        <option value="Diambil" {{ $s->status=='Diambil'?'selected':'' }}>Diambil</option>
                    </select>
                    <select name="user_id" class="form-select">
                        @foreach($list_teknisi as $tek)
                            <option value="{{ $tek->id }}" {{ $s->user_id==$tek->id?'selected':'' }}>{{ $tek->name }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="sw_edit_{{ $s->id }}" 
                           onchange="toggleCrm(this, 'wr_edit_{{ $s->id }}', 'in_edit_{{ $s->id }}')" 
                           {{ $s->tgl_kembali_servis ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="sw_edit_{{ $s->id }}">Pengingat Servis Rutin (CRM)</label>
                </div>
                <div id="wr_edit_{{ $s->id }}" style="display: {{ $s->tgl_kembali_servis ? 'block' : 'none' }};" class="mt-2">
                    <label class="form-label small text-primary">Target Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali_servis" id="in_edit_{{ $s->id }}" 
                           class="form-control" value="{{ $s->tgl_kembali_servis }}">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
            </div>
        </form>
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