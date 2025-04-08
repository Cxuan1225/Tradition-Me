<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = ['Baju Kurung', 'Cheongsam', 'Saree'];

        foreach ($products as $productName) {
            $product = Product::factory()->create([
                'name' => $productName,
                'category' => $this->getCategory($productName),
            ]);

            $colors = ProductColor::factory()->count(3)->make();
            foreach ($colors as $color) {
                $productColor = $product->colors()->create($color->toArray());

                $sizes = Size::factory()->count(4)->make();
                $productColor->sizes()->createMany($sizes->toArray());

                $product->increment('stock_quantity', $sizes->sum('quantity'));
            }

            $images = ProductImage::factory()->count(3)->make(['product_id' => $product->id]);
            $product->images()->createMany($images->toArray());
        }
    }

    private function getCategory($productName)
    {
        switch ($productName) {
            case 'Baju Kurung':
                return 'Malay';
            case 'Cheongsam':
                return 'Chinese';
            case 'Saree':
                return 'Indian';
            default:
                return 'Other';
        }
    }
}
