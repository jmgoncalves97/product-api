<?php

namespace App\Modules\Plataform1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Plataform1\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?? 1;

        $perPageDefault = pow(10, 4); // 10k

        $perPage = $request->per_page ?? $perPageDefault;

        $total = pow(10, 5); // 100k

        $pages = $total / $perPage;

        $data = Product::factory()
            ->count($perPage)
            ->make();

        $json = (object) [
            'next_page' => $page < $pages ? ++$page : null,
            'data' => $data,
        ];

        return response()->json($json);
    }
}
