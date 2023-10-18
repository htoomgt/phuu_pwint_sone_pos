<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductWriteRepositoryInterface;


class ProductWriteRepository implements ProductWriteRepositoryInterface
{
    public function create($data): Product
    {
        return Product::create($data);
    }

    public function updateById($data, $id): bool
    {
        return Product::where('id', $id)->update($data);
    }

    public function deleteById($id): bool
    {
        return Product::where('id', $id)->delete();
    }
}
