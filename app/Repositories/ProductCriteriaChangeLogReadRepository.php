<?php

namespace App\Repositories;

use App\Models\ProductCriteriaChangeLog;


use App\Repositories\Interfaces\ProductCriteriaChangeLogReadRepositoryInterface;

class ProductCriteriaChangeLogReadRepository implements ProductCriteriaChangeLogReadRepositoryInterface
{
    public function showProductCriteriaChangeLog(): object
    {
        return ProductCriteriaChangeLog::all();
    }

    public function findById($id): ProductCriteriaChangeLog
    {
        return ProductCriteriaChangeLog::where('id', $id)->first();
    }
}
