<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SlipPrintingAlignmnt;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;

class SaleController extends GenericController
{
    use SlipPrintingAlignmnt;
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
        session(['voucher_no' => '']);
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

            session(['voucher_no' => $sale->voucher_number]);

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
            $saleDateTime = date('d/m/Y h:i A', strtotime($saleDateTime));
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
            $paid = $request->customer_paid_amount; //set user paid amount later

            if($paid != "" && $paid > 0){
                $balance = $grandTotal - $paid;
                $balance = number_format($balance, 0, '.', ',');
            }
            else{
                $paid = number_format($grandTotal, 0, '.', ',');
                $balance = "-";
            }




            $total = number_format($total, 0,'.', ',');
            $tax = number_format($tax, 0,'.', ',');
            $grandTotal = number_format($grandTotal, 0,'.', ',');




            // Set params
            $store_name = SystemSetting::where('setting_name', 'store_name')->first()->setting_value;
            $store_address = SystemSetting::where('setting_name', 'store_address')->first()->setting_value;
            $store_phone = SystemSetting::where('setting_name', 'store_phone')->first()->setting_value;
            $store_email = SystemSetting::where('setting_name', 'store_email')->first()->setting_value;
            $store_website = SystemSetting::where('setting_name', 'store_website')->first()->setting_value;
            $voucherNo = session('voucher_no');
            $currency = SystemSetting::where('setting_name', 'currency')->first()->setting_value;
            $printerName = SystemSetting::where('setting_name', 'printer_name')->first()->setting_value;

            $connector = new CupsPrintConnector($printerName);
            $printer = new Printer($connector);

            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text($store_name."\n");
            $printer -> text($store_address."\n");
            $printer -> text($store_phone."\n");
            $printer -> text($store_email."\n");
            $printer -> text($store_website."\n");
            $printer -> text($store_website."\n");
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Sold at : ".$saleDateTime."\n");
            $printer -> text("Voucher No : ".$voucherNo."\n");

            if($customerName !=""){
                $printer -> text("Customer Name: ".$customerName."\n");
            }

            if($customerPhone !=""){
                $printer -> text("Customer Phone: ".$customerPhone."\n");
            }




            $this->setSlipLineBreak($printer);


            $printer -> text("|No.|      Item      | Qty |  Price  |  Amount |\n");

            $this->setSlipLineBreak($printer);

            foreach ($productIds as $key => $productId) {
                $price = $productUnitPrices[$key];
                $price = number_format($price, 0,'.', ',');
                $qty = $quantities[$key];
                $amount = $amounts[$key];
                $amount = number_format($amount, 0,'.', ',');
                $productName = Product::find($productId)->name;
                $iNo = $key + 1;

                $iNo = $this->setItemNoAligned($iNo);
                $productName = $this->setItemAligned($productName);
                $qty = $this->setQtyAligned($qty);
                $price = $this->setPriceAligned($price);
                $amount = $this->setAmountAligned($amount);


                $printer -> text("|{$iNo}|{$productName}|{$qty}|{$price}|{$amount}|\n");

            }

            // $printer -> text("| 1 |Item-1          | 2   |    2,000|    4,000|\n");

            $this->setSlipLineBreak($printer);
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $printer -> text("Sub-total: {$total} {$currency}|\n");
            $printer -> text(" Tax: {$tax} {$currency}|\n");
            $printer -> text("Grand Total: {$grandTotal} {$currency}|\n");
            $printer -> text("Paid: {$paid} {$currency}|\n");
            $printer -> text("Balance: {$balance} {$currency}|\n");


            $printer -> text("\n\n\n");

            $printer -> setJustification(Printer::JUSTIFY_CENTER);

            $printer -> text("Thank you for your buy, see you again\n\n");


            $this->setSlipLineBreak($printer);

            $printer -> cut();
            $printer -> close();


            $this->setResponseInfo('success', 'Your slip print is successfully done!');



        } catch (\Throwable$th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
