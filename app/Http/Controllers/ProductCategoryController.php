<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResourceFunctions;
use App\Http\Controllers\GenericController;
use App\Models\ProductCategory;
use Yajra\DataTables\Html\Builder;

class ProductCategoryController extends GenericController implements ResourceFunctions
{
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("Manage Product", "Product Category");

        return view('product-category.product-category-show-list');
    }

    public function create(Request $request)
    {

    }

    public function addNew(Request $request)
    {

    }

    public function getDataRowById(Request $request){

    }

    public function edit(ProductCategory $productCategory)
    {

    }

    public function updateById(Request $request)
    {

    }

    public function statusUpdateById(Request $request)
    {

    }

    public function deleteById(Request $request)
    {

    }
}
