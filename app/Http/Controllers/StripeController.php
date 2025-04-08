<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

class StripeController extends Controller
{
    public function index()
    {
        return route('checkout.index', [
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function success()
    {
        $order = Order::find(session()->get('orderId'));

        if ($order) {
            $order->status = 'paid';
            $order->save();

            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $productColor = $product->colors()->where('color', $item->color)->first();
                if ($productColor) {
                    $sizeModel = $productColor->sizes()->where('size', $item->size)->first();
                    if ($sizeModel && $sizeModel->quantity >= $item->quantity) {
                        $sizeModel->quantity -= $item->quantity;
                        $sizeModel->save();
                    } else {
                        // Handle out-of-stock error (optional)
                    }
                }
            }
            session()->remove('orderId');
        }

        return to_route('order.index');
    }

    public function cancel()
    {
        if (session()->has('orderId')) {
            session()->remove('orderId');
        }

        return to_route('order.index');
    }

    public function webhook()
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                break;
            default:
                echo 'Received unknown event type '.$event->type;
        }

        http_response_code(200);
    }
}
