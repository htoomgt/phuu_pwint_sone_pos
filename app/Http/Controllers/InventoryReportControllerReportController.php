<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        }




        return view('report.inventory', compact(['dataTable', 'dataTableId']));
    }

    public function inventoryExport(Request $request)
    {
        
    }
}
