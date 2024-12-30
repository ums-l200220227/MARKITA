<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ========================== Authentication Routes ==========================

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login'); // Halaman login
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/register', function () {return view('auth.register'); })->name('register');
Route::get('/login', function () { return view('auth.login'); })->name('login');
// Rute untuk memproses login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Rute untuk logout
Route::middleware(['auth'])->group(function () {
    Route::get('/penjual/tambah', [ProductController::class, 'create'])->name('penjual.tambah');
    Route::post('/penjual/tambah', [ProductController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rute untuk halaman admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rute admin lainnya
    Route::get('/adminhome', [AuthController::class, 'showAdminHome'])->name('adminhome');
    
    // Rute Pengelolaan Pengguna
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Rute Pengelolaan Kategori
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');  // Form tambah kategori
    Route::post('/admin/categFories', [CategoryController::class, 'store'])->name('admin.categories.store');  // Menyimpan kategori baru
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');  // Menampilkan daftar kategori
    Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');  // Form edit kategori
    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');  // Menyimpan perubahan kategori
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');  // Menghapus kategori
});

Route::get('/adminhome', [AuthController::class, 'showAdminHome'])->middleware('auth')->name('adminhome');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/admin/products/{id}/edit', 'ProductController@edit')->name('admin.products.edit');
Route::delete('/admin/products/{id}', 'ProductController@destroy')->name('admin.products.destroy');






// ========================== Penjual Routes ==========================



// Route for Penjual Home page
Route::get('/penjualhome', [PenjualController::class, 'index'])->name('penjual.penjualhome');

Route::get('/penjual/penjualhome', [PenjualController::class, 'penjualHome'])->name('penjual.penjualhome');

Route::get('/tambah', [ProductController::class, 'create'])->name('tambah');

Route::post('/penjual/store', [ProductController::class, 'store'])->name('penjual.store');

Route::get('/penjual/edit/{id}', [ProductController::class, 'editPenjual'])->name('penjual.edit_penjual');
Route::put('/penjual/update/{id}', [ProductController::class, 'updatePenjual'])->name('penjual.update');

Route::post('/penjual/products/delete/{id}', [ProductController::class, 'destroy_penjual'])->name('penjual.destroy');

Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/penjual/penjualhome', [PenjualController::class, 'index'])->name('penjual.penjualhome');
    Route::put('/penjual/tambah', [ProductController::class, 'create'])->name('penjual.tambah');
    Route::get('/penjual/tambah', [ProductController::class, 'create'])->name('penjual.tambah');
    Route::post('/penjual/tambah', [ProductController::class, 'store'])->name('penjual.tambah');
    // Rute lain untuk mengelola produk penjual
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');



Route::middleware('auth')->group(function () {
    Route::get('/penjual/penjualhome', function () {
        if (auth()->user()->role !== 'penjual') {
            abort(403, 'Unauthorized action.');
        }
        return view('penjual.penjualhome');})->name('penjual.penjualhome');

    Route::get('/penjual/penjualhome', [PenjualController::class, 'penjualHome'])
        ->name('penjual.penjualhome');

    Route::get('/penjualhome', [PenjualController::class, 'index'])->name('penjualhome');

    Route::post('/penjual/tambah', function () {
        if (auth()->user()->role !== 'penjual') {
            abort(403, 'Unauthorized action.');
        }
        // Lakukan penyimpanan produk atau tindakan lainnya
        return redirect()->route('penjual.penjualhome');})->name('penjual.storeProduct');
});

Route::get('/category/{id}', function ($id) {
    // Ambil kategori berdasarkan ID
    $category = Category::find($id);

    if ($category) {
        // Ambil produk terkait dengan kategori
        $products = $category->products;
        return response()->json([
            'category' => $category,
            'products' => $products
        ]);
    } else {
        return response()->json(['error' => 'Category not found'], 404);
    }
});

Route::get('/penjual/products', [ProductController::class, 'index'])->name('penjual.products.index');



// =============================== pemesanan =================================
// Buyer creates an order
Route::post('/order/{productId}', [OrderController::class, 'create'])->name('order.create');
// Seller views their orders
Route::get('/seller/orders', [OrderController::class, 'showSellerOrders'])->name('orders.seller');
// Seller accepts or rejects an order
Route::post('/order/{orderId}/accept', [OrderController::class, 'acceptOrder'])->name('order.accept');
Route::post('/order/{orderId}/reject', [OrderController::class, 'rejectOrder'])->name('order.reject');


Route::get('/orders', [PenjualController::class, 'showOrders']);


Route::middleware('auth')->group(function () {

    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

});

Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
});



// ========================== Home & Profile Routes ==========================

Route::get('/home', function () {
    // Mengambil semua produk beserta kategori terkait
    $products = \App\Models\Product::with('kategori')->get();  // Menggunakan eager loading untuk kategori

    // Mengambil semua kategori
    $categories = Category::all();

    // Mengirimkan data produk dan kategori ke view
    return view('pembeliHome', compact('products', 'categories'));
})->name('home')->middleware('auth');



// ========================== API Routes ==========================

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::resource('products', ProductController::class)->middleware('auth');

