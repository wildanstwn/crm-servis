<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis_orders'; // Sesuai tabel SQL kita di awal
    protected $fillable = ['pelanggan_id', 'user_id', 'nama_unit', 'keluhan', 'status', 'tgl_kembali_servis'];

    // Relasi ke Pelanggan (Satu servis milik satu pelanggan)
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class);
    }
    public function teknisi()
    {
        // Kita hubungkan ke model User melalui kolom user_id
        return $this->belongsTo(User::class, 'user_id');
    }
    // Hubungan ke tabel Suku Cadang
    public function suku_cadang()
    {
        return $this->belongsToMany(SukuCadang::class, 'servis_suku_cadang', 'servis_id', 'suku_cadang_id')
                    ->withPivot('jumlah') // Sangat penting untuk mencatat berapa yang dipakai
                    ;
    }
}