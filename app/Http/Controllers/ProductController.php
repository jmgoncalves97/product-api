<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/v1/products",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de produtos",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product")
 *         ),
 *     ),
 * )
 * 
 * @OA\Get(
 *     path="/api/v1/products/{id}",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="Obtem um produto pelo ID",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado"
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/api/v1/products",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Novo produto",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Produto criado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Mensagem relacionada ao problema"
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/api/v1/products/{id}",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=204,
 *         description="Produto deletado com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado"
 *     )
 * )
 */
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
        return response()->json($product, 201);
    }
}
