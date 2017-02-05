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

    public function salesClose($invoiceid = "")
    {
        $custinvoiceheader;
        
        //Tuve que usar el 'BINARY' porque sino me pinchaba la query desde PHP por distintos tipos de COLATION
        $custinvoiceheader = \DB::select("  SELECT INVOICEID, CUSTNAME, 
                                            CONCAT(
                                                RIGHT(CONCAT('00', DAY(MODIFIEDAT)), 2), 
                                                '/', 
                                                RIGHT(CONCAT('00', MONTH(MODIFIEDAT)), 2), 
                                                '/', 
                                                YEAR(MODIFIEDAT)
                                            ) AS MODIFIEDAT,
                                            DESCRIPTION, COUNT(*) AS QTYOFLINES, SUM(TOTAL) AS TOTAL 
                                            FROM CUSTINVOICEDETAILS
                                            WHERE BINARY STATUS = BINARY 'CERRADA' 
                                            GROUP BY INVOICEID, CUSTNAME, 3, DESCRIPTION
                                            ORDER BY INVOICEID DESC"
                                            );
        
        return view('sales.salesClose', ["custinvoiceheader" => $custinvoiceheader, "invoiceid" => $invoiceid]);
    }

    public function salesOpen()
    {
        $custinvoiceheader;
        
        //Tuve que usar el 'BINARY' porque sino me pinchaba la query desde PHP por distintos tipos de COLATION
        $custinvoiceheader = \DB::select("  SELECT INVOICEID, CUSTNAME, 
                                            CONCAT(
                                                RIGHT(CONCAT('00', DAY(CREATEDAT)), 2), 
                                                '/', 
                                                RIGHT(CONCAT('00', MONTH(CREATEDAT)), 2), 
                                                '/', 
                                                YEAR(CREATEDAT)
                                            ) AS CREATEDAT,
                                            DESCRIPTION, COUNT(*) AS QTYOFLINES, SUM(TOTAL) AS TOTAL 
                                            FROM CUSTINVOICEDETAILS
                                            WHERE BINARY STATUS = BINARY 'ABIERTA'
                                            GROUP BY INVOICEID, CUSTNAME, 3, DESCRIPTION
                                            ORDER BY INVOICEID DESC"
                                            );
        
        return view('sales.salesOpen', ["custinvoiceheader" => $custinvoiceheader]);
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

    public function addLines($invoiceid)
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
                                            ]
                    );

    }

    public function saveInvoiceLine(Request $request)
    {
        $numOfLines;
        $linenum;
        $lineSaved;
        $line = new CustInvoiceLine;
        $invoiceid = $request->invoiceid;

        //Primero consulto el número de lineas que tenga la factura
        $numOfLines = CustInvoiceLine::where("INVOICEID", $invoiceid)->count();

        //Si no tienen ninguna linea, entonces la linea a ingresar será la número 1, sino busca la máxima y le suma 1
        if ($numOfLines == 0)
        {
            $linenum = 1;
        }
        else
        {
            $linenum = CustInvoiceLine::where("INVOICEID", $invoiceid)->max('LINENUM') + 1;
        }

        //Guardar la linea con los datos recibidos
        $line->INVOICEID = $request->invoiceid;
        $line->LINENUM = $linenum;
        $line->ITEMID = $request->itemid;
        $line->QTY = $request->qty;
        $line->PRICE = $request->price;

        $line->save();

        $lineSaved = \DB::select("SELECT ITEMID, ITEMNAME, QTY, PRICE FROM CUSTINVOICEDETAILS WHERE INVOICEID = :id AND LINENUM = :linenum", ["id" => $invoiceid, "linenum" => $linenum]);

        return response()->json([
            "linenum" => $linenum,
            "itemid" => $lineSaved[0]->ITEMID,
            "itemname" => $lineSaved[0]->ITEMNAME,
            "qty" => $lineSaved[0]->QTY,
            "price" => $lineSaved[0]->PRICE
        ]);
    }

    public function deleteInvoiceLine(Request $request)
    {
        $invoiceid = $request->invoiceid;
        $linenum = $request->linenum;
        $qtyOfLinesDeleted;

        $qtyOfLinesDeleted = CustInvoiceLine::where([
                                ['INVOICEID', '=', $invoiceid],
                                ['LINENUM', '=', $linenum]
                            ])->delete();

        return response()->json([
            "qtyOfLinesDeleted" => $qtyOfLinesDeleted
        ]);

    }

    public function updateInvoiceLine(Request $request)
    {
        $qtyOfLinesUpdated = 0;
        $lineToUpdate;
        $invoiceid = $request->invoiceid;
        $linenum = $request->linenum;
        $qty = $request->qty;
        $price = $request->price;

        $lineToUpdate = CustInvoiceLine::where([
                                                ['INVOICEID', '=', $invoiceid],
                                                ['LINENUM', '=', $linenum]
                                                ])->get();

        //Si los datos que vienen son igual a los actuales, entonces no se realiza ninguna actualización pero se aumenta el contador de lineas actualizadas para que no parezca que hubo error.
        if ($lineToUpdate[0]->QTY == $qty && $lineToUpdate[0]->PRICE == $price)
        {
            $qtyOfLinesUpdated++;
        }
        //Si cantidad o precio es distinto, se produce la actualización
        else
        {
            $qtyOfLinesUpdated = CustInvoiceLine::where([
                                ['INVOICEID', '=', $invoiceid],
                                ['LINENUM', '=', $linenum]
                            ])->update([
                                'QTY' => $qty,
                                'PRICE' => $price
                            ]);
        }

        return response()->json([
            "qtyOfLinesUpdated" => $qtyOfLinesUpdated
        ]);

    }

    public function closeInvoice(Request $request)
    {
        $qtyOfLines;
        $qtyOfLinesUpdated;
        $status;
        $invoiceid = $request->invoiceid;

        $qtyOfLines = CustInvoiceLine::where("INVOICEID", $invoiceid)->count();

        if ($qtyOfLines > 0)
        {
            //Si tiene lineas, entonces se actualiza a status 1 (CERRADO)
            $qtyOfLinesUpdated = CustInvoiceHeader::where("INVOICEID", $invoiceid)->update(["STATUS" => "1"]);
            
            if($qtyOfLinesUpdated > 0)
            {
                $status = true;
                \DB::select("UPDATE CUSTINVOICEHEADER SET MODIFIEDAT = NOW() WHERE INVOICEID = :id", ["id" => $invoiceid]);
            }
            else
            {
                $status = false;
            }
        }
        else
        {
            $status = false;
        }

        return response()->json([
            "status" => $status
        ]);

    }

    public function deleteInvoice($invoiceid)
    {
        $headerDeleted;
        $linesDeleted;

        $linesDeleted = CustInvoiceLine::where('INVOICEID', $invoiceid)->delete();

        $headerDeleted = CustInvoiceHeader::where('INVOICEID', $invoiceid)->delete();

        if ($headerDeleted > 0)
        {
            return redirect(url('salesClose'));
        }
        else
        {
            echo "<script>showError('No se pudo eliminar la factura')</script>";
        }
    }

    public function sendInvoiceByMail($invoiceid)
    {
        mail("lucianof.moral@gmail.com", "Prueba", "Prueba2");
    }

    public function salesReOpen($invoiceid)
    {
        CustInvoiceHeader::where("INVOICEID", $invoiceid)->update(["STATUS" => "0"]);

        return redirect(url('salesAddLines'). "/" . $invoiceid);

    }

}