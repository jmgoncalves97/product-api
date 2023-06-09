<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct()
    {
        $this->M = Stock::class;
    }

    public function store(Request $request)
    {
        try {
            $stock = new Stock;
            $stock->name = $request->input('name');
            $stock->description = $request->input('description');
            $stock->product_id = $request->input('product_id');
            $stock->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json($stock);
    }
}
