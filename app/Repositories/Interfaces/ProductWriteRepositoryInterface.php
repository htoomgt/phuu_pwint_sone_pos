<?php

namespace App\Repositories\Interfaces;

interface ProductWriteRepositoryInterface
{
    public function create($data);
    public function updateById($data, $id);
    public function deleteById($id);
}
