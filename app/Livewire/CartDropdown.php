<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartDropdown extends Component
{
    public $totalCartItems;

    public $cartItems;

    protected $cartService;

    public function __construct()
    {
        $this->cartService = app(CartService::class);
    }

    public function mount()
    {
        $this->loadCartItems();
    }

    #[On('cart-updated')]
    public function refreshCartItems()
    {
        $this->loadCartItems();
    }

    protected function loadCartItems()
    {
        $cart = $this->cartService->getCartForUser();
        $this->cartItems = $cart ? collect($cart->items) : collect();
        $this->totalCartItems = $cart ? $cart->getTotalCartItems() : 0;
    }

    public function render()
    {
        return view('livewire.cart-dropdown', [
            'cartItems' => $this->cartItems,
        ]);
    }
}
