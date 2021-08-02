<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            dd($request->all());

            //Insert Into Sale Table

            //Loop and insert into sale detail table

            //Compose success message

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
