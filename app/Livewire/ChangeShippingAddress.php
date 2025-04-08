<?php

namespace App\Livewire;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChangeShippingAddress extends Component
{
    public $addresses;

    public $default;

    public $selectedAddressId;

    public function mount()
    {
        $this->addresses = UserAddress::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->get();
        $this->selectedAddressId = $this->addresses->first()->id ?? '';
    }

    public function updateDefaultAddress()
    {
        $this->selectedAddressId;
        $this->dispatch('changeShippingAddress', selectedAddressId: $this->selectedAddressId);
    }

    public function render()
    {
        return view('livewire.change-shipping-address', [
            '',
        ]);
    }
}
