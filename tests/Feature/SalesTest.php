<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SalesTest extends TestCase
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
    public function it_can_view_sales()
    {
        // Create a customer and a product
        $customer = CustomerModel::factory()->create();
        $product = Product::factory()->create();

        // Create some delivered orders (sales)
        OrderModel::factory()->count(3)->create([
            'customerId' => $customer->id,
            'productId' => $product->id,
            'status' => 'delivered',
        ]);

        // Create some non-delivered orders
        OrderModel::factory()->count(2)->create([
            'customerId' => $customer->id,
            'productId' => $product->id,
            'status' => 'pending',
        ]);

        // Send a GET request to the sales route
        $response = $this->get('/admin/sales');

        // Assert that the response is OK
        $response->assertStatus(200);

        // Assert that only delivered orders are present in the view
        $response->assertViewHas('sales', function ($sales) {
            return $sales->count() === 3 && $sales->every(fn($sale) => $sale->status === 'delivered');
        });
    }
}
