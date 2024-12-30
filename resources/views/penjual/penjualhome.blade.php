<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <x-header></x-header>
    <section class="container mx-auto p-4">
        <div class="grid grid-cols-2">
            <h2 class="flex text-2xl font-semibold mb-4">Pengelolaan Produk</h2>
            <div class="flex flex-row-reverse">
                <button type="button" onclick="window.location='{{route('tambah')}}'"
                    class="bg-black text-white border-stone-600 mx-8 my-2">
                    tambahkan produk
                </button>
            </div>
        </div>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Nama Produk</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Harga</th>
                    <th class="px-4 py-2 text-left">Stok</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkPenjual as $product)
                    <tr>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->kategori ? $product->kategori->name:'tidak ada kategory' }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($product->price) }}</td>
                        <td class="px-4 py-2">{{ $product->stock }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('penjual.edit_penjual', $product->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('penjual.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-3xl font-semibold text-center mb-10 mt-12">Pesanan Anda</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($orders as $order)
                <div class="bg-white shadow-md rounded-lg p-5">
                    <h3 class="text-xl font-semibold">{{ $order->product->name }}</h3>
                    <p class="text-gray-500">Pembeli: {{ $order->buyer->name }}</p>
                    <p class="text-gray-500">Status: {{ $order->status }}</p>
                    <div class="mt-4">
                        @if ($order->status == 'pending')
                            <form action="{{ route('order.accept', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Terima
                                    Pesanan</button>
                            </form>
                            <form action="{{ route('order.reject', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Tolak
                                    Pesanan</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</body>

</html>
