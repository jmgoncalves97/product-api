<?php

namespace App\Http\Controllers;

use App\Services\Plataform1\ProductSync;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Jobs\Plataform1\ProductSyncJob;

class ProductSyncController extends Controller
{
    function __construct(
        private ProductSync $productSync
    ) {}

    public function index()
    {
        ProductSyncJob::dispatch($this->productSync)->onQueue('data_sync');

        return response()->json([
            'message' => 'Sincronização de produtos da Plataform1 iniciada'
        ]);
    }
}
