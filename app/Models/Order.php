<?php

namespace App\Models;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'cart_id', 
        'payment_status', 
        'order_status', 
        'payment_method', 
        'shipping_address',
        'seller_id',
        'product_id',
        'buyer_id',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relasi ke Seller
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relasi ke Buyer
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
