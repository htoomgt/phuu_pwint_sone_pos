<?php

namespace App\Repositories;

use App\Models\ProductCriteriaChangeLog;
use App\Repositories\Interfaces\ProductCriteriaChangeLogWriteRepositoryInterface;



class ProductCriteriaChangeLogWriteRepository implements ProductCriteriaChangeLogWriteRepositoryInterface
{
    public function create($data): ProductCriteriaChangeLog
    {
        return ProductCriteriaChangeLog::create($data);
    }

    public function updateById($data, $id): bool
    {
        return ProductCriteriaChangeLog::where('id', $id)->update($data);
    }

    public function deleteById($id): bool
    {
        return ProductCriteriaChangeLog::where('id', $id)->delete();
    }
}
