<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;

class HomeController extends GenericController
{
    /**
     * To show dashboard reports
     * @author Htoo Maung Thait
     * @return  \Illuminate\View\View
     */
    public function showDashboard()
    {
        $this->setPageTitle("Dashboard");
        return view('dashboard');
    }


}
