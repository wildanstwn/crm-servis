<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminNotificationController extends Controller
{
    public function index()
    {
        // Logika: Status sudah 'Selesai' 
        // DAN tanggal hari ini >= tgl_kembali_servis
        $maintenance = Servis::with('pelanggan')
            ->where('status', 'Selesai')
            ->whereNotNull('tgl_kembali_servis') // Pastikan tanggal kembalinya diisi
            ->whereDate('tgl_kembali_servis', '<=', Carbon::today()) 
            ->latest('tgl_kembali_servis') // Urutkan berdasarkan jadwal terdekat
            ->get();

        return view('admin.notifikasi.index', compact('maintenance'));
    }
}