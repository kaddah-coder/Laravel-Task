<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\ProductSeeder;


class ProductTest extends TestCase
{

    use RefreshDatabase;

    use WithoutMiddleware;


    // protected $user;

    // protected $product;

    // public function setUp(): void
    // {
    //     parent::setUp();

    //     $this->user = User::factory()->create();


    //     $this->actingAs($this->user, 'api');
    // }



    public function test_can_get_all_products()
    {
        $this->seed(ProductSeeder::class);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }


    public function test_can_store_new_product()
    {
        $newProduct = [
            'name' => 'Iphone',
            'descriptin' => 'made in apple',
            'image' => '167562852097.jpg',
        ];

        $response = $this->postJson('/api/products', $newProduct);

        $response->assertStatus(200);
    }


    public function test_can_get_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200);
    }


    public function test_can_update_product_info()
    {

        $product = Product::factory()->create();

        $updateProduct = [
            'name' => 'J7 core',
            'descriptin' => 'made in samsung',
            'image' => '139872852097.jpg',
        ];

        $response = $this->putJson('/api/products/'. $product->id, $updateProduct);

        $response->assertStatus(200);
    }


    public function test_can_delete_product()
    {

        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200);
    }

}
