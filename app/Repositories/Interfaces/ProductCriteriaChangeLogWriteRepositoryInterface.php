<?php

namespace App\Repositories\Interfaces;

interface ProductCriteriaChangeLogWriteRepositoryInterface
{
    public function create($data);
    public function updateById($data, $id);
    public function deleteById($id);
}
