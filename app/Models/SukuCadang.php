<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SukuCadang extends Model
{
    protected $table = 'suku_cadang';
    protected $fillable = ['nama_part', 'stok'];

    public function servis()
    {
        return $this->belongsToMany(Servis::class, 'servis_suku_cadang', 'suku_cadang_id', 'servis_id')
                    ->withPivot('jumlah') // Mengambil kolom 'jumlah' dari tabel pivot
                    ();
    }
}