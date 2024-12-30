<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'kategori';  // Nama tabel sesuai dengan migrasi
    protected $fillable = ['name'];

    // Relasi dengan produk
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id');  // Foreign key in the 'products' table
    }
}
