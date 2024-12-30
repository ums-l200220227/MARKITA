<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan semua pengguna, hanya bisa diakses oleh admin
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403); // 403 Forbidden
        }

        $users = User::all();
        return response()->json($users);
    }

    // Menampilkan detail pengguna, bisa diakses oleh admin atau pengguna itu sendiri
    public function show($id)
    {
        $user = User::find($id);

        if (!$user || (Auth::id() !== $id && Auth::user()->role !== 'admin')) {
            return response()->json(['message' => 'User not found or unauthorized'], 404);
        }

        return response()->json($user);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Fungsi untuk memperbarui data pengguna
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Cari pengguna berdasarkan ID dan update data
        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        // Redirect kembali dengan pesan sukses
        return redirect()->route('adminhome', $user->id)->with('success', 'User updated successfully');
    }
    // Menghapus pengguna, hanya bisa dilakukan oleh admin
    public function destroy($id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus semua role yang dimiliki oleh pengguna sebelum menghapus pengguna
        $user->removeRole($user->getRoleNames());

        // Hapus pengguna
        $user->delete();

        // Setelah berhasil menghapus, redirect ke daftar pengguna
        return redirect()->route('adminhome')->with('success', 'User deleted successfully!');
    }  

}
