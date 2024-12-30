<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Produk Ibu Rumah Tangga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-section {
            background-image: url('your-image.jpg');
            /* Ganti dengan URL gambar */
            background-size: cover;
            background-position: center;
            color: white;
            height: 100vh;
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-gray-100">

    <x-header />

    <!-- Hero Section -->
    <section id="home" class="hero-section flex items-center justify-center text-center">
        <div class="bg-black bg-opacity-50 p-10 rounded">
            <h1 class="text-4xl font-bold mb-4">Marketplace Produk Ibu Rumah Tangga</h1>
            <p class="text-xl mb-6">Dukung produk lokal buatan ibu rumah tangga</p>
            <a href="#" class="bg-blue-500 text-white px-6 py-2 rounded mr-4">Jelajahi Produk</a>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Produk Terbaru -->
    <section id="products" class="py-16">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-center mb-10">Produk Terbaru</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($products->isEmpty())
                    <p class="col-span-full text-center text-gray-500">Tidak ada produk tersedia.</p>
                @else
                    @foreach ($products as $product)
                    <div class="p-5">
                        <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                         <p class="text-gray-500 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Tambah ke Keranjang</button>
                        </form>
                    </div>
                    
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Kategori Produk -->
    <section id="categories" class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-center mb-10">Kategori Produk</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($categories->isEmpty())
                    <p class="col-span-full text-center text-gray-500">Tidak ada kategori tersedia.</p>
                @else
                    @foreach ($categories as $kategori)
                        <div class="bg-white shadow-md rounded-lg p-6 text-center">
                            <h3 class="text-xl font-semibold mb-2">{{ $kategori->name }}</h3>
                            <p class="text-gray-500">Produk dari kategori {{ $kategori->name }}.</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section id="testimonials" class="py-16 bg-white">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-center mb-10">Apa Kata Mereka</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"Marketplace ini sangat membantu usaha saya, penjualan meningkat
                        drastis."</p>
                    <h3 class="text-xl font-semibold">Ibu Aisyah</h3>
                </div>
                <!-- Tambahkan lebih banyak testimoni di sini -->
            </div>
        </div>
    </section>

</body>

</html>
