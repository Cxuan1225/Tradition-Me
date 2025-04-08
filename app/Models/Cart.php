<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItems::class);
    }

    public function calculateTotalPrice()
    {
        $totalPrice = $this->items->sum(function ($item) {
            return $item->getTotalPrice();
        });

        $this->total_price = $totalPrice;
        $this->save();

        return $totalPrice;
    }

    public function addItem($productId, $color, $size, $quantity)
    {
        $item = $this->items()->where('product_id', $productId)
            ->where('color', $color)
            ->where('size', $size)
            ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $this->items()->create([
                'product_id' => $productId,
                'color' => $color,
                'size' => $size,
                'quantity' => $quantity,
            ]);
        }

        $this->calculateTotalPrice();
    }

    public function removeItem($cartItemId)
    {
        $item = CartItems::find($cartItemId);

        if ($item) {
            $item->delete();
            $this->calculateTotalPrice();
        }
    }

    public function clearCart()
    {
        $this->items()->delete();
        $this->calculateTotalPrice();
    }

    public function getTotalCartItems()
    {
        return $this->items->sum('quantity');
    }
}
