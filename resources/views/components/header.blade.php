<header class="sticky top-0 z-50 bg-white">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#">
                        {{-- <img src="your-logo.png" alt="Logo" class="h-8 w-auto"> <!-- Ganti dengan logo --> --}}
                    </a>
                    <span class="ml-3 text-xl font-bold">MARKETPLACE</span>
                </div>

                <!-- Menu Navigasi -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-gray-700 hover:text-blue-500">Home</a>
                    <a href="#products" class="text-gray-700 hover:text-blue-500">Produk Terbaru</a>
                    <a href="#categories" class="text-gray-700 hover:text-blue-500">Kategori Produk</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-blue-500">Testimoni</a>
                </div>

                <!-- Profil atau Login -->
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-500">Login</a>
                    @endguest

                    @auth
                        <div class="relative">
                            <button class="text-gray-700 focus:outline-none focus:text-blue-500" onclick="toggleDropdown()"
                                id="dropdownButton">
                                <span class="hidden sm:inline">Profile</span>
                                <svg class="sm:hidden w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
                                </svg>
                            </button>
                            <div id="dropdownMenu"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Icon -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden">
            <a href="#home" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Home</a>
            <a href="#products" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Produk Terbaru</a>
            <a href="#categories" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Kategori Produk</a>
            <a href="#testimonials" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Testimoni</a>

            @auth
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-200">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </nav>
</header>

<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownButton = document.getElementById('dropdownButton');
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
