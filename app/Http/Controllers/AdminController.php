<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Pelanggan;
use App\Models\SukuCadang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Data Angka Utama
        $totalServis = Servis::count();
        $totalPelanggan = Pelanggan::count();
        $unitSelesai = Servis::where('status', 'Selesai')->count();
        $totalPartTerpakai = DB::table('servis_suku_cadang')->sum('jumlah') ?? 0;

        // 2. Data Tren untuk Grafik Kecil (Sparkline) 
        // Ini contoh data 7 titik agar grafik meliuk cantik
        $trenServis = [12, 18, 15, 25, 20, 32, 28];
        $trenPelanggan = [5, 12, 8, 15, 10, 20, 15];
        $trenSelesai = [3, 8, 5, 12, 9, 18, 14];
        $trenPart = [15, 30, 25, 40, 35, 50, 45];

        // 3. Data Grafik Besar (Bulanan)
        $grafikData = Servis::select(
                DB::raw('COUNT(*) as total'),
                DB::raw("DATE_FORMAT(created_at, '%M') as bulan"),
                DB::raw('MONTH(created_at) as bulan_num')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan', 'bulan_num')
            ->orderBy('bulan_num', 'ASC')
            ->get();

        $listBulan = $grafikData->pluck('bulan')->toArray();
        $listTotal = $grafikData->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'totalServis', 'totalPelanggan', 'unitSelesai', 'totalPartTerpakai',
            'trenServis', 'trenPelanggan', 'trenSelesai', 'trenPart',
            'listBulan', 'listTotal'
        ));
    }
}