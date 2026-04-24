<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    public function index() {
        $servis = Servis::with(['pelanggan', 'teknisi'])->latest()->get();
        $pelanggan = Pelanggan::all();
        $list_teknisi = \App\Models\User::where('role', 'teknisi')->get(); 
        
        return view('admin.servis.index', compact('servis', 'pelanggan', 'list_teknisi'));
    }

    public function store(Request $request) {
        $request->validate([
            'pelanggan_id' => 'required',
            'user_id'      => 'required',
            'nama_unit'    => 'required',
            'keluhan'      => 'required',
            'tgl_kembali_servis' => 'nullable|date'
        ]);

        Servis::create($request->all());
        return back()->with('success', 'Antrean servis berhasil dibuat!');
    }

    public function update(Request $request, $id) {
        // Dibuat nullable agar teknisi/admin bisa update status tanpa harus isi tgl kembali
        $request->validate([
            'status' => 'required',
            'tgl_kembali_servis' => 'nullable|date' 
        ]);

        $servis = Servis::findOrFail($id);
        $servis->update($request->all());

        return back()->with('success', 'Data pengerjaan berhasil diperbarui!');
    }

    public function destroy($id) {
        Servis::destroy($id);
        return back()->with('success', 'Data servis berhasil dihapus!');
    }

    public function cetakNota($id) {
        $s = Servis::with(['pelanggan', 'teknisi'])->findOrFail($id);
        return view('admin.servis.cetak', compact('s'));
    }
}