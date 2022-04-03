<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleAndProfitExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private $startDateTime = "";
    private $endDateTime = "";
    private $productIds = [];

    public function __construct(string $startDateTime = "", string $endDateTime = "", array $productIds = [])
    {
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->productIds = $productIds;
    }

    public function headings(): array
    {
        return [            
            'Product Name',
            'Product Code',
            'Product Category',
            'Product Measure Unit',
            'Unit Price',
            'Sale Quantity',
            'Sale Amount',
            'Profit Per Unit',
            'Profit'
        ];
    }

    
    
    public function query()
    {
        $query = DB::table('sales')
                ->selectRaw("                    
                    p.name AS 'product_name',
                    p.product_code,
                    pc.name AS 'product_category',
                    pmu.name AS 'product_measure_unit',
                    format(sd.unit_price, 0),
                    format(sum(sd.quantity),0) AS 'sale_quantity',
                    format(sum(sd.amount),0) AS 'sale_amount',
                    format(sd.profit_per_unit,0),
                    format((sd.profit_per_unit * sum(sd.quantity) ),0) AS 'profit'
                ")
                ->leftJoin('sale_details AS sd', 'sales.id', '=', 'sd.sale_id')
                ->leftJoin('products AS p', 'sd.product_id', '=', 'p.id')
                ->leftJoin('product_categories AS pc', 'p.category_id', '=', 'pc.id')
                ->leftJoin('product_measure_units AS pmu', 'p.measure_unit_id', '=', 'pmu.id')                                
                ->groupBy('p.id')                
                ->orderBy('p.name', 'ASC');



            if (count($this->productIds) > 0) {
                $query = $query->whereIn('sd.product_id', $this->productIds);
            }

            if ($this->startDateTime != "" && $this->endDateTime != "") {                
                $query = $query->where('sales.created_at', '>=', $this->startDateTime)
                    ->where('sales.created_at', '<=', $this->endDateTime );
            }
        
        return $query;
    }
}
