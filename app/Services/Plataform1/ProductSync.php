<?php

namespace App\Services\Plataform1;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ProductSync
{
    public function execute()
    {
        $nextPage = 1;
        do {
            $body = $this->request($nextPage);

            $nextPage = $body['next_page'];

            $mappedData = collect($body['data'])->map(fn ($item) => Mapper::map($item))->all();

            $this->upsert($mappedData);
        } while ($nextPage != null);
    }

    /**
     * @return object{'data': array}
     */
    private function request($page = 1)
    {
        $plataform1 = config('integration.plataform1');

        try {
            /**
             * @var \Illuminate\Http\Client\Response
             */
            $response = Http::withHeaders([
                'Authorization' => $plataform1['api']['token'],
            ])->get($plataform1['api']['url'].'/v1/products', [
                'page' => $page,
            ]);

            if ($response->status() != 200) {
                throw new ResponseStatusException($response->body(), $response->status());
            }

            return $response->json();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function upsert($data)
    {
        $chunks = array_chunk($data, 2000);

        /**
         * @var \Illuminate\Database\Eloquent\Builder
         */
        $Product = Product::class;

        foreach ($chunks as $chunk) {
            $Product::upsert(
                $chunk,
                ['id'],
                array_keys(reset($chunk))
            );
        }
    }
}

class Mapper
{
    public static function map($product): array
    {
        return [
            'id' => $product['id'],
            'name' => $product['name'],
            'description' => $product['description'],
            'group_id' => $product['group_id'],
        ];
    }
}

class ResponseStatusException extends \Exception
{
}
