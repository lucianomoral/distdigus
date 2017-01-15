<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ListHeader;
use App\CustInvoiceHeader;
use App\CustInvoiceLine;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.sales');
    }

    public function newSale()
    {
        $customer = Customer::all();
        $listheader = ListHeader::all();

        return view('sales.salesNew', ['customer' => $customer, 'listheader' => $listheader]);

    }

    public function create(Request $request)
    {
        $invoice = new CustInvoiceHeader;

        $invoice->CUSTID = $request->customerid;
        $invoice->STATUS = '0';
        $invoice->DESCRIPTION = $request->description;
        $invoice->DEFAULTLISTID = $request->listid;

        $invoice->save();

        $invoiceid = CustInvoiceHeader::orderBy('INVOICEID','desc')->first();

        return response()->json([
            "invoiceid" => $invoiceid->INVOICEID,
        ]);

    }

    public function addLines($invoiceid, $invoicePerPackQty = 1)
    {
        $invoice = CustInvoiceHeader::where('INVOICEID', $invoiceid)->first();

        $customer = Customer::where('CUSTID', $invoice->CUSTID)->first();

        $listheader = ListHeader::all();

        $custinvoiceline = \DB::select("SELECT LINENUM, ITEMID, ITEMNAME, QTY, PRICE FROM CUSTINVOICEDETAILS WHERE INVOICEID = :id", ["id" => $invoiceid]);

        $total = \DB::select("SELECT SUM(TOTAL) AS TOTAL FROM CUSTINVOICEDETAILS WHERE INVOICEID = :id", ["id" => $invoiceid]);

        return view('sales.salesAddLines', [
                                            'invoiceid' => $invoiceid, 
                                            'custid' => $invoice->CUSTID, 
                                            'custname' => $customer->CUSTNAME, 
                                            'listid' => $invoice->DEFAULTLISTID, 
                                            'listheader' => $listheader,
                                            'custinvoiceline' => $custinvoiceline,
                                            'total' => $total[0]->TOTAL,
                                            'invoiceperpackqty' => $invoicePerPackQty
                                            ]
                    );

    }

    public function saveInvoiceLine(Request $request)
    {
        $numOfLines;
        $linenum;
        $line = new CustInvoiceLine;

        //Primero consulto el número de lineas que tenga la factura
        $numOfLines = CustInvoiceLine::where("INVOICEID", $request->invoiceid)->count();

        //Si no tienen ninguna linea, entonces la linea a ingresar será la número 1, sino busca la máxima y le suma 1
        if ($numOfLines == 0)
        {
            $linenum = 1;
        }
        else
        {
            $linenum = CustInvoiceLine::where("INVOICEID", $request->invoiceid)->max('LINENUM') + 1;
        }

        //Guardar la linea con los datos recibidos
        $line->INVOICEID = $request->invoiceid;
        $line->LINENUM = $linenum;
        $line->ITEMID = $request->itemid;
        $line->QTY = $request->qty;
        $line->PRICE = $request->price;

        $line->save();

        return response()->json([
            "invoiceid" => $line->INVOICEID
        ]);
    }

    public function deleteInvoiceLine(Request $request)
    {
        $invoiceid = $request->invoiceid;
        $linenum = $request->linenum;

        CustInvoiceLine::where([
            ['INVOICEID', '=', $invoiceid],
            ['LINENUM', '=', $linenum]
        ])->delete();

    }

}