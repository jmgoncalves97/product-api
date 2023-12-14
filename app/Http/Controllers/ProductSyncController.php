<?php

namespace App\Http\Controllers;

use App\Jobs\Plataform1\ProductSyncJob;
use App\Services\Plataform1\ProductSync;

class ProductSyncController extends Controller
{
    public function __construct(
        private ProductSync $productSync
    ) {
    }

    public function index()
    {
        ProductSyncJob::dispatch($this->productSync)->onQueue('data_sync');

        return response()->json([
            'message' => 'Sincronização de produtos da Plataform1 iniciada',
        ]);
    }
}
