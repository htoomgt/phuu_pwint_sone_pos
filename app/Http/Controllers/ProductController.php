<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;


class ProductController extends GenericController implements ResourceFunctions
{
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("Manage Product", "Product");
        $statusUpdateUrl = route('product.statusUpdateById');
        $deleteUrl = route('product.deleteById');
        $dataTableId = "#dtProduct";

        if (request()->ajax()) {
            $model = Product::query()
                ->selectRaw("products.*,
                    pct.name as product_category_name,
                    pmu.name as product_measure_unit,
                    cu.full_name as creator_name,
                    uu.full_name as updater_name
                ")
                ->leftJoin('product_categories as pct', 'products.category_id', '=', 'pct.id')
                ->leftJoin('product_measure_units as pmu', 'products.measure_unit_id', '=', 'pmu.id')
                ->leftJoin('users as cu', 'products.created_by', '=', 'cu.id')
                ->leftJoin('users as uu', 'products.updated_by', '=', 'uu.id');


            return DataTables::of($model)
                ->addColumn('actions', function (Product $product) use ($deleteUrl, $dataTableId) {
                    $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onClick="productCategoryEdit(' . $product->id . ')"

                            >
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a class="dropdown-item" href="#" onclick = "dtDeleteRow(' . $product->id . ', `' . $deleteUrl . '`, `' . $dataTableId . '`)">
                        <i class="far fa-trash-alt"></i>
                        Delete
                    </a>
                  </div>
                </div>
            ';

                    return $actions;
                })
                ->editColumn('status', function (Product $productCategory) use ($statusUpdateUrl, $dataTableId) {
                    $displayStatus = '';
                    $statusAction = '';

                    if ($productCategory->status == 'active') {
                        $displayStatus = 'Active';
                        $statusAction = '
                        <a class="dropdown-item" href="#" onclick="dtChangeStatus(`' . $productCategory->id . '`, `inactive`, `' . $statusUpdateUrl . '`, `' . $dataTableId . '` )">
                            Inactive
                        </a>
                    ';
                    } else {
                        $displayStatus = 'inactive';
                        $statusAction = '
                        <a class="dropdown-item" href="#" onclick="dtChangeStatus(`' . $productCategory->id . '`, `active`, `' . $statusUpdateUrl . '`, `' . $dataTableId . '` )">
                            Active
                        </a>
                    ';
                    }

                    $statusColorClass = $displayStatus == "Active" ? "btn-success" : "btn-secondary";

                    return '<div class="dropdown">
                      <button class="btn ' . $statusColorClass . ' dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ' . $displayStatus . '
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        ' . $statusAction . '
                      </div>
                    </div>';
                })
                ->filterColumn('category', function ($query, $keyword){
                    $query->where('pct.name', 'LIKE', "%{$keyword}%");
                })
                ->addColumn('category', function(Product $product){
                    return $product->product_category_name;
                })
                ->orderColumn('category', function ($query, $order) {
                    $query->orderBy('pct.name', $order);
                })
                ->addColumn('measure_unit', function(Product $product){
                    return $product->product_measure_unit;
                })
                ->filterColumn('measure_unit', function ($query, $keyword){
                    return $query->where('pmu.name', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('measure_unit', function ($query, $order) {
                    return $query->orderBy('pmu.name', $order);
                })
                ->addColumn('creator', function(Product $product){
                    return $product->creator_name;
                })
                ->filterColumn('creator', function ($query, $keyword){
                    return $query->where('cu.full_name', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('creator', function ($query, $order) {
                    $query->orderBy('cu.full_name', $order);
                })
                ->addColumn('updater', function(Product $product){
                    return $product->updater_name;
                })
                ->filterColumn('updater', function ($query, $keyword){
                    return $query->where('uu.full_name', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('updater', function ($query, $order) {
                    $query->orderBy('uu.full_name', $order);
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
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'myanmar_name', 'title' => 'Myanmar Name'],
            ['data' => 'category', 'title' => 'Category'],
            ['data' => 'product_code', 'title' => 'Product Code'],
            ['data' => 'measure_unit', 'title' => 'Measure Unit'],
            ['data' => 'unit_price', 'title' => 'Unit Price'],
            ['data' => 'reorder_level', 'title' => 'Reorder Level'],
            ['data' => 'ex_mill_price', 'title' => 'Ex-mill Price'],
            ['data' => 'transport_fee', 'title' => 'Transport fee'],
            ['data' => 'unload_fee', 'title' => 'Unload fee'],
            ['data' => 'creator', 'title' => 'Creator'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updater', 'title' => 'Updater'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "responsive" => false,
                "autoWidth" => false,
                "order" => [
                    [0, 'desc'],
                ],
                "columnDefs" => [
                    /* ["width" => "5%", "targets" => 0],
                    ["width" => "10%", "targets" => 1],
                    ["width" => "20%", "targets" => 2],
                    ["width" => "25%", "targets" => 3],
                    ["width" => "20%", "targets" => 4],
                    ["width" => "20%", "targets" => 5], */

                ],

            ]);

        return view('product.product-show-list', compact('dataTable'));
    }

    /**
     * To show product create view page
     * @return View
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function create():View
    {
        $this->setPageTitle("Manage Product", "Product Create");
        return view('product.product-create');
    }

    /**
     * To create new product
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function addNew(Request $request):JsonResponse
    {
        try {

            $dataFormPost = $request->all();
            $authUserId = Auth::user()->id;

            $dataFormPost['created_by'] = $authUserId;
            $dataFormPost['updated_by'] = $authUserId;

            $product = Product::create($dataFormPost);

            if(!empty($product) && $product->id > 0)
            {
                $this->setResponseInfo('success', 'Your product has been created successfully');
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

    public function getDataRowById(Request $request)
    {

    }

    public function edit(Product $productCategory)
    {

    }

    public function updateById(Request $request)
    {

    }

    /**
     * To update status by requested status
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function statusUpdateById(Request $request)
    {
        try {
            $status = Product::whereId($request->id)->update([
                'status' => $request->statusToChange
            ]);

            if($status)
            {
                $this->setResponseInfo('success');
            }
            else{
                $this->setResponseInfo('fail');
            }

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);

    }

    /**
     * To delete product record by Id
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     */
    public function deleteById(Request $request):JsonResponse
    {
        try {
            $status = Product::whereId($request->id)->delete();

            if($status)
            {
                $this->setResponseInfo('success', 'Your product has been deleted successfully');
            }
            else{
                $this->setResponseInfo('fail');
            }


        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
