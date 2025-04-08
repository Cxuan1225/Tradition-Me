<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProductShow extends Component
{
    public $productId;

    #[Validate('required')]
    public $selectedColor;

    #[Validate('required')]
    public $selectedSize;

    protected $cartService;

    public $sizes = [];

    public $quantity = 1;

    public function __construct()
    {
        $this->cartService = app(CartService::class);
    }

    public function mount($productId)
    {
        $this->selectedColor = session('preference_color') ?? '';
        $this->selectedSize = session('preference_size') ?? '';
        $this->productId = $productId;
        $this->updatedSelectedColor($this->selectedColor);
    }

    public function updatedSelectedColor($color)
    {
        $this->sizes = $this->cartService->getAvailableSizes($this->productId, $color);
    }

    public function addToCart()
    {
        $this->validate([
            'selectedColor' => 'required',
            'selectedSize' => 'required',
        ]);

        if (Auth::check()) {
            $this->cartService->addToCart(
                $this->productId,
                $this->selectedColor,
                $this->selectedSize,
                $this->quantity
            );

            $this->dispatch('cart-updated');
            $this->reset(['selectedColor', 'selectedSize', 'quantity']);
        } else {
            return Redirect::route('login');
        }
    }

    public function render()
    {
        $product = Product::find($this->productId);

        return view(
            'livewire.product-show',
            [
                'product' => $product,
            ]
        );
    }
}
