<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Produto",
 *     description="Objeto produto.",
 *     required={"id", "nome", "preco"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="group_id", type="integer")
 * )
 */
class Product extends Model
{
    protected $table = 'product';
    
    use HasFactory;
}
