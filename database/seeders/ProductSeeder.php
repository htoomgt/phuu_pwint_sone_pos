<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => ' Paw Nyi-12',
            'myanmar_name' => 'ပေါ်ညီ၁၂',
            'category_id' => 1,
            'product_code' => 'P-N-12',
            'measure_unit_id' =>  2,
            'reorder_level' => 10,
            'unit_price' => 11000,
            'ex-mill_price' => 9625,
            'transport_fee' => 175,
            'unload_fee' => 12,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d')

        ]);

        Product::create([
            'name' => ' Paw Nyi-24',
            'myanmar_name' => 'ပေါ်ညီ၂၄',
            'category_id' => 1,
            'product_code' => 'P-N-24',
            'measure_unit_id' =>  3,
            'reorder_level' => 10,
            'unit_price' => 21500,
            'ex-mill_price' => 18750,
            'transport_fee' => 350,
            'unload_fee' => 25,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d')

        ]);

        Product::create([
            'name' => ' Paw Nyi-48',
            'myanmar_name' => 'ပေါ်ညီ၄၈',
            'category_id' => 1,
            'product_code' => 'P-N-48',
            'measure_unit_id' =>  4,
            'reorder_level' => 10,
            'unit_price' => 43000,
            'ex-mill_price' => 38500,
            'transport_fee' => 700,
            'unload_fee' => 50,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d')

        ]);
    }
}
