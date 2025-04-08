<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $userRole = Auth::user()->role;
        $layout = in_array($userRole, ['admin', 'seller'])
            ? 'layouts.admin_seller.app'
            : 'layouts.end_user.app';
        $view = in_array($userRole, ['admin', 'seller'])
            ? 'admin.order.index'
            : 'end_user.order.index';

        return view($view, compact('orders', 'layout'));
    }

    public function showDetails($id)
    {
        $orders = Order::all();
        $userRole = Auth::user()->role;
        $layout = in_array($userRole, ['admin', 'seller'])
            ? 'layouts.admin_seller.app'
            : 'layouts.end_user.app';

        return view('end_user.order.showDetails', [
            'orderId' => $id,
            'layout' => $layout,
        ]);
    }

    public function update(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $validatedData = $request->validate([
            'status' => 'required|string|in:paid,shipping,delivered,refunded',
        ]);
        $order->status = $validatedData['status'];
        $order->save();

        return redirect()->back();
    }
}
