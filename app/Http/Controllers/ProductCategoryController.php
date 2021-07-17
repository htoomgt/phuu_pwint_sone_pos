<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GenericController;
use App\Http\Controllers\ResourceFunctions;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends GenericController implements ResourceFunctions
{
    /**
     * To show product category list page
     * @author Htoo Maung Thait
     * @param Builder $builder
     * @return mixed (JsonRespose|View)
     */
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("Manage Product", "Product Category");
        $statusUpdateUrl = route('productCategory.statusUpdateById');
        $deleteUrl = route('productCategory.deleteById');
        $dataTableId = "#dtProductCategory";

        if (request()->ajax()) {
            $model = ProductCategory::query();

            return DataTables::of($model)
            ->addColumn('actions', function(ProductCategory $productCategory)use($deleteUrl, $dataTableId){
                $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onClick="productCategoryEdit('.$productCategory->id.')"

                            >
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a class="dropdown-item" href="#" onclick = "dtDeleteRow('.$productCategory->id.', `'.$deleteUrl.'`, `'.$dataTableId.'`)">
                        <i class="far fa-trash-alt"></i>
                        Delete
                    </a>
                  </div>
                </div>
            ';



            return  $actions;
            })
            ->editColumn('status', function(ProductCategory $productCategory)use($statusUpdateUrl, $dataTableId){
                $displayStatus = '';
                $statusAction = '';


                if($productCategory->status == 'active'){
                    $displayStatus = 'Active';
                    $statusAction = '
                        <a class="dropdown-item" href="#" onclick="dtChangeStatus(`'.$productCategory->id.'`, `inactive`, `'.$statusUpdateUrl.'`, `'.$dataTableId.'` )">
                            Inactive
                        </a>
                    ';
                }
                else{
                    $displayStatus = 'inactive';
                    $statusAction = '
                        <a class="dropdown-item" href="#" onclick="dtChangeStatus(`'.$productCategory->id.'`, `active`, `'.$statusUpdateUrl.'`, `'.$dataTableId.'` )">
                            Active
                        </a>
                    ';
                }

                $statusColorClass = $displayStatus == "Active" ?  "btn-success": "btn-secondary";

                return '<div class="dropdown">
                      <button class="btn '.$statusColorClass.' dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.$displayStatus.'
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        '.$statusAction.'
                      </div>
                    </div>';
            })
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('Y-m-d');
                })
                ->editColumn('updated_at', function ($request) {
                    return $request->created_at->format('Y-m-d');
                })
                ->rawColumns(['actions','status'])
                ->toJson();
        }

        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'name', 'title' => 'name'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
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

        return view('product-category.product-category-show-list', compact('dataTable'));
    }

    public function create(Request $request)
    {

    }

    public function addNew(Request $request)
    {
        try {
            $status = ProductCategory::create($request->all());
            if(!empty($status)){
                $this->setResponseInfo('success', 'Your product category has been created successfully!');
            }
            else{
                $this->setResponseInfo('fail');
            }

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '','', '',$th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    public function getDataRowById(Request $request)
    {
        // dd($request->all());
        try {
            $productCategory = ProductCategory::find($request->id);

            if(!empty($productCategory)){
                $this->setResponseInfo('success');
                $this->response['data'] = $productCategory;
            }
            else{
                $this->setResponseInfo('no data', '', '', 'No record is found for given data');
                $this->response['data'] = [];
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            $this->response['data'] = [];
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    public function edit(ProductCategory $productCategory)
    {

    }

    public function updateById(Request $request):JsonResponse
    {
        try {
            $status = ProductCategory::whereId($request->id)->update($request->all());
            if($status){
                $this->setResponseInfo('success', 'Your product category has been updated successfully!');
            }
            else{
                $this->setResponseInfo('fail');
            }

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail','', '','', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    public function statusUpdateById(Request $request)
    {
        $id = $request->id;
        $statusToChange = $request->statusToChange;

        try {
            $user = ProductCategory::find($id);
            $user->status = $statusToChange;
            $status = $user->save();
            if($status){
                $this->setResponseInfo('success');
            }
            else{
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->setResponseInfo('fail');
        }



        return response()
            ->json($this->response, $this->httpStatus);

    }

    public function deleteById(Request $request)
    {
        $id = $request->id;

        try {
            $productCategory = ProductCategory::find($id);

            $status = $productCategory->delete();

            if ($status) {
                $this->setResponseInfo('success', 'Your product category has been deleted successfully!');

            } else {
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
        }

        return response()
            ->json($this->response, $this->httpStatus);

    }
}
