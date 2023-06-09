<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->M = Product::class;
    }

    public function store(Request $request)
    {
        try {
            $product = new Product;
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->group_id = $request->input('group_id');
            $product->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json($product);
    }
}
