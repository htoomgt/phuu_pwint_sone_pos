<?php

namespace App\Http\Controllers;

use App\Models\ProductMeasureUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class ProductMeasureUnitController extends GenericController implements ResourceFunctions
{
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("Manage Product", "Product Measure Unit");
        $statusUpdateUrl = route('productMeasureUnit.statusUpdateById');
        $deleteUrl = route('productMeasureUnit.deleteById');
        $dataTableId = "#dtProductMeasureUnit";

        if (request()->ajax()) {
            $model = ProductMeasureUnit::query();

            return DataTables::of($model)
            ->addColumn('actions', function(ProductMeasureUnit $productMeasureUnit)use($deleteUrl, $dataTableId){
                $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onClick="productCategoryEdit('.$productMeasureUnit->id.')"

                            >
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a class="dropdown-item" href="#" onclick = "dtDeleteRow('.$productMeasureUnit->id.', `'.$deleteUrl.'`, `'.$dataTableId.'`)">
                        <i class="far fa-trash-alt"></i>
                        Delete
                    </a>
                  </div>
                </div>
            ';



            return  $actions;
            })
            ->editColumn('status', function(ProductMeasureUnit $productMeasureUnit)use($statusUpdateUrl, $dataTableId){
                $displayStatus = '';
                $statusAction = '';


                if($productMeasureUnit->status == 'active'){
                    $displayStatus = 'Active';
                    $statusAction = '
                        <a class="dropdown-item" href="#" onclick="dtChangeStatus(`'.$productMeasureUnit->id.'`, `inactive`, `'.$statusUpdateUrl.'`, `'.$dataTableId.'` )">
                            Inactive
                        </a>
                    ';
                }
                else{
                    $displayStatus = 'inactive';
                    $statusAction = '
                        <a class="dropdown-item" href="#" onclick="dtChangeStatus(`'.$productMeasureUnit->id.'`, `active`, `'.$statusUpdateUrl.'`, `'.$dataTableId.'` )">
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
            ->rawColumns(['actions', 'status'])
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

    public function addNew(Request $request)
    {

    }

    public function getDataRowById(Request $request)
    {

    }

    public function updateById(Request $request)
    {

    }

    public function statusUpdateById(Request $request)
    {
        $id = $request->id;
        $statusToChange = $request->statusToChange;

        try {
            $status = ProductMeasureUnit::whereId($id)->update(['status' => $statusToChange]);

            if($status){
                $this->setResponseInfo('success');
            }
            else{
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    public function deleteById(Request $request)
    {
        try {
            $status = ProductMeasureUnit::whereId($request->id)->delete();

            if($status){
                $this->setResponseInfo('success', 'Your product measure unit has been deleted successfully!');
            }
            else{
                $this->setResponseInfo('fail');
            }

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
