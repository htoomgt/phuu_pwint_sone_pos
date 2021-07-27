<?php

namespace Database\Seeders;

use App\Models\ProductMeasureUnit;
use Illuminate\Database\Seeder;

class ProductMeasureUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductMeasureUnit::create(['name' => 'kg']);
        ProductMeasureUnit::create(['name' => '12 kg Pack']);
        ProductMeasureUnit::create(['name' => '24 kg Pack']);
        ProductMeasureUnit::create(['name' => '48 kg Pack']);
        ProductMeasureUnit::create(['name' => '1 V']);
        ProductMeasureUnit::create(['name' => '0.5 V']);
        ProductMeasureUnit::create(['name' => '1 Liter']);
        ProductMeasureUnit::create(['name' => '1 Pack']);
        ProductMeasureUnit::create(['name' => '1 Piece']);
        ProductMeasureUnit::create(['name' => '1 bottle']);
        ProductMeasureUnit::create(['name' => '1 can']);
        ProductMeasureUnit::create(['name' => '1 stick']);
        ProductMeasureUnit::create(['name' => '110 g']);
        ProductMeasureUnit::create(['name' => '60 g']);
        ProductMeasureUnit::create(['name' => '530 ml']);
        ProductMeasureUnit::create(['name' => '1 egg']);
    }
}
