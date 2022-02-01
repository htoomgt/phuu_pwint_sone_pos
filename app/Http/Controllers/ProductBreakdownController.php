<?php

namespace App\Http\Controllers;


use App\Http\Controllers\GenericController;
use App\Http\Controllers\ResourceFunctions;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Log;

class ProductBreakdownController extends GenericController
{

    /***
     * To list the product breakdown records with datatable
     * @param Builder $builder
     * @author Htoo Maung Thait
    */
    public function showListPage(Builder $builder){
        $this->setPageTitle("Manage Product", "Product Breakdown List");
        $statusUpdateUrl = route('productCategory.statusUpdateById');

        // Request Ajax

        //datatable compose


        //return view
        return view('product-breakdown.product-breakdown-list');


    }

    /***
     * To show the product breakdown list page
     * @param Request $request
     * @author Htoo Maung Thait
     */
    public function makeBreakdownPage(Request $request){
        $this->setPageTitle("Manage Product", "Make Product Breakdown");

        // return make product breadown page
        return view('product-breakdown.make-product-breakdown');
    }

    public function makeBreakdown(Request $request){
        // get param

        // decrease transaction from parent product

        // increase transaction to child product

        // record to product breakdown table with above two transactions Id

        // respond to client

    }

    public function editBreakdownPage(Request $request){
        // get param

        // get product breakdown data

        // return view
        return view('product-breakdown.edit-product-breakdown');
    }

    public function updateBreakdown(Request $request){
        // get param

        // decrease transaction from parent product by transaction Id

        // increase transaction to child product by transaction Id

        // record to product breakdown table with above two transactions Id by its own Id

        // respond to client
    }

    public function deleteBreakdownById(Request $request){
        // get product breakdown Id

        // delete product breakdown by Id

        // if not cascade delete, delete transaction from parent and child product by transaction Id

        // respond to client
    }
}
