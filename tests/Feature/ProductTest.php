<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_requisition_for_all_products(): void
    {
        $user = User::factory()->create();
        $products = Product::factory(10)->create();
    
        $response = $this->actingAs($user)->get('/api/v1/products/');

        $response->assertStatus(200);

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_product_request_by_id(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
    
        $response = $this->actingAs($user)->get('/api/v1/products/' . $product->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'group_id' => $product->group_id,
        ]);
    }

    public function test_create_new_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
    
        $response = $this->actingAs($user)->post('/api/v1/products/', $product->toArray());

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => $product->name,
            'description' => $product->description,
            'group_id' => $product->group_id,
        ]);
    }

    public function test_delete_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
    
        $response = $this->actingAs($user)->delete('/api/v1/products/' . $product->id);

        $response->assertStatus(204);
    }
}
