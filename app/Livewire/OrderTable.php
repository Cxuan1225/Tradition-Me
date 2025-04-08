<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public $status;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    protected $paginationTheme = 'bootstrap';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Toggle sorting direction
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function payOrder($orderId)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $orderItems = Order::find($orderId)->items;

        $lineItems = [];
        foreach ($orderItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item->product->name . ' - ' . ucfirst($item->color) . ' - ' . $item->size,
                    ],
                    'unit_amount' => $item->product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('end_user.checkout.success', [], true),
            'cancel_url' => route('end_user.checkout.cancel', [], true),
        ]);
        session()->put('orderId', $orderId);

        return redirect($checkout_session->url);
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find(id: $orderId);
        if ($order && $order->status === 'paid') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);

                if ($product) {
                    $productColor = $product->colors()->where('color', $item->color)->first();
                    if (! $productColor) {
                        $productColor = $product->colors()->create(['color' => $item->color]);
                    }

                    $sizeModel = $productColor->sizes()->where('size', $item->size)->first();
                    if (! $sizeModel) {
                        $sizeModel = $productColor->sizes()->create(['size' => $item->size, 'quantity' => 0]);
                    }
                    if ($sizeModel) {
                        $sizeModel->quantity += $item->quantity;
                        $sizeModel->save();
                    }
                }
            }
        }

        $order->status = 'cancel';
        $order->save();
        $this->render();
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('status', 'like', '%' . $this->search . '%')
                    ->orWhere('total_price', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(5);

        return view('livewire.order-table', ['orders' => $orders]);
    }
}
