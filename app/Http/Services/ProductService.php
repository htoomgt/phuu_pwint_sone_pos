<?php

namespace App\Http\Services;


class ProductService
{

    public function productCriteriaChangeLogSaving($product, $request, $productCriteriaChangeLogWriteRepository)
    {
        $changesForComputeValue = false;



        $productCriteriaChangeLogToSave = [];
        $productCriteriaChangeLogToSave["product_id"] = $product->id;
        $productCriteriaChangeLogToSave["used_date"] = date('Y-m-d');

        if ($product->ex_mill_price != $request->ex_mill_price) {

            $productCriteriaChangeLogToSave["criteria_name"] = 'ex_mill_price';
            $productCriteriaChangeLogToSave["value_from"] = $product->ex_mill_price;
            $productCriteriaChangeLogToSave["value_to"] = $request->ex_mill_price;

            // removed duplicated rows dry best practice
            $changesForComputeValue = true;
        }

        if ($product->transport_fee != $request->transport_fee) {



            $productCriteriaChangeLogToSave["criteria_name"] = 'transport_fee';
            $productCriteriaChangeLogToSave["value_from"] = $product->transport_fee;
            $productCriteriaChangeLogToSave["value_to"] = $request->transport_fee;


            // removed duplicated rows dry best practice
            $changesForComputeValue = true;
        }

        if ($product->unload_fee != $request->unload_fee) {


            $productCriteriaChangeLogToSave["criteria_name"] = 'unload_fee';
            $productCriteriaChangeLogToSave["value_from"] = $product->unload_fee;
            $productCriteriaChangeLogToSave["value_to"] = $request->unload_fee;

            // removed duplicated rows dry best practice
            $changesForComputeValue = true;
        }

        if ($product->unit_price != $request->unit_price) {

            $productCriteriaChangeLogToSave["criteria_name"] = 'unit_price';
            $productCriteriaChangeLogToSave["value_from"] = $product->unit_price;
            $productCriteriaChangeLogToSave["value_to"] = $request->unit_price;

            // removed duplicated rows dry best practice
            $changesForComputeValue = true;
        }

        // $productCriteriaChangeLog->save();





        // Logging compute value if there were changes in basic value
        if ($changesForComputeValue) {

            $productCriteriaChangeLogWriteRepository->create($productCriteriaChangeLogToSave);


            $productCriteriaChangeLogToSave = [];
            $productCriteriaChangeLogToSave["product_id"] = $product->id;
            $productCriteriaChangeLogToSave["criteria_name"] = 'original_cost';
            $productCriteriaChangeLogToSave["value_from"] = $product->original_cost;
            $productCriteriaChangeLogToSave["value_to"] = $request->original_cost;
            $productCriteriaChangeLogToSave["used_date"] = date('Y-m-d');

            $productCriteriaChangeLogWriteRepository->create($productCriteriaChangeLogToSave);






            $productCriteriaChangeLogToSave = [];
            $productCriteriaChangeLogToSave["product_id"] = $product->id;
            $productCriteriaChangeLogToSave["criteria_name"] = 'profit_per_unit';
            $productCriteriaChangeLogToSave["value_from"] = $product->profit_per_unit;
            $productCriteriaChangeLogToSave["value_to"] = $request->profit_per_unit;
            $productCriteriaChangeLogToSave["used_date"] = date('Y-m-d');

            $productCriteriaChangeLogWriteRepository->create($productCriteriaChangeLogToSave);
        }
    }
}
