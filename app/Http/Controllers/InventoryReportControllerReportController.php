<?php

namespace App\Http\Controllers;

use App\Exports\CurrentInventoryExport;
use App\Models\Product;
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
            $productIds = request()->products ?? [];
            $strProductIds = "";

            if(count($productIds) == 0){
                $productIds = Product::query()->get('id');
                $strProductIds = $productIds->implode("id", ",");           
            }
            else{                
                $strProductIds = implode(',', $productIds);
            }

            // dd($strProductIds);

            


           
            


            // $data = DB::select("CALL `current_inventory`('{$strProductIds}');");
            $data = DB::select("CALL `current_inventory`( '".$strProductIds."' );");

           

            
            return DataTables::of($data)
                ->editColumn('unit_price', function ($query) {
                    return number_format($query->unit_price, 0);
                })                
                ->editColumn('balance', function ($query) {
                    return number_format($query->balance, 0);
                })
                
                ->toJson();
                // ->make(true);

        }

        $dataTable = $builder->columns([

            // ['data' => 'name', 'title' => 'Date'],
            // ['data' => 'myanmar_name', 'title' => 'Item'],
            // ['data' => 'product_code', 'title' => 'Product Code'],
            // ['data' => 'category', 'title' => 'Category'],
            // ['data' => 'measure_unit', 'title' => 'Measure Unit'],
            // ['data' => 'unit_price', 'title' => 'Unit Price'],
            // ['data' => 'reorder_level', 'title' => 'Sale Quantity'],
            // ['data' => 'ex_mill_price', 'title' => 'Sale Amount'],
            // ['data' => 'transport_fee', 'title' => 'Profit Per Unit'],
            // ['data' => 'unload_fee', 'title' => 'Profit'],

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
        $productIds = $request->products ?? [];
        $strProductIds = "";

        if(count($productIds) == 0){
            $productIds = Product::query()->get('id');
            $strProductIds = $productIds->implode("id", ",");           
        }
        else{                
            $strProductIds = implode(',', $productIds);
        }

        $fileNumberWithTime = date('YmdHis');

        return (new CurrentInventoryExport($strProductIds))->download('current_inventory_report_'.$fileNumberWithTime.'.xlsx');;


    }
}
