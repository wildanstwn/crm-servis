<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\SukuCadang; // Pastikan ini terpanggil
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    // 1. Tampilan Utama: Daftar Tugas Aktif
    public function index()
    {
        $tugas = Servis::with('pelanggan')
                ->where('user_id', Auth::id())
                ->whereIn('status', ['Masuk', 'Proses', 'Cek Komponen'])
                ->latest()
                ->get();

        // PENTING: Ambil data sparepart untuk ditampilkan di modal dropdown
        $spareparts = SukuCadang::all();

        return view('teknisi.jadwal', compact('tugas', 'spareparts'));
    }

    public function updateDetail(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'catatan_teknisi' => 'nullable',
            'suku_cadang_id' => 'nullable|exists:suku_cadang,id',
            'jumlah' => 'nullable|integer|min:1',
            'tgl_kembali_servis' => 'nullable|date' // Logika CRM Teknisi
        ]);

        $servis = Servis::findOrFail($id);
        
        // 1. Update Status, Catatan, dan Tanggal CRM (Jika diisi teknisi)
        $servis->update([
            'status' => $request->status,
            'catatan_teknisi' => $request->catatan_teknisi,
            'tgl_kembali_servis' => $request->tgl_kembali_servis
        ]);

        // 2. Logika Suku Cadang (Potong Stok Otomatis)
        if ($request->filled('suku_cadang_id')) {
            $part = SukuCadang::findOrFail($request->suku_cadang_id);
            
            if ($part->stok < $request->jumlah) {
                return back()->with('error', 'Stok ' . $part->nama_part . ' tidak mencukupi!');
            }

            // Simpan ke tabel pivot & kurangi stok gudang
            $servis->suku_cadang()->attach($request->suku_cadang_id, ['jumlah' => $request->jumlah]);
            $part->decrement('stok', $request->jumlah);
        }

        return redirect()->back()->with('success', 'Progress dan Rekomendasi CRM berhasil diperbarui!');
    }

    public function riwayat()
    {
        $riwayat = Servis::with('pelanggan')
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['Selesai', 'Diambil'])
                    ->latest()
                    ->get();

        return view('teknisi.riwayat', compact('riwayat'));
    }

    public function stok(Request $request)
    {
        $search = $request->search;
        $stok = SukuCadang::when($search, function($query) use ($search) {
                    return $query->where('nama_part', 'like', "%$search%");
                })
                ->latest()
                ->get();

        return view('teknisi.stok', compact('stok'));
    }

    public function dashboard()
{
    $userId = auth()->id();

    // 1. Data Angka untuk Card (Hanya milik teknisi ini)
    $tugasAktif = \App\Models\Servis::where('user_id', $userId)
                    ->whereIn('status', ['Masuk', 'Proses', 'Cek Komponen'])->count();
    
    $selesaiBulanIni = \App\Models\Servis::where('user_id', $userId)
                        ->where('status', 'Selesai')
                        ->whereMonth('updated_at', date('m'))->count();

    $pendingPart = \App\Models\Servis::where('user_id', $userId)
                    ->where('status', 'Cek Komponen')->count();

    $partDigunakan = \DB::table('servis_suku_cadang')
                    ->join('servis_orders', 'servis_suku_cadang.servis_id', '=', 'servis_orders.id')
                    ->where('servis_orders.user_id', $userId)
                    ->sum('jumlah') ?? 0;

    // 2. Data Tren (Dummy untuk grafik sparkline)
    $trenTugas = [5, 8, 4, 10, 7, 12, 9];
    $trenSelesai = [2, 5, 3, 7, 6, 10, 8];
    $trenPending = [1, 3, 2, 4, 3, 5, 4];
    $trenPart = [10, 20, 15, 25, 20, 30, 25];

    // 3. Daftar Tugas Paling Lama (Prioritas)
    $prioritas = \App\Models\Servis::with('pelanggan')
                    ->where('user_id', $userId)
                    ->whereIn('status', ['Masuk', 'Proses'])
                    ->orderBy('created_at', 'asc')
                    ->limit(5)->get();

    return view('teknisi.dashboard', compact(
        'tugasAktif', 'selesaiBulanIni', 'pendingPart', 'partDigunakan',
        'trenTugas', 'trenSelesai', 'trenPending', 'trenPart', 'prioritas'
    ));
}
}