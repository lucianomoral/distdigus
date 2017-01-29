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

    public function getItemPriceByMargin(Request $request)
    {

        $itemCost = ItemCost::where([
                                        ['ITEMID', '=', $request->itemid]
                                    ])->orderBy('COSTDATE', 'desc')->first();
        
        $itemPrice = $itemCost->COSTPRICE * (1 + ($request->margin / 100));

        return response()->json([
            "price" => $itemPrice
        ]);

    }

}