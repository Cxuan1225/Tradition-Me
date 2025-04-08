<?php

namespace App\Livewire;

use App\Models\UserAddress;
use Livewire\Component;

class UserAddressView extends Component
{
    public function render()
    {
        $userAddresses = UserAddress::where('user_id', auth()->user()->id)->get();

        return view('livewire.user-address-view', [
            'userAddresses' => $userAddresses,
        ]);
    }
}
