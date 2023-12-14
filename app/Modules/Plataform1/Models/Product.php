<?php

namespace Modules\Plataform1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Plataform1\Database\Factories\ProductFactory;

class Product extends Model
{
    protected $table = 'product';

    use HasFactory;

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
