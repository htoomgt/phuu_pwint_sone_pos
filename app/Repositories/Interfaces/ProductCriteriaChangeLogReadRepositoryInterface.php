<?php

namespace App\Repositories\Interfaces;

interface ProductCriteriaChangeLogReadRepositoryInterface
{
    public function showProductCriteriaChangeLog();
    public function findById($id);
}
