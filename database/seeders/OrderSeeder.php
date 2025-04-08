<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $productIds = [1, 2, 9];
        $statuses = ['pending', 'paid', 'cancel'];

        $startDate = Carbon::createFromDate(2024, 1, 1);
        $endDate = Carbon::createFromDate(2024, 10, 23);

        $recordCount = 0;
        $maxRecords = 300;

        while ($startDate->lte($endDate) && $recordCount < $maxRecords) {
            $randomProductId = Arr::random($productIds);
            $product = Product::find($randomProductId);

            if ($product) {
                $quantity = 1;
                $subtotal = $quantity * $product->price;
                $totalPrice = $subtotal;
                $status = Arr::random($statuses);

                $order = Order::create([
                    'user_id' => 3,
                    'user_address_id' => 1,
                    'total_price' => $totalPrice,
                    'status' => $status,
                    'created_at' => $startDate->format('Y-m-d H:i:s'),
                    'updated_at' => $startDate->format('Y-m-d H:i:s'),
                ]);

                $order->items()->create([
                    'product_id' => $product->id,
                    'color' => 'White',
                    'size' => 'M',
                    'quantity' => $quantity,
                    'price_per_unit' => $product->price,
                    'subtotal' => $subtotal,
                    'product_name' => $product->name,
                    'product_image' => $product->images->first()->image_path,
                    'created_at' => $startDate->format('Y-m-d H:i:s'),
                    'updated_at' => $startDate->format('Y-m-d H:i:s'),
                ]);
                $recordCount++;
            }
            $startDate->addDay();
        }
    }
}
