<?php

namespace App\Http\Controllers\Traits;

use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

trait ProductControllerTrait
{
    public function getDataTableResponseData($model, $statusUpdateUrl, $deleteUrl, $dataTableId)
    {
        return DataTables::of($model)
            ->addColumn('actions', function (Product $product) use ($deleteUrl, $dataTableId) {
                $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="' . route('product.edit', $product->id) . '"

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
            ->filterColumn('category', function ($query, $keyword) {
                $query->where('pct.name', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('category', function (Product $product) {
                return $product->product_category_name;
            })
            ->orderColumn('category', function ($query, $order) {
                $query->orderBy('pct.name', $order);
            })
            ->addColumn('measure_unit', function (Product $product) {
                return $product->product_measure_unit;
            })
            ->filterColumn('measure_unit', function ($query, $keyword) {
                return $query->where('pmu.name', 'LIKE', "%{$keyword}%");
            })
            ->orderColumn('measure_unit', function ($query, $order) {
                return $query->orderBy('pmu.name', $order);
            })
            ->addColumn('creator', function (Product $product) {
                return $product->creator_name;
            })
            ->filterColumn('creator', function ($query, $keyword) {
                return $query->where('cu.full_name', 'LIKE', "%{$keyword}%");
            })
            ->orderColumn('creator', function ($query, $order) {
                $query->orderBy('cu.full_name', $order);
            })
            ->addColumn('updater', function (Product $product) {
                return $product->updater_name;
            })
            ->filterColumn('updater', function ($query, $keyword) {
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

    public function getDataTableStructure($builder)
    {
        return $builder->columns([
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
                "responsive" => true,
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
                    ["width" => "20%", "targets" => 5], */],

            ]);
    }

    public function validateProductCreateRequest($request)
    {
        $validationRule = [
            'name' => "required|min:3|max:255",
            "myanmar_name" => "min:3",
            "product_code" => "required|min:3|max:255",
            "category_id" => "required|exists:product_categories,id",
            "measure_unit_id" => "required|exists:product_measure_units,id",
            "reorder_level" => "required|numeric",
            "ex_mill_price" => "required|numeric|min:1",
            "transport_fee" => "numeric|numeric|min:0",
            "unload_fee" => "numeric|numeric|min:0",
            "unit_price" => "required|numeric|min:1",
        ];

        if ($request->breakdown_parent != '') {
            $ruleToAdd = [
                "breadown_parent_full_multiplier" => "required|numeric|min:2",
            ];
            $validationRule = array_merge($validationRule, $ruleToAdd);
        }

        $request->validate($validationRule);
    }

    public function validateProductFindById($request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
    }

    public function validateUpdateByIdRequest($request)
    {
        $validationRule = [
            'id' => 'required|exists:products,id',
            'name' => "required|min:3|max:255",
            "myanmar_name" => "min:3",
            "product_code" => "required|min:3|max:255",
            "category_id" => "required|exists:product_categories,id",
            "measure_unit_id" => "required|exists:product_measure_units,id",
            "reorder_level" => "required|numeric",
            "ex_mill_price" => "required|numeric|min:1",
            "transport_fee" => "numeric|numeric|min:0",
            "unload_fee" => "numeric|numeric|min:0",
            "unit_price" => "required|numeric|min:1",
        ];

        if ($request->breakdown_parent != '') {
            $ruleToAdd = [
                "breadown_parent_full_multiplier" => "required|numeric|min:2",
            ];
            $validationRule = array_merge($validationRule, $ruleToAdd);
        }



        $request->validate($validationRule);
    }

    public function validateProductStatusUpdateRequest($request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'statusToChange' => 'required|in:active,inactive',
        ]);
    }

    public function validateProductDeleteRequest($request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
    }

    public function validateGetProductByParentId($request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
    }
}
