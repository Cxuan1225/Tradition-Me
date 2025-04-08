<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'size', 'color', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPrice($quantity = null)
    {
        if ($quantity != null) {
            $this->quantity = $quantity;
        }

        return $this->quantity * $this->product->price;
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->save();
    }

    public function updateColor($color)
    {
        $this->color = $color;
        $this->save();
    }

    public function updateSize($size)
    {
        $this->size = $size;
        $this->save();
    }
}
