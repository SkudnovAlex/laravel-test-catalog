<?php

namespace Database\Factories;

use App\DbModels\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0.5, 501),
            'sale' => $this->faker->numberBetween(0,50),
            'description' => $this->faker->text(250),
            'is_new' => $this->faker->boolean,
            'is_top_selling' => $this->faker->boolean
        ];
    }
}
