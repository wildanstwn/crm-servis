<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan dengan filter tanggal dan status.
     */
    public function index(Request $request)
    {
        // 1. Ambil input filter dari URL (jika kosong, pakai default)
        // Default: Dari awal bulan ini (Y-m-01) sampai hari ini (Y-m-d)
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));
        $status = $request->get('status');

        // 2. Query data servis dengan relasi yang sudah kita definisikan di Model
        $laporan = Servis::with(['pelanggan', 'teknisi', 'suku_cadang']) // Relasi 'teknisi' sesuai Model kamu
            ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->when($status, function($query) use ($status) {
                // Jika status dipilih, tambahkan filter status
                return $query->where('status', $status);
            })
            ->latest()
            ->get();

        // 3. Kirim data ke view admin/laporan/index.blade.php
        return view('admin.laporan.index', compact('laporan', 'start_date', 'end_date', 'status'));
    }
}