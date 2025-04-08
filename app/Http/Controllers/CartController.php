<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::all();

        return view('end_user.cart.index', compact('cart'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('components.cart-card', compact('product'));
    }
}
