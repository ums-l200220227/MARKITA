<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'keranjang_barang';  // Nama tabel sesuai dengan migrasi
    protected $fillable = ['keranjang_id', 'produk_id', 'quantity', 'price'];

    // Relasi dengan keranjang
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'keranjang_id');
    }

    // Relasi dengan produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
