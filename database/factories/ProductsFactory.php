<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Products::class;

    public function definition(): array
    {
        $id = [
            "98e00acb-74de-4fb6-b457-79031b84c85b",
            "98e00acb-7a2a-4bfe-a4e4-cc5fef4413a0",
            "98e00acb-7c8e-427e-9fd4-b18ef6f8582e",
            "98e00acb-7dfd-4c71-b1d8-342de4b5e7fe"
        ];

        return [
            "id"              => Uuid::uuid4(),
            "product_name"    => $this->faker->sentence(2),
            "price"           => $this->faker->numberBetween(100, 1000),
            "category_id"     => $id[$this->faker->numberBetween(0, 3)],
            "production_date" => $this->faker->date('Y-m-d')
        ];
    }
}
