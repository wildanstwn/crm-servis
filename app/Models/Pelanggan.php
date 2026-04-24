<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan'; // Nama tabel di SQL tadi
    protected $fillable = ['nama', 'no_wa', 'alamat']; // Kolom yang boleh diisi
}