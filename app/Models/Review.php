<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'ulasan';  // Nama tabel sesuai dengan migrasi
    protected $fillable = ['produk_id', 'user_id', 'rating', 'review_text'];

    // Relasi dengan produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    // Relasi dengan pengguna
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
