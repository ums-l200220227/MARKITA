<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualController extends Controller
{

    public function index()
    {
        // Pengecekan role 'penjual' sebelum melanjutkan
        if (auth()->user()->role !== 'penjual') {
            abort(403, 'Unauthorized action.');
        }

        // Mengambil produk yang dimiliki oleh penjual yang sedang login
        $penjual = Auth::user();
        // $produkPenjual = Product::all();
        $produkPenjual = $penjual->products;
        $products = Product::where('user_id', Auth::id())->get();

        // $produkPenjual = Product::where('user_id', auth()->id())->get();
        // $orders = Order::where('user_id', auth()->id())->get();
        $orders = Order::all(); // Ambil semua order
        return view('penjual.penjualhome', compact('produkPenjual', 'orders'));
    }

    public function showPenjualHome()
    {
        // Assuming you are using Eloquent relationships
        $produkPenjual = auth()->user()->produk; // or another appropriate query based on your setup
        return view('penjual.penjualhome', compact('produkPenjual'));
    }

    public function penjualHome()
    {
        // Cek apakah pengguna adalah penjual
        $user = Auth::user();

        $produkPenjual = Product::where('user_id', auth()->id())->get(); // Pastikan ini benar

        $orders = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
        $product = Product::with('kategori')->where('user_id', auth()->id())->get();

        return view('penjual.penjualhome', compact('produkPenjual', 'orders'));
    }

    public function create()
    {
        // Pengecekan role 'penjual' sebelum melanjutkan
        if (auth()->user()->role !== 'penjual') {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all(); // Ambil semua kategori

        return view('penjual.tambah', compact('categories'));
    }

    public function store(Request $request)
    {
        // Pengecekan role 'penjual' sebelum melanjutkan
        if (auth()->user()->role !== 'penjual') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi data produk yang akan disimpan
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            // 'user_id' => auth()->id(),
        ]);

        dd($request->all());

        // Menyimpan produk yang ditambahkan oleh penjual
        $product = new Product();
        $product->user_id = Auth::id();
        $product->kategori_id = $request->kategori_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('images');
        }

        // Menyimpan produk ke dalam database
        $product->save();

        if ($product->save()) {
            return redirect()->route('penjual.penjualhome')->with('success', 'Produk berhasil ditambahkan');
        } else {
            return redirect()->route('penjual.penjualhome')->with('error', 'Produk gagal ditambahkan');
        }


        // Redirect ke dashboard penjual dengan pesan sukses
        // return redirect()->route('penjual.penjualhome')->with('success', 'Produk berhasil ditambahkan');
    }




    // Rute lain seperti show, edit, update, destroy, dsb.
}
