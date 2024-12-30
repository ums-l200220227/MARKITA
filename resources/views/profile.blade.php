@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold mb-6">Keranjang Anda</h1>
    @if($cart && $cart->products->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cart->products as $product)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p>Jumlah: {{ $product->pivot->quantity }}</p>
                </div>
            @endforeach
        </div>
        <a href="{{ route('checkout') }}" class="bg-blue-500 text-white px-6 py-2 rounded mt-6">Lanjutkan ke Checkout</a>
    @else
        <p class="text-gray-500">Keranjang Anda kosong.</p>
    @endif
</div>
@endsection
