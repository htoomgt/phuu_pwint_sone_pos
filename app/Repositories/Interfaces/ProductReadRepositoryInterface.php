<?php

namespace App\Repositories\Interfaces;

interface ProductReadRepositoryInterface
{
    public function productShowList();
    public function findById($id);
    public function findByBreakdownParentId($breakdownParentId);
}
