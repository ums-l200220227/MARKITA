<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'delivery_address' => 'required|string|max:255',
        ]);

        // Hitung total harga
        $totalPrice = 0;
        foreach ($request->cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Buat order
        $order = Order::create([
            'user_id' => $user->id,
            'delivery_address' => $request->delivery_address,
            'total_price' => $totalPrice,
        ]);

        // Tambahkan item ke order
        foreach ($request->cart as $item) {
            Cart::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }
}
