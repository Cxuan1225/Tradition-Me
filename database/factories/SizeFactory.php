<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends Factory
{
    protected $model = Size::class;

    public function definition()
    {
        return [
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
