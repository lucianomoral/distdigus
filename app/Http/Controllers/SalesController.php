<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ListHeader;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(){

        return view('sales.sales');

    }

    public function create(){

        $customer = Customer::all();
        $listheader = ListHeader::all();

        return view('sales.salesNew', ['customer' => $customer, 'listheader' => $listheader]);

    }

}