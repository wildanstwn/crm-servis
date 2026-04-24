<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all(); // Ambil semua data dari database
        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_wa' => 'required',
            'alamat' => 'required',
        ]);

        Pelanggan::create($request->all());
        return back()->with('success', 'Pelanggan berhasil ditambahkan!');
    }
    // Fungsi untuk menghapus data
    public function destroy($id)
    {
        \App\Models\Pelanggan::destroy($id);
        return back()->with('success', 'Data pelanggan berhasil dihapus!');
    }

    // Fungsi untuk update data (kita pakai cara simpel saja)
    public function update(Request $request, $id)
    {
        $pelanggan = \App\Models\Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }
}