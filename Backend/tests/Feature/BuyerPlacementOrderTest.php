<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class BuyerPlacementOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_place_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $seller = User::factory()->create(['role' => 'seller']);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['seller_id' => $seller->id, 'category_id' => $category->id, 'stock' => 10]);

        $response = $this->actingAs($buyer)->postJson('/api/checkout', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2]
            ],
            'payment_method' => 'cash_on_delivery',
            'shipping_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_line_1' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'postal_code' => '12345',
                'country' => 'US',
            ],
            'billing_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_line_1' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'postal_code' => '12345',
                'country' => 'US',
            ],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $buyer->id,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8,
        ]);
    }
}
