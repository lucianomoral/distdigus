<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ListHeader;
use App\CustInvoiceHeader;
use App\CustInvoiceLine;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesReportInvoice($invoiceid)
    {
        $invoicelines = \DB::select("SELECT ITEMID, ITEMNAME, QTY, PRICE, TOTAL FROM CUSTINVOICEDETAILS WHERE INVOICEID = :id", [":id" => $invoiceid]);

        return view('sales.salesReportInvoice', ["invoiceline" => $invoicelines, "invoiceid" => $invoiceid, "total" => 0]);
    }
}