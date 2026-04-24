<?php

namespace App\Http\Controllers;

use App\Models\SukuCadang;
use Illuminate\Http\Request;

class SukuCadangController extends Controller
{
    // 1. Tampil (Read)
    public function index() {
        // PERBAIKAN: Nama variabel disamakan dengan yang dipanggil di View ($stok)
        $stok = SukuCadang::all(); 
        return view('admin.suku-cadang.index', compact('stok'));
    }

    // 2. Tambah (Create)
    public function store(Request $request) {
        $request->validate([
            'nama_part' => 'required|string|max:255', 
            'stok'      => 'required|integer|min:0'
        ]);

        // Menggunakan create agar lebih simpel
        SukuCadang::create([
            'nama_part' => $request->nama_part,
            'stok'      => $request->stok
        ]);

        return back()->with('success', 'Suku cadang baru berhasil ditambahkan!');
    }

    // 3. Edit (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_part' => 'required|string|max:255',
            'stok'      => 'required|integer|min:0',
        ]);

        $part = SukuCadang::findOrFail($id);
        
        $part->update([
            'nama_part' => $request->nama_part,
            'stok'      => $request->stok,
        ]);

        return redirect()->back()->with('success', 'Stok ' . $part->nama_part . ' berhasil diperbarui!');
    }

    // 4. Hapus (Delete)
    public function destroy($id) {
        $part = SukuCadang::findOrFail($id);
        $nama = $part->nama_part;
        $part->delete();

        return back()->with('success', 'Suku cadang ' . $nama . ' telah dihapus!');
    }
}