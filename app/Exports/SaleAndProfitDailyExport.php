<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleAndProfitDailyExport implements FromQuery, WithHeadings
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
            'Sale Date',
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
                    sales.created_at AS 'sale_date',
                    p.name AS 'product_name',
                    p.product_code,
                    pc.name AS 'product_category',
                    pmu.name AS 'product_measure_unit',
                    sd.unit_price,
                    sum(sd.quantity) AS 'sale_quantity',
                    sum(sd.amount) AS 'sale_amount',
                    sd.profit_per_unit,
                    (sd.profit_per_unit * sum(sd.quantity) ) AS 'profit'
                ")
                ->leftJoin('sale_details AS sd', 'sales.id', '=', 'sd.sale_id')
                ->leftJoin('products AS p', 'sd.product_id', '=', 'p.id')
                ->leftJoin('product_categories AS pc', 'p.category_id', '=', 'pc.id')
                ->leftJoin('product_measure_units AS pmu', 'p.measure_unit_id', '=', 'pmu.id')                
                ->groupBy(DB::raw('cast(sales.created_at as date)'))
                ->groupBy('p.id')
                ->orderBy('sales.created_at', 'ASC')
                ->orderBy('p.name', 'ASC');



            if (isset($productIds)) {
                $query = $query->whereIn('sd.product_id', $productIds);
            }

            if ($this->startDateTime != "" && $this->endDateTime != "") {
                $query = $query->where('sales.created_at', '>=', $this->startDateTime)
                    ->where('sales.created_at', '<=', $this->endDateTime );
            }
        return $query;
    }


}
