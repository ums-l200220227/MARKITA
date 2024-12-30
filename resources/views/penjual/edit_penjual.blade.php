<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <x-header></x-header>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

        <form action="{{ route('penjual.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <section class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                    class="w-full p-2 border border-gray-300 rounded-lg" required>
            </section>

            <section class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-lg">{{ old('description', $product->description) }}</textarea>
            </section>

            <section class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                    class="w-full p-2 border border-gray-300 rounded-lg" required>
            </section>

            <section class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                    class="w-full p-2 border border-gray-300 rounded-lg" required>
            </section>

            <section>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Simpan Perubahan</button>
            </section>
        </form>
    </div>
</body>

</html>
