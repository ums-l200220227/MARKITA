<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <div class="bg-gray-800 text-white w-64 p-4">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            <ul>
                <li><a href="{{ route('adminhome') }}" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a></li>
                <li>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="block w-full">
                            @csrf
                            <button type="submit" class="block py-2 px-4 hover:bg-gray-700 w-full text-left">
                                Logout
                            </button>
                        </form>
                    @endauth
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Halaman Pengelolaan User dan Produk -->
            <section class="container mx-auto p-4">
                <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

                <!-- Pengelolaan Pengguna -->
                <h2 class="text-2xl font-semibold mb-4">Pengelolaan Pengguna</h2>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg mb-8">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Role</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">{{ $user->role }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pengelolaan Produk -->
                <h2 class="text-2xl font-semibold mb-4">Pengelolaan Produk</h2>
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
                        @foreach ($products as $product)
                            <tr>
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">
                                    {{ $product->kategori ? $product->kategori->name : 'Kategori tidak tersedia' }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($product->price) }}</td>
                                <td class="px-4 py-2">{{ $product->stock }}</td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>

</body>

</html>
