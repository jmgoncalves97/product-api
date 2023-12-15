<?php

namespace Tests\Feature\Plataform1;

use App\Jobs\Plataform1\ProductSyncJob;
use App\Models\Product;
use App\Services\Plataform1\ProductSync;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Testing\Fakes\PendingBatchFake;
use Modules\Plataform1\Models\Product as Plataform1Product;
use Tests\TestCase;

class ProductSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_dispatching_the_product_sync_job_to_the_queue(): void
    {
        Queue::fake();

        $productSync = new ProductSync();

        $queue = 'data_sync';

        ProductSyncJob::dispatch($productSync)->onQueue($queue);

        Queue::assertPushedOn($queue, ProductSyncJob::class);

        Queue::bulk([
            new ProductSyncJob($productSync),
            new ProductSyncJob($productSync),
        ], '', $queue);

        Queue::assertPushed(ProductSyncJob::class, 3);

        Bus::fake();

        Bus::batch([
            new ProductSyncJob($productSync),
            new ProductSyncJob($productSync),
        ])->onQueue($queue)->dispatch();

        Bus::assertBatched(function (PendingBatchFake $batch) {
            return count($batch->jobs) === 2;
        });
    }

    public function test_product_sync(): void
    {
        $plataform1Url = config('integration.plataform1')['api']['url'];

        $data1 = Plataform1Product::factory()
            ->count(10)
            ->make()
            ->toArray();

        $data2 = Plataform1Product::factory()
            ->count(10)
            ->make()
            ->toArray();

        $json = fn ($page, $nextPage) => [
            'next_page' => $nextPage,
            'data' => match ($page) {
                1 => $data1,
                2 => $data2,
            },
        ];

        Http::fake([
            $plataform1Url.'/v1/products?page=1' => Http::response($json(1, 2)),
            $plataform1Url.'/v1/products?page=2' => Http::response($json(2, null)),
        ]);

        $productSync = new ProductSync();

        $productSync->execute();

        $this->assertDatabaseHas('product', ['id' => $data1[0]['id']]);

        $this->assertDatabaseHas('product', ['id' => $data2[0]['id']]);

        Product::truncate();

        $this->assertDatabaseMissing('product', ['id' => $data1[0]['id']]);
    }
}
