<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SwitchViewController extends Controller
{
    public function switchView(Request $request, $view)
    {
        $userRole = $request->user()->role;

        $layout = ($view == 'end_user' || ! in_array($userRole, ['admin', 'seller']))
            ? 'layouts.end_user.app'
            : 'layouts.admin_seller.app';

        Session::put('view_layout', $layout);

        return ($layout === 'layouts.end_user.app') ? redirect()->route('landing') : redirect()->route('dashboard');
    }
}
