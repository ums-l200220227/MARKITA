<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keranjang_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('keranjang')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('produk')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang_barang');
    }
};
