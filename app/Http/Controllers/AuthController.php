<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Pastikan ada file login.blade.php di folder resources/views
        return view('/auth/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showAdminHome()
    {
        // Memeriksa apakah pengguna sudah login dan memiliki peran 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Mengambil semua pengguna
            $users = User::all(); // Atau bisa menggunakoan filter sesuai kebutuhan

            $products = Product::with('kategori')->get();

            // Mengirimkan data pengguna ke view adminhome
            return view('admin.adminhome', compact('users', 'products'));
        }

        // Jika bukan admin, alihkan ke halaman lain
        return redirect()->route('home');
    }

    public function showPenjualHome()
    {
        // Cek apakah pengguna sudah login dan peran pengguna adalah penjual
        if (Auth::check() && Auth::user()->role === 'penjual') {
            // Ambil data produk penjual
            $products = Product::where('user_id', Auth::id())->get();

            $products = Product::with('kategori', 'user')->get();


            $orders = \App\Models\Order::where('seller_id', auth()->id())->get();

            // Ambil semua kategori produk
            $kategori = Category::all(); // Pastikan Anda sudah memiliki model Category

            return view('penjual.penjualhome', compact('products', 'kategori', 'orders')); // Pastikan categories di-pass ke view
        }

        // Jika bukan penjual, alihkan ke halaman lain (misalnya, home)
        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika login berhasil, periksa peran pengguna
            $user = Auth::user(); // Ambil user yang sedang login

            if ($user->role === 'admin') {
                // Arahkan ke halaman admin jika peran adalah admin
                return redirect()->route('adminhome');
            } elseif ($user->role === 'penjual') {
                // Arahkan ke halaman penjual jika peran adalah penjual
                return redirect()->route('penjualhome'); // Ganti 'penjualhome' sesuai dengan rute penjual
            } elseif ($user->role === 'user') {
                // Arahkan ke halaman utama jika peran adalah user
                return redirect()->route('home');
            }
        }

        // Jika login gagal, kembali ke halaman login
        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }



    public function register(Request $request)
    {
        // Validasi data pendaftaran
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:admin,user,penjual', // Validasi role
        ]);

        // Simpan pengguna ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Simpan role
        ]);

        // Redirect ke halaman setelah registrasi sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Menghapus sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/login'); // Redirect ke halaman login setelah logout
    }

}
