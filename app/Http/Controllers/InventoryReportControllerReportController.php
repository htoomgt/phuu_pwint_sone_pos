<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class InventoryReportControllerReportController extends GenericController
{
    public function showReportPage(Builder $builder)
    {
        $this->setPageTitle("Report", "Inventory");
        $dataTableId = "dtInventory";
        $dataTable = null;

        if (request()->ajax()) {
            $productIds = request()->products;
            $startDate = request()->start_date;
            $endDate = request()->end_date;

            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));


            $model = DB::table('sales')
                    ->selectRaw('*')
                    ->leftJoin('sale_details AS sd', 'sales.id', '=', 'sd.sale_id')
                    ->leftJoin('products AS p', 'sd.product_id', '=', 'p.id')
                    ->leftJoin('product_categories AS pc', 'p.category_id', '=', 'pc.id')
                    ->leftJoin('product_measure_units AS pmu', 'p.measure_unit_id', '=', 'pmu.id');

            if (isset($productIds)) {
                $model = $model->whereIn('sd.product_id', $productIds);
            }

            if ($startDate != "" && $endDate != "") {
                $model = $model->where('sales.created_at', '>=', $startDate . " 00:00:00")
                    ->where('sales.created_at', '<=', $endDate . " 23:59:59");
            }

            return DataTables::of($model)
                ->editColumn('sale_amount', function ($query) {
                    return number_format($query->sale_amount, 0);
                })
                ->editColumn('profit_per_unit', function ($query) {
                    return number_format($query->profit_per_unit, 0);
                })
                ->editColumn('profit', function ($query) {
                    return number_format($query->profit, 0);
                })
                ->editColumn('sale_date', function ($query) {
                    return date('d, M, Y', strtotime($query->sale_date));
                })
                ->toJson();

        }

        $dataTable = $builder->columns([

            ['data' => 'name', 'title' => 'Date'],
            ['data' => 'myanmar_name', 'title' => 'Item'],
            ['data' => 'product_code', 'title' => 'Product Code'],
            ['data' => 'category', 'title' => 'Category'],
            ['data' => 'measure_unit', 'title' => 'Measure Unit'],
            ['data' => 'unit_price', 'title' => 'Unit Price'],
            ['data' => 'reorder_level', 'title' => 'Sale Quantity'],
            ['data' => 'ex_mill_price', 'title' => 'Sale Amount'],
            ['data' => 'transport_fee', 'title' => 'Profit Per Unit'],
            ['data' => 'unload_fee', 'title' => 'Profit'],

        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "responsive" => true,
                "autoWidth" => true,
                "searching" => false,
                "deferLoading" => 0,
                "ajax" => [
                    "url" => route('report.saleAndProfit'),
                    "data" => "function(d){
                        d.start_date = $('#start_date').val(),
                        d.end_date = $('#end_date').val()
                    }",
                ],
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


        return view('report.inventory', compact(['dataTable', 'dataTableId']));
    }

    public function inventoryExport(Request $request)
    {
        
    }
}
