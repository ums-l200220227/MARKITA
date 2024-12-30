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

    <section>
        <div class="container mx-auto p-4">
            {{-- Product Management Section --}}
            <h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

            <form action="{{ route('penjual.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <section class="mb-4">
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori Produk</label>
                    <select name="kategori_id" id="kategori_id" class="w-full p-2 border border-gray-300 rounded-lg" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </section>
            
                <section class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </section>
            
                <section class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
                </section>
            
                <section class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="price" id="price" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </section>
            
                <section class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" id="stock" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </section>
            
                <section class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    <input type="file" name="image" id="image" class="w-full p-2 border border-gray-300 rounded-lg">
                </section>
            
                <section>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Tambahkan Produk</button>
                </section>
            </form>
            

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

</body>

</html>
