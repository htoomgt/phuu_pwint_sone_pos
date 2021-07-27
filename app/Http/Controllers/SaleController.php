<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends GenericController
{
    public function showMainSalePage()
    {
        $this->setPageTitle("Point of Sale", "");

        return view('sale.main-sale-page');
    }
}
