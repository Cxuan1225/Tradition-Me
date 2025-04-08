<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $role = Auth::user()->role;
        if ($role == 'admin' || $role == 'seller') {
            return view('layouts/admin_seller/app');
        } else {
            return view('layouts/end_user/app');
        }
    }
}
