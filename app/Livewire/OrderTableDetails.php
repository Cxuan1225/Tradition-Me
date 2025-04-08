<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\UserAddress;
use Livewire\Component;

class OrderTableDetails extends Component
{
    public $orderId;

    public $orderItems;

    public $userAddress;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->orderItems = OrderItems::where('order_id', $orderId)->get();
        $this->userAddress = UserAddress::find(Order::find($orderId)->user_address_id);
    }

    public function render()
    {
        return view('livewire.order-table-details', [
            'items' => $this->orderItems,
            'address' => $this->userAddress,
        ]);
    }
}
