<?php

namespace Modules\Plataform1\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Plataform1\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, pow(10, 5)), // 100k
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph(),
            'group_id' => 1,
        ];
    }
}
