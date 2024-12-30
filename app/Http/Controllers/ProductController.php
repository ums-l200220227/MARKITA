<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create()
    {
        // Pastikan data yang diperlukan diambil dengan benar
        $categories = Category::all(); // Contoh pengambilan data kategori
        return view('penjual.tambah', compact('categories'));
    }

    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        // Proses penyimpanan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        } else {
            $imagePath = null;
        }

        // Simpan produk baru
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath ?? null,
            'kategori_id' => $request->kategori_id,
            'user_id' => auth()->id(),  // Menyimpan ID user yang sedang login
        ]);


        return redirect()->route('penjual.penjualhome')->with('success', 'Produk berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.products.edit', compact('product'));
    }

    public function editPenjual($id)
    {
        // Ambil produk yang sesuai dengan id dan milik penjual yang sedang login
        $product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('penjual.edit_penjual', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }


    public function showUserHome()
    {
        // Ambil semua kategori dari database
        $categories = Category::all();

        // Kirim data kategori ke view userHome
        return view('userHome', compact('categories')); // Ganti 'category' menjadi 'categories'
    }


    public function updatePenjual(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Ambil produk yang sesuai dengan id dan milik penjual yang sedang login
        $product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Update data produk
        $product->update($validated);

        // Redirect ke halaman lain dengan pesan sukses
        return redirect()->route('penjualhome')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy_penjual($id)
    {
        // Cek apakah produk ada dan milik penjual yang sedang login
        $product = Product::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$product) {
            return redirect()->route('penjualhome')->with('error', 'Produk tidak ditemukan atau bukan milik Anda.');
        }

        // Hapus produk
        $product->delete();

        return redirect()->route('penjualhome')->with('success', 'Produk berhasil dihapus.');
    }

    public function showOrders()
    {
        $orders = Order::where('status', 'pending')->get(); // Pesanan yang belum diproses
        return view('penjual.orders.index', compact('orders'));
    }

}
