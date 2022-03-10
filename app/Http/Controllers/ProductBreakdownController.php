<?php

namespace App\Http\Controllers;


use App\Http\Controllers\GenericController;
use App\Http\Controllers\ResourceFunctions;
use App\Models\Product;
use App\Models\ProductBreakdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Log;
use Throwable;
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
        $dataTableId = "#dtProductBreakdownList";



        // Request Ajax
        if (request()->ajax()) {
            $model = ProductBreakdown::query()
                        ->selectRaw("
                            product_breakdown.*,
                            product_from.name as product_from,
                            product_to.name as product_to,
                            creator.full_name as created_user,
                            updater.full_name as updated_user

                        ")
                        ->leftJoin('products as product_from', 'product_breakdown.product_from', '=', 'product_from.id')
                        ->leftJoin('products as product_to', 'product_breakdown.product_to', '=', 'product_to.id')
                        ->leftJoin('users as creator', 'product_breakdown.created_by', '=', 'creator.id')
                        ->leftJoin('users as updater', 'product_breakdown.updated_by', '=', 'updater.id');

            return DataTables::of($model)
            ->addColumn('actions', function(ProductBreakdown $productBreakdown)use($deleteUrl, $dataTableId){
                $editUrl = route('productBreakdown.editBreakdownPage', $productBreakdown->id);
                $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="prodcutBreakdownEditPage(`'.$editUrl.'`)"

                            >
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a class="dropdown-item" href="#" onclick = "dtDeleteRow('.$productBreakdown->id.', `'.$deleteUrl.'`, `'.$dataTableId.'`)">
                        <i class="far fa-trash-alt"></i>
                        Delete
                    </a>
                  </div>
                </div>
            ';



            return  $actions;
            })
            ->editColumn('product_from', function(ProductBreakdown $productBreakdown) {
                return $productBreakdown->product_from;

            })
            ->editColumn('product_to', function(ProductBreakdown $productBreakdown) {
                return $productBreakdown->product_to;

            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('Y-m-d');
            })
            ->editColumn('updated_at', function ($request) {
                return $request->created_at->format('Y-m-d');
            })
            ->rawColumns(['actions'])
            ->toJson();

        }
        //datatable compose
        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'actions', 'title' => 'Actions'],
            ['data' => 'product_from', 'title' => 'Product From'],
            ['data' => 'product_to', 'title' => 'Product To'],
            ['data' => 'quantity_to_breakdown', 'title' => 'Quantity To Breakdown'],
            ['data' => 'quantity_to_add', 'title' => 'Quantity To Add'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
            ['data' => 'created_user', 'title' => 'Created By'],
            ['data' => 'updated_user', 'title' => 'Updated By'],
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
                    ["width" => "20%", "targets" => 1],
                    ["width" => "20%", "targets" => 2],
                    ["width" => "15%", "targets" => 3],
                    ["width" => "10%", "targets" => 4],
                    ["width" => "15%", "targets" => 5],
                    ["width" => "15%", "targets" => 6],

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
        // Set Page Title
        $this->setPageTitle("Manage Product", "Make Product Breakdown");

        // return make product breadown page
        return view('product-breakdown.make-product-breakdown');
    }

    public function makeBreakdown(Request $request){
        // dd($request->all());
        // get param
        $productFromBreakdown = $request->dlProductFromBreakdown;

        $productToBreakdown = $request->dlProductToBreakdown;

        $quantityToBreakdown = $request->txtQuantityToBreakdown;

        $quantityToAdd = $request->txtTotalQuantityToAdd;

        // validate
        if($productFromBreakdown == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['produt_from_breakdown' => 'Product From is required'], '', '');
        }

        if($productToBreakdown == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['produt_to_breakdown' => 'Product To is required'], '', '');
        }

        if($quantityToBreakdown == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['quantity_to_breakdown' => 'Quantity To Breakdown is required'], '', '');
        }

        if($quantityToAdd == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['quantity_to_add' => 'Quantity To Add is required'], '', '');
        }


        // recording is enough, product current balance will be calculated by product transaction and breakdown transaction


        if($this->validStatus){
            // record to product breakdown table with above two transactions Id
            try {
                $productBreakdown = ProductBreakdown::create([
                    'product_from' => $productFromBreakdown,
                    'product_to' => $productToBreakdown,
                    'quantity_to_breakdown' => $quantityToBreakdown,
                    'quantity_to_add' => $quantityToAdd,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);


                if($productBreakdown){
                    $this->setResponseInfo('success','Your product breakdown has been recorded successfully!', '', '', '');
                }

            } catch (\Throwable $th) {
                //throw $th;
                $errorMsg = "product breakdown recording is failed due to ".$th->getMessage();
                Log::error($errorMsg);
                $this->setResponseInfo('error','', [], '',$errorMsg);
            }
        }
        // dd($this->response);

        // respond to client
        return response()->json($this->response, $this->httpStatus);

    }

    public function editBreakdownPage(Request $request){
        // Set Page Title
        $this->setPageTitle("Manage Product", "Edit Product Breakdown");

        // get param
        $productBreakdownId = $request->breakdownId;

        // get product breakdown data
        $productBreakdownRecord = ProductBreakdown::where('id', $productBreakdownId)->with(['productFrom','productTo'])->first();
        // dd($productBreakdownRecord->productFrom->name);

        // return view
        return view('product-breakdown.edit-product-breakdown', compact('productBreakdownRecord'));
    }

    public function updateBreakdown(Request $request){
        // get param
        $productBreakdownId = $request->hvProductBreakdownId;

        $productFromBreakdown = $request->dlProductFromBreakdown;

        $productToBreakdown = $request->dlProductToBreakdown;

        $quantityToBreakdown = $request->txtQuantityToBreakdown;

        $quantityToAdd = $request->txtTotalQuantityToAdd;

        // validate
        if($productFromBreakdown == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['produt_from_breakdown' => 'Product From is required'], '', '');
        }

        if($productToBreakdown == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['produt_to_breakdown' => 'Product To is required'], '', '');
        }

        if($quantityToBreakdown == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['quantity_to_breakdown' => 'Quantity To Breakdown is required'], '', '');
        }

        if($quantityToAdd == ''){
            $this->validStatus = false;
            $this->setResponseInfo('invalid','', ['quantity_to_add' => 'Quantity To Add is required'], '', '');
        }

        // record to product breakdown table with above two transactions Id by its own Id
        if ($this->validStatus) {
            // record to product breakdown table with above two transactions Id
            try {
                $productBreakdown = ProductBreakdown::where('id', $productBreakdownId)->update([
                    'product_from' => $productFromBreakdown,
                    'product_to' => $productToBreakdown,
                    'quantity_to_breakdown' => $quantityToBreakdown,
                    'quantity_to_add' => $quantityToAdd,
                    'updated_by' => Auth::user()->id,
                ]);



                if($productBreakdown){
                    $this->setResponseInfo('success','Your product breakdown has been updated successfully!', '', '', '');
                }
                else{
                    $this->setResponseInfo('error','', [], '', 'product breakdown update is failed');
                }
            } catch(Throwable $th){
                $errorMsg = "product breakdown update is failed due to ".$th->getMessage();
                Log::error($errorMsg);
                $this->setResponseInfo('error','', [], '',$errorMsg);
            }
        }

        // respond to client
        return response()->json($this->response, $this->httpStatus);
    }

    /***
     * To delete the product breakdown by Id
     * @param Request $request
     * @author Htoo Maung Thait
     * @since 2022-02-25
     */
    public function deleteBreakdownById(Request $request){


        try{
             // get product breakdown Id
            $id = $request->id;

            // validate the id
            if($id == ""){
                $this->setResponseInfo('invalid','', ['id' => 'Product Breakdown Id is required'],'','');
            }

            if($this->validStatus){
                // delete product breakdown by Id
                $status = ProductBreakdown::where('id', $id)->delete();

                if($status){
                    $this->setResponseInfo('success', 'Your record has been deleted successfully', [], '', '');
                }
                else{
                    $this->setResponseInfo('error', '', [], '', 'Your record has not been deleted');
                }

            }
            else{
                return response()->json($this->response, $this->httpStatus);
            }



            // if not cascade delete, delete transaction from parent and child product by transaction Id


        }catch(Throwable $th){
            $errorMsg = 'Delete Error Message : '.$th->getMessage();
            Log::error($errorMsg);
            $this->setResponseInfo('error', '', [], '',$errorMsg);
        }


        // respond to client
        return response()->json($this->response, $this->httpStatus);
    }
}
