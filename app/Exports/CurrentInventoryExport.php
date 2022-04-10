<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CurrentInventoryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private $strProductIds = "";

    public function __construct($strProductIds = "")
    {
        $this->strProductIds = $strProductIds;
    }

    public function headings(): array
    {
        return [
            'Product Id',
            'Product Name',
            'Product Code',
            'Product Category',
            'Product Measure Unit',
            'Unit Price',
            'Balance'
        ];
    }

    public function collection()
    {
        $data = DB::select("CALL `current_inventory`( '".$this->strProductIds."' );");

        $dataCollect = collect($data);
        // dd($dataCollect);

        // $dataCollectOnly = $dataCollect->only(['product_id', 'product_name', 'product_code'])->all();

        $dataCollectOnly = $dataCollect->map(function($data){
            $collectData = collect($data)->only([
                'product_id', 
                'product_name', 
                'product_code',
                'product_category',
                'product_measure_unit',
                'unit_price',
                'balance'
            ]);

            return $collectData->toArray();
        });

        
        return $dataCollectOnly;

    }





    
}
