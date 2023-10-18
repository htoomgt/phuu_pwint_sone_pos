<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\ProductReadRepositoryInterface;


class ProductReadRepository implements ProductReadRepositoryInterface
{
    public function productShowList(): Builder
    {
        $model = Product::query()
            ->selectRaw("products.*,
                    pct.name as product_category_name,
                    pmu.name as product_measure_unit,
                    cu.full_name as creator_name,
                    uu.full_name as updater_name
                ")
            ->leftJoin('product_categories as pct', 'products.category_id', '=', 'pct.id')
            ->leftJoin('product_measure_units as pmu', 'products.measure_unit_id', '=', 'pmu.id')
            ->leftJoin('users as cu', 'products.created_by', '=', 'cu.id')
            ->leftJoin('users as uu', 'products.updated_by', '=', 'uu.id');


        return $model;
    }

    public function findById($id): Product
    {
        $product = Product::with(['measure_unit', 'category', 'productBreakdownParent'])
            ->whereId($id)->first();

        return $product;
    }

    public function findByBreakdownParentId($breakdownParentId)
    {
        $product = Product::with(['measure_unit', 'category'])
            ->where('breakdown_parent', $breakdownParentId)->first();


        return $product;
    }
}
