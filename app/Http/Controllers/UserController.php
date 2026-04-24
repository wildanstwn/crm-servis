<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        // Ambil hanya user yang rolenya teknisi
        $users = User::where('role', 'teknisi')->get();
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teknisi', // Otomatis set jadi teknisi
        ]);

        return back()->with('success', 'Teknisi baru berhasil didaftarkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya update password jika input password diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data teknisi berhasil diperbarui!');
    }

    public function destroy($id) {
        User::destroy($id);
        return back()->with('success', 'Akun teknisi telah dihapus.');
    }
}