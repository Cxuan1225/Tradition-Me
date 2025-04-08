<?php

namespace App\Livewire;

use App\Models\CartItems;
use App\Services\CartService;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\On;
use Livewire\Component;

class CartTableItem extends Component
{
    public $index;

    public $cartItemId;

    public $productId = 0;

    public $cartItem;

    public $sizes = [];

    public $selectedColor;

    public $selectedSize;

    protected $cartService;

    public $quantity;

    public $totalPrice;

    public function __construct()
    {
        $this->cartService = app(cartService::class);
    }

    public function mount($cartItemId)
    {
        $this->cartItemId = $cartItemId;
        $this->loadCartItem();
        $this->selectedColor = $this->cartItem->color;
        $this->selectedSize = $this->cartItem->size;
        $this->quantity = $this->cartItem->quantity;
        $this->updateAvailableSizes();
        $this->calculateTotalPrice();
    }

    public function loadCartItem()
    {
        $this->cartItem = CartItems::find($this->cartItemId);
        $this->updateAvailableSizes();
    }

    public function updatedSelectedColor($color)
    {
        $this->productId = $this->cartItem->product->id;
        $this->sizes = $this->cartService->getAvailableSizes($this->productId, $color);
    }

    public function changeQuantity($newQuantity)
    {
        $this->quantity = $newQuantity;
        $this->cartItem->quantity = $newQuantity;
        $this->cartItem->save();
        $this->calculateTotalPrice();
        $this->dispatch('calculateTotalPrice');
        $this->dispatch('cart-updated');
    }

    public function updateAvailableSizes()
    {
        $this->productId = $this->cartItem->product->id;
        $this->sizes = $this->cartService->getAvailableSizes($this->productId, $this->selectedColor);
    }

    public function removeItem($itemId)
    {
        CartItems::destroy($itemId);
        Redirect::route('end_user.cart.index');
    }

    #[On('RefreshCartItems')]
    public function render()
    {
        return view('livewire.cart-table-item', [
            'item' => $this->cartItem,
        ])->with([
            'key' => $this->cartItem->id,
        ]);
    }

    public function calculateTotalPrice()
    {
        $this->totalPrice = number_format($this->quantity * $this->cartItem->product->price, 2);
    }
}
