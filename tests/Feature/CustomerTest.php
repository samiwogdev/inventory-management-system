<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerTest extends TestCase
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
    public function it_shows_the_customer_list()
    {
        // Create some customers
        CustomerModel::factory()->count(3)->create();

        $response = $this->get('/admin/viewCustomer');

        $response->assertStatus(200);
        $response->assertViewIs('admin.customers.viewCustomer');
        $response->assertViewHas('Customers');
    }

    /** @test */
    public function it_shows_the_add_customer_page()
    {
        $response = $this->get('/admin/addCustomer');

        $response->assertStatus(200);
        $response->assertViewIs('admin.customers.addCustomer');
    }

    /** @test */
    public function it_can_store_a_new_customer()
    {
        $response = $this->post('/admin/saveCustomer', [
            'name' => 'New Customer',
            'address' => '123 Main St',
            'email' => 'customer@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'name' => 'New Customer',
            'address' => '123 Main St',
            'email' => 'customer@example.com',
        ]);
    }

    /** @test */
    public function it_shows_the_edit_customer_page()
    {
        $customer = CustomerModel::factory()->create();
        $response = $this->get("/admin/editCustomer/{$customer->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.customers.editCustomer');
        $response->assertViewHas('customer', $customer);
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $customer = CustomerModel::factory()->create();

        $response = $this->put("/admin/editCustomer/{$customer->id}", [
            'name' => 'Updated Customer Name',
            'address' => '456 Another St',
            'email' => 'updated_customer@example.com',
        ]);

        $response->assertRedirect(route('admin.editCustomer', ['id' => $customer->id]));
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Customer Name',
            'address' => '456 Another St',
            'email' => 'updated_customer@example.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        $customer = CustomerModel::factory()->create();

        $response = $this->delete("/admin/deleteCustomer/{$customer->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }
}
