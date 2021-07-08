<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * To display login page
     */
    public function showLoginPage()
    {
        return view('login');
    }
}
