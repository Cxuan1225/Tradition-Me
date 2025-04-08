<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CartModal extends Component
{
    public $productId;

    #[Validate('required')]
    public $selectedColor;

    #[Validate('required')]
    public $selectedSize;

    public $quantity = 1;

    public $sizes = [];

    protected $cartService;

    public $display;

    public function __construct()
    {
        $this->cartService = app(CartService::class);
    }

    public function mount($productId, $display)
    {
        if (session()->has('preference_color') && session()->has('preference_size')) {
            $this->selectedColor = session('preference_color') ?? '';
            $this->selectedSize = session('preference_size') ?? '';
            $this->updatedSelectedColor($this->selectedColor);
        }
        $this->display = $display;
        $this->productId = $productId;
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
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            return Redirect::route('login');
        }

        $cart->addItem(
            $this->productId,
            $this->selectedColor,
            $this->selectedSize,
            $this->quantity
        );

        $this->dispatch('cart-updated');
    }

    public function Payment()
    {
        if (! Auth::check()) {
            return Redirect::route('login');
        }
        if (Auth::user()->addresses->isEmpty()) {
            session()->flash('error', 'You need to add an address before proceeding.');

            return redirect()->route('profile.edit');
        }
        $addresses = Auth::user()->addresses;
        $userAddressId = $addresses->where('is_default', true)->first()?->id
            ?: $addresses->first()?->id;
        session()->put('userAddress', $userAddressId);

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $product = Product::find($this->productId);
        $totalPrice = sprintf('%.2f', (float) str_replace(',', '', $this->quantity * $product->price));
        $order = Order::create([
            'user_id' => Auth::id(),
            'user_address_id' => session()->get('userAddress'),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
        $order->items()->create([
            'product_id' => $product->id,
            'color' => $this->selectedColor,
            'size' => $this->selectedSize,
            'quantity' => $this->quantity,
            'price_per_unit' => $product->price,
            'subtotal' => $this->quantity * $product->price,
            'product_name' => $product->name,
            'product_image' => $product->images->first()->image_path,
        ]);
        $lineItems = [];
        $lineItems[] = [
            'price_data' => [
                'currency' => 'myr',
                'product_data' => [
                    'name' => $product->name.' - '.ucfirst($this->selectedColor).' - '.$this->selectedSize,
                ],
                'unit_amount' => $product->price * 100,
            ],
            'quantity' => $this->quantity,
        ];
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('end_user.checkout.success', [], true),
            'cancel_url' => route('end_user.checkout.cancel', [], true),
        ]);
        session()->put('orderId', $order->id);

        return redirect($checkout_session->url);
    }

    public function render()
    {
        $product = Product::find($this->productId);

        return view('livewire.cart-modal', [
            'product' => $product,
            'display' => $this->display,
        ]);
    }
}
