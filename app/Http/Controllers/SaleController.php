<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;



class SaleController extends GenericController
{
    /**
     * To show main point of sale page
     * @return View
     */
    public function showMainSalePage()
    {
        $this->setPageTitle("Point of Sale", "");

        return view('sale.main-sale-page');
    }

    /**
     * To make payment and save record of sale
     * @param Request $request
     * @return JsonResponse
     * @author Htoo Maung Thait
     * @since 2021-08-02
     * */
    public function makePayment(Request $request):JsonResponse
    {
        try {
            // dd($request->all());
            $saleDateTime = $request->sale_datetime;
            $customerName = $request->customer_name;
            $customerPhone = $request->customer_phone;
            $productIds = $request->product_id;
            $productUnitPrices = $request->unit_price;
            $quantities = $request->quantity;
            $amounts = $request->amount;
            $total = $request->total;
            $taxPercentage = 0; //Get from config later
            $tax = $total * ($taxPercentage/100);
            $grandTotal = $total + ($tax);





            //Insert Into Sale Table
            $sale = Sale::create([
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'sold_at' => $saleDateTime,
                'sold_by' => Auth::user()->id,
                'total_amount' => $total,
                'tax' => $tax,
                'grand_total' => $grandTotal
            ]);

            $saleId = $sale->id;
            $sale->voucher_number = $saleId;
            $sale->save();






            //Loop and insert into sale detail table
            foreach ($productIds as $key => $productId) {
                $unitPrice = $productUnitPrices[$key];
                $quantity = $quantities[$key];
                $amount = $amounts[$key];

                    $saleDetail = SaleDetails::updateOrCreate([
                        'sale_id' => $saleId,
                        'product_id' => $productId
                    ],[
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'amount' => $amount,
                    ]);

            }

            //Compose success message
            $this->setResponseInfo('success', 'Your sale voucher has been recorded successfully', '', '', '');

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To print with slip printer of sale record
     * @param Request $request
     * @return JsonResponse
     * @author Htoo Maung Thait
     * @since 2021-08-02
     */
    public function printSlip(Request $request):JsonResponse
    {
        try {

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
