<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function showDashboard()
    {
        session()->put('page_title', 'Dashboard');
        return view('dashboard');
    }
}
