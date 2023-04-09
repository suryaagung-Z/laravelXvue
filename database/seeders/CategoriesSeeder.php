<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $id = [
            "98e00acb-74de-4fb6-b457-79031b84c85b",
            "98e00acb-7a2a-4bfe-a4e4-cc5fef4413a0",
            "98e00acb-7c8e-427e-9fd4-b18ef6f8582e",
            "98e00acb-7dfd-4c71-b1d8-342de4b5e7fe"
        ];
        $categories = ["makanan", "minuman", "alat tulis", "alat makan"];

        foreach ($categories as $key => $category) {
            Categories::create([
                "id"            => $id[$key],
                "category_name" => $category
            ]);
        }
    }
}
