<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CartTable extends Component
{
    use WithPagination;

    public $cart;

    public $itemsPerPage = 10;

    public $cartItemId;

    public $defaultAddress;

    public $selectedAddressId;

    public $totalPrice;

    public function mount()
    {
        $this->loadCartData();
        $this->defaultAddress = UserAddress::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->first();
        $this->selectedAddressId = $this->defaultAddress->id ?? '';

        $this->calculateTotalPrice();
    }

    public function loadCartData()
    {
        $this->cart = Cart::where('user_id', Auth::id())->first();
    }

    public function removeItem($cartItemId)
    {
        $item = $this->cart->items()->find($cartItemId);
        if ($item) {
            $item->delete();
            $this->loadCartData();
            $this->calculateTotalPrice();
        }
    }

    #[On('changeShippingAddress')]
    public function CurrentShippingAddress($selectedAddressId)
    {
        $this->defaultAddress = UserAddress::where('user_id', Auth::id())->where('id', $selectedAddressId)->first();
        session()->put('userAddress', $this->defaultAddress->id);
    }

    public function updateItemQuantity($itemId, $newQuantity)
    {
        $item = $this->cart->items()->find($itemId);

        if ($item) {
            $item->quantity = $newQuantity;
            $item->save();
            $this->loadCartData();
            $this->calculateTotalPrice();
        }
    }

    #[On('calculateTotalPrice')]
    public function calculateTotalPrice()
    {
        if (is_null($this->cart) || is_null($this->cart->items) || $this->cart->items->isEmpty()) {
            $this->totalPrice = 0;

            return 0;
        }

        $totalPrice = 0;

        foreach ($this->cart->items as $item) {
            $totalPrice += $item->quantity * $item->product->price;
        }

        $this->totalPrice = number_format($totalPrice, 2);

        $this->dispatch('refreshCartItems');

        return $this->totalPrice;
    }

    public function render()
    {
        return view('livewire.cart-table');
    }

    public function createCheckoutSession()
    {
        $sessionUserAddressId = session()->has('userAddress');
        if (! $sessionUserAddressId) {
            session()->flash('error', 'You need to add an address before proceeding.');

            return redirect()->route('profile.edit');
        }
        $totalPrice = sprintf('%.2f', (float) str_replace(',', '', $this->totalPrice));
        $order = Order::create([
            'user_id' => Auth::id(),
            'user_address_id' => session()->get('userAddress'),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $cartItems = $this->cart->items;

        $lineItems = [];
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'color' => $item->color,
                'size' => $item->size,
                'quantity' => $item->quantity,
                'price_per_unit' => $item->product->price,
                'subtotal' => $item->quantity * $item->product->price,
                'product_name' => $item->product->name,
                'product_image' => $item->product->images->first()->image_path,
            ]);
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item->product->name.' - '.ucfirst($item->color).' - '.$item->size,
                    ],
                    'unit_amount' => $item->product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
            $item->delete();
        }
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('end_user.checkout.success', [], true),
            'cancel_url' => route('end_user.checkout.cancel', [], true),
        ]);
        session()->put('orderId', $order->id);

        return redirect($checkout_session->url);
    }
}
