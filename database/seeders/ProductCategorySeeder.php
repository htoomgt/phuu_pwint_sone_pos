<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create(["name" => "Rice Super 100 %"]);
        ProductCategory::create(["name" => "Pure Peanut Oil"]);
        ProductCategory::create(["name" => "Pure Sunflower Oil"]);
    }
}
