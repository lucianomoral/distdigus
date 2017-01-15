<?php

namespace App\Http\Controllers;

use App\ItemCost;
use App\ListLine;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {

        return view('price.price');

    }

    public function getItemPriceByListId(Request $request)
    {

        $itemPrice = ListLine::where([
                                        ['LISTID', '=', $request->listid], 
                                        ['ITEMID', '=', $request->itemid]
                                    ])->first();

        return response()->json([
            "price" => $itemPrice->PRICE
        ]);

    }

}