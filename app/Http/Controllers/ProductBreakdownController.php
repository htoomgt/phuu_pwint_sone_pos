<?php

namespace App\Http\Controllers;


use App\Http\Controllers\GenericController;
use App\Http\Controllers\ResourceFunctions;
use App\Models\Product;
use App\Models\ProductBreakdown;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables as DataTablesDataTables;

class ProductBreakdownController extends GenericController
{

    /***
     * To list the product breakdown records with datatable
     * @param Builder $builder
     * @author Htoo Maung Thait
    */
    public function showListPage(Builder $builder){
        $this->setPageTitle("Manage Product", "Product Breakdown");
        $deleteUrl = route('productBreakdown.deleteById');

        // Request Ajax
        if (request()->ajax()) {
            $model = ProductBreakdown::query()
                        ->selectRaw("
                            product_breakdowns.*,
                            product_from.name as product_from,
                            product_to.name as product_to,
                            creator.name as creator,
                            updater.name as updater

                        ")
                        ->leftJoin('products as product_from', 'product_breakdowns.product_from', '=', 'product_from.id')
                        ->leftJoin('products as product_to', 'product_breakdowns.product_to', '=', 'product_to.id')
                        ->leftJoin('users as creator', 'product_breakdowns.created_by', '=', 'creator.id')
                        ->leftJoin('users as updater', 'product_breakdowns.updated_by', '=', 'updater.id');

            return DataTables::of($model)
            ->editColumn('product_from', function(Product $product) {
                return $product->product_from->name;


            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('Y-m-d');
            })
            ->editColumn('updated_at', function ($request) {
                return $request->created_at->format('Y-m-d');
            })
            ->toJson();
            ;
        }
        //datatable compose
        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'product_from_name', 'title' => 'Product From'],
            ['data' => 'product_to_name', 'title' => 'Product To'],
            ['data' => 'quantity_to_breakdown', 'title' => 'Quantity To Breakdown'],
            ['data' => 'quantity_to_add', 'title' => 'Quantity To Add'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
            ['data' => 'creator', 'title' => 'Created By'],
            ['data' => 'updater', 'title' => 'Updated By'],
        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "responsive" => true,
                "autoWidth" => false,
                "order" => [
                    [0, 'desc'],
                ],
                "columnDefs" => [
                    ["width" => "5%", "targets" => 0],
                    ["width" => "10%", "targets" => 1],
                    ["width" => "20%", "targets" => 2],
                    ["width" => "25%", "targets" => 3],
                    ["width" => "20%", "targets" => 4],
                    ["width" => "20%", "targets" => 5],

                ],

            ]);


        //return view
        return view('product-breakdown.product-breakdown-list', compact('dataTable'));


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
        $productFromBreakdown = $request->dlProductFromBreakdown;

        $productToBreakdown = $request->dlProductToBreakdown;

        $quantityToBreakdown = $request->txtQuantityToBreakdown;

        $quantityToAdd = $request->txtQuantityToAdd;

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
