<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

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
    public function makePayment(Request $request): JsonResponse
    {
        session('voucher_no', '');
        try {
            $saleDateTime = $request->sale_datetime;
            $customerName = $request->customer_name;
            $customerPhone = $request->customer_phone;
            $productIds = $request->product_id;
            $productUnitPrices = $request->unit_price;
            $quantities = $request->quantity;
            $amounts = $request->amount;
            $total = $request->total;
            $taxPercentage = 0; //Get from config later
            $tax = $total * ($taxPercentage / 100);
            $grandTotal = $total + ($tax);

            //Insert Into Sale Table
            $sale = Sale::create([
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'sold_at' => $saleDateTime,
                'sold_by' => Auth::user()->id,
                'total_amount' => $total,
                'tax' => $tax,
                'grand_total' => $grandTotal,
            ]);

            $saleId = $sale->id;
            $sale->voucher_number = $saleId;
            $sale->save();

            session('voucher_no', $sale->voucher_number);

            //Loop and insert into sale detail table
            foreach ($productIds as $key => $productId) {
                $unitPrice = $productUnitPrices[$key];
                $quantity = $quantities[$key];
                $amount = $amounts[$key];

                $saleDetail = SaleDetails::updateOrCreate([ // for duplicate product Id and take last one only
                    'sale_id' => $saleId,
                    'product_id' => $productId,
                ], [
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'amount' => $amount,
                ]);

            }

            //Compose success message
            $this->setResponseInfo('success', 'Your sale voucher has been recorded successfully', '', '', '');

        } catch (\Throwable$th) {
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
    public function printSlip(Request $request): JsonResponse
    {
        try {
            // Get form params
            $saleDateTime = $request->sale_datetime;
            $customerName = $request->customer_name;
            $customerPhone = $request->customer_phone;
            $productIds = $request->product_id;
            $productUnitPrices = $request->unit_price;
            $quantities = $request->quantity;
            $amounts = $request->amount;
            $total = $request->total;
            $taxPrcentage = SystemSetting::where('setting_name', 'tax_percentage')->first()->setting_value;
            $tax = $total * ($taxPrcentage / 100);
            $grandTotal = $total + ($tax);


            // Set params
            $mid = session('voucher_no');
            $store_name = SystemSetting::where('setting_name', 'store_name')->first()->setting_value;
            $store_address = SystemSetting::where('setting_name', 'store_address')->first()->setting_value;
            $store_phone = SystemSetting::where('setting_name', 'store_phone')->first()->setting_value;
            $store_email = SystemSetting::where('setting_name', 'store_email')->first()->setting_value;
            $store_website = SystemSetting::where('setting_name', 'store_website')->first()->setting_value;
            $transaction_id = session('voucher_no');
            $currency = SystemSetting::where('setting_name', 'currency')->first()->setting_value;

            // Init printer
            $printer = new ReceiptPrinter;
            $printer->init(
                config('receiptprinter.connector_type'),
                config('receiptprinter.connector_descriptor')
            );

            // Set store info
            $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

            // Add items
            foreach ($productIds as $key => $productId) {
                $unitPrice = $productUnitPrices[$key];
                $quantity = $quantities[$key];
                $amount = $amounts[$key];
                $productName = Product::find($productId)->product_name;


                $printer->addItem($productName, $quantity, $unitPrice);


            }




            // Set currency
            $printer->setCurrency($currency);

            // Set request amount
            $printer->setRequestAmount($grandTotal);

            // Set transaction ID
            $printer->setTransactionID($transaction_id);

            // Set qr code
            $printer->setQRcode([
                'tid' => $transaction_id,
                'amount' => $grandTotal,
            ]);

            // Print receipt
            $printer->printReceipt();

            $this->setResponseInfo('success', 'Your slip print is successfully done!');



        } catch (\Throwable$th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
