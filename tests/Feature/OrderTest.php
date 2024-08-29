<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AdminOrderTest extends TestCase
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

        // Create at least one product to avoid null errors
        Product::factory()->create();

        // Authenticate the admin
        $this->actingAs($this->admin, 'admin');
    }

/** @test */
public function it_shows_the_order_list()
{
    // Create 3 orders with a status other than 'delivered'
    $orders = OrderModel::factory()->count(3)->state(['status' => 'pending'])->create();

    $response = $this->get('/admin/orders');

    $response->assertStatus(200);
    $response->assertViewIs('admin.orders.viewOrders');

    // Debug: Log the orders in the view to verify how many are retrieved
    Log::info('Orders in view:', $response->viewData('orders')->toArray());

    // Ensure the view has the correct number of orders
    $this->assertCount(3, $response->viewData('orders'));
}



    /** @test */
    public function it_shows_the_add_order_page()
    {
        $response = $this->get('/admin/addOrder');

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.createOrder');
    }

    /** @test */
    public function it_can_create_a_new_order()
    {
        $customer = CustomerModel::factory()->create();
        $product = Product::factory()->create(['quantity' => 100]);

        $response = $this->post('/admin/addOrder', [
            'customerId' => $customer->id,
            'productId' => $product->id,
            'quantity' => 5,
            'description' => 'Test order',
            'orderDate' => now()->toDateString(),
            'total' => $product->price * 5, // Assuming product has a price field
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'customerId' => $customer->id,
            'productId' => $product->id,
            'quantity' => 5,
            'description' => 'Test order',
        ]);
    }

    /** @test */
    public function it_shows_the_edit_order_page()
    {
        $order = OrderModel::factory()->create();

        $response = $this->get("/admin/editOrder/{$order->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.editOrder');
        $response->assertViewHas('order', $order);
    }

    /** @test */
    public function it_can_update_an_order()
    {
        $order = OrderModel::factory()->create();
        $newCustomer = CustomerModel::factory()->create();
        $newProduct = Product::factory()->create(['quantity' => 100]);

        $response = $this->put("/admin/updateOrder/{$order->id}", [
            'customerId' => $newCustomer->id,
            'productId' => $newProduct->id,
            'quantity' => 10,
            'description' => 'Updated order description',
            'orderDate' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('admin.editOrder', ['id' => $order->id]));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customerId' => $newCustomer->id,
            'productId' => $newProduct->id,
            'quantity' => 10,
            'description' => 'Updated order description',
        ]);
    }

/** @test */
public function it_can_update_order_status()
{
    // Create an admin with status 2
    $admin = Admin::factory()->create(['status' => 2]);
    $this->actingAs($admin, 'admin');

    // Create an order with a pending status
    $order = OrderModel::factory()->create(['status' => 'pending']);

    // Update the order status to 'delivered'
    $response = $this->put("/admin/updateStatus/{$order->id}", [
        'status' => 'delivered', 
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'delivered', 
    ]);
}



    /** @test */
    public function it_can_delete_an_order()
    {
        $order = OrderModel::factory()->create();

        $response = $this->delete("/admin/deleteOrder/{$order->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }
}
