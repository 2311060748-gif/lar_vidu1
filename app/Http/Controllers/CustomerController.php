<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Customer dashboard
     */
    public function dashboard()
    {
        return view('customer.dashboard');
    }
}
