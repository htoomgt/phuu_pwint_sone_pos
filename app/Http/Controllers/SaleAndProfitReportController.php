<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SaleAndProfitReportController extends GenericController
{
    public function showReportPage(Builder $builder)
    {
        $this->setPageTitle("Report", "Sale And Profit");
        $dataTableId = "#dtProduct";

        if(request()->ajax()){
            $startDate = request()->start_date;
            $endDate = request()->end_date;


            $model = Product::query()
                ->selectRaw("products.*,
                    pct.name as product_category_name,
                    pmu.name as product_measure_unit
                ")
                ->leftJoin('product_categories as pct', 'products.category_id', '=', 'pct.id')
                ->leftJoin('product_measure_units as pmu', 'products.measure_unit_id', '=', 'pmu.id');

            return DataTables::of($model)
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
                ->toJson();
        }

        $dataTable = $builder->columns([

            // ['data' => 'actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false],
            // ['data' => 'status', 'title' => 'Status'],
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

        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "responsive" => false,
                "autoWidth" => false,
                "searching" => false,
                "deferLoading" => 0,
                "ajax" => [
                    "url" => route('report.saleAndProfit'),
                    "data" => "function(d){
                        d.start_date = $('#start_date').val(),
                        d.end_date = $('#end_date').val()
                    }"
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
                    ["width" => "20%", "targets" => 5], */

                ],

            ]);

        return view("report.sale_and_profit", compact('dataTable'));
    }

    public function exportRequestReport(Request $request){

    }
}
