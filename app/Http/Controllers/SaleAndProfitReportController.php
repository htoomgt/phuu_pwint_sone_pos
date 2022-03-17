<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SaleAndProfitReportController extends GenericController
{
    public function showReportPage(Builder $builder)
    {
        $this->setPageTitle("Report", "Sale And Profit");
        $dataTableId = "#dtSaleAndProfit";

        if(request()->ajax()){
            $totalSaleOnDate = request()->total_sale_on_date;
            $product = request()->product;
            $startDate = request()->start_date;
            $endDate = request()->end_date;

            $datesToSearch = $this->generateSqlInsertReadyDates($startDate, $endDate);



            $model = Sale::query()
                ->selectRaw("
                    sales.created_at AS 'sale_date',
                    p.name AS 'product_name',
                    p.product_code,
                    pc.name AS 'product_category',
                    pmu.name AS 'product_measure_unit',
                    sd.unit_price,
                    sd.quantity AS 'sale_quantity',
                    sd.amount AS 'sale_amount',
                    sd.profit_per_unit,
                    (sd.profit_per_unit * sd.quantity) AS 'profit'
                ")
                ->leftJoin('sale_details AS sd', 'sales.id', '=', 'sd.sale_id')
                ->leftJoin('products AS p', 'sd.product_id', '=', 'p.id')
                ->leftJoin('product_categories AS pc', 'p.category_id', '=', 'pc.id')
                ->leftJoin('product_measure_units AS pmu', 'p.measure_unit_id', '=', 'pmu.id');

            return DataTables::of($model)
                // ->filterColumn('category', function ($query, $keyword){
                //     $query->where('pct.name', 'LIKE', "%{$keyword}%");
                // })
                // ->addColumn('category', function(Product $product){
                //     return $product->product_category_name;
                // })
                // ->orderColumn('category', function ($query, $order) {
                //     $query->orderBy('pct.name', $order);
                // })
                // ->addColumn('measure_unit', function(Product $product){
                //     return $product->product_measure_unit;
                // })
                // ->filterColumn('measure_unit', function ($query, $keyword){
                //     return $query->where('pmu.name', 'LIKE', "%{$keyword}%");
                // })
                // ->orderColumn('measure_unit', function ($query, $order) {
                //     return $query->orderBy('pmu.name', $order);
                // })
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

        return view("report.sale_and_profit", compact(['dataTable','dataTableId']));
    }

    public function exportRequestReport(Request $request){

    }
}
