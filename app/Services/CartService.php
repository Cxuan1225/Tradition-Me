<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCartForUser()
    {
        return Cart::where('user_id', Auth::id())->first();
    }

    public function getAvailableSizes($productId, $color)
    {
        $product = Product::find($productId);
        $selectedColor = $product->colors->firstWhere('color', $color);
        if ($selectedColor) {
            $availableSizes = $selectedColor->sizes->filter(function ($size) {
                return $size->quantity > 0;
            });

            return $availableSizes;
        }

        return collect();
    }

    public function addToCart($productId, $color, $size, $quantity)
    {
        $cart = $this->getCartForUser();

        if (! $cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        $cartItem = $cart->items()->where('product_id', $productId)
            ->where('color', $color)
            ->where('size', $size)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'color' => $color,
                'size' => $size,
                'quantity' => $quantity,
            ]);
        }
    }
}
