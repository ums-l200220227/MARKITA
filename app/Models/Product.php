<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';  // Nama tabel sesuai dengan migrasi
    protected $fillable = [
        'user_id',
        'kategori_id',
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    // Relasi dengan ulasan
    public function reviews()
    {
        return $this->hasMany(Review::class, 'produk_id');
    }

    // Relasi dengan pengguna (penjual)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
