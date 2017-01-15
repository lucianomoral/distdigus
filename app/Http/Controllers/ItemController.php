<?php

namespace App\Http\Controllers;

use App\Item;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){

        return view('item.item');

    }

    public function getProductNameById(Request $request){

        $itemname = Item::where('ITEMID', $request->itemid)->first();

        return response()->json([
            "item" => $itemname
        ]);

    }

    public function getProductNamesByName(Request $request){

        $itemname = Item::where('ITEMNAME', 'like', '%' . $request->itemname . '%')->select('ITEMID','ITEMNAME')->get();

            return response()->json([

                "itemname" => $itemname

            ]);


    }

}