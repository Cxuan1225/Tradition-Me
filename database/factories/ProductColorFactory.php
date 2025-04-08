<?php

namespace Database\Factories;

use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductColor>
 */
class ProductColorFactory extends Factory
{
    protected $model = ProductColor::class;

    public function definition()
    {
        return [
            'color' => $this->faker->randomElement(['white', 'black', 'grey', 'red', 'green', 'blue', 'yellow']),
        ];
    }
}
