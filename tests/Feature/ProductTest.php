<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable CSRF protection for tests
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Run migrations
        $this->artisan('migrate');

        // Create a sample admin user
        $this->admin = Admin::create([
            'name' => 'Jon Super',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin'),
            'type' => 'superadmin',
            'status' => '1',
        ]);

        // Authenticate the admin
        $this->actingAs($this->admin, 'admin');
    }

    /** @test */
    public function it_shows_the_product_list()
    {
        // Create some products
        Product::factory()->count(3)->create();

        $response = $this->get('/admin/productList');

        $response->assertStatus(200);
        $response->assertViewIs('admin.product.productList');
        $response->assertViewHas('productList');
    }

    /** @test */
    public function it_shows_the_add_product_page()
    {
        // Create some categories and suppliers
        Category::factory()->count(3)->create();
        Supplier::factory()->count(3)->create();

        $response = $this->get('/admin/addProduct');

        $response->assertStatus(200);
        $response->assertViewIs('admin.product.addProduct');
        $response->assertViewHas('categories');
        $response->assertViewHas('suppliers');
    }

    /** @test */
    public function it_can_store_a_new_product()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->post('/admin/addProduct', [
            'supplier_id' => $supplier->id,
            'category_id' => $category->id,
            'name' => 'New Product',
            'sku' => 'SKU001',
            'unitPrice' => 100.00,
            'quantity' => 50,
            'reorderLevel' => 10,
            'description' => 'This is a description of the product.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'sku' => 'SKU001',
            'unitPrice' => 100.00,
            'quantity' => 50,
            'reorderLevel' => 10,
            'description' => 'This is a description of the product.',
        ]);
    }

    /** @test */
    public function it_shows_the_edit_product_page()
    {
        $product = Product::factory()->create();
        $response = $this->get("/admin/editProduct/{$product->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.product.editProduct');
        $response->assertViewHas('product', $product);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->put("/admin/updateProduct/{$product->id}", [
            'supplier_id' => $product->supplier_id,
            'category_id' => $product->category_id,
            'name' => 'Updated Product Name',
            'sku' => 'SKU002',
            'unitPrice' => 150.00,
            'quantity' => 60,
            'reorderLevel' => 15,
            'description' => 'Updated description of the product.',
        ]);

        $response->assertRedirect(route('admin.editProduct', ['id' => $product->id]));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'sku' => 'SKU002',
            'unitPrice' => 150.00,
            'quantity' => 60,
            'reorderLevel' => 15,
            'description' => 'Updated description of the product.',
        ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/admin/deleteProduct/{$product->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
