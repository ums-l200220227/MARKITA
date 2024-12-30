<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{   
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('products')->first();

        return view('cart.index', compact('cart'));
    }


    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            $order->products()->attach($item->product_id, ['quantity' => $item->quantity]);
        }

        // Kosongkan keranjang
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'product_id' => 'required|exists:produk,id',
        // ]);

        // $cart = Cart::firstOrCreate(
        //     ['user_id' => auth()->id()],
        //     ['total_price' => 0, 'status' => 'active']
        // );

        // $cart->products()->attach($request->product_id, ['quantity' => 1]);

        try {
            // Validasi input
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            // Buat keranjang jika belum ada, lalu tambahkan produk
            $keranjang = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $keranjang->products()->attach($request->product_id, ['quantity' => 1]);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }


        // return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

}
