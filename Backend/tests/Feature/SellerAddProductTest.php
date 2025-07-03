<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\SellerProfile;

class SellerAddProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_add_product()
    {
        $seller = User::factory()->create(['role' => 'seller']);
        SellerProfile::factory()->create(['user_id' => $seller->id, 'status' => 'approved']);
        $category = Category::factory()->create();

        $response = $this->actingAs($seller)->postJson('/api/products', [
            'title' => 'New Product',
            'description' => 'This is a new product.',
            'price' => 100,
            'stock' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'title' => 'New Product',
            'seller_id' => $seller->id,
        ]);
    }
}
