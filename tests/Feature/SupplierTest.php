<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SupplierTest extends TestCase
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
    public function it_shows_the_supplier_list()
    {
        // Create some suppliers
        Supplier::factory()->count(3)->create();

        $response = $this->get('/admin/supplierList');

        $response->assertStatus(200);
        $response->assertViewIs('admin.supplier.supplierList');
        $response->assertViewHas('supplierList');
    }

    /** @test */
    public function it_shows_the_add_supplier_page()
    {
        $response = $this->get('/admin/addSupplier');

        $response->assertStatus(200);
        $response->assertViewIs('admin.supplier.addSupplier');
    }

    /** @test */
    public function it_can_store_a_new_supplier()
    {
        $response = $this->post('/admin/addSupplier', [
            'name' => 'New Supplier',
            'phone' => '+1234567890',
            'email' => 'supplier@example.com',
            'address' => '123 Supplier Street',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('suppliers', [
            'name' => 'New Supplier',
            'phone' => '+1234567890',
            'email' => 'supplier@example.com',
            'address' => '123 Supplier Street',
        ]);
    }

    /** @test */
    public function it_shows_the_edit_supplier_page()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->get("/admin/editSupplier/{$supplier->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.supplier.editSupplier');
        $response->assertViewHas('supplier', $supplier);
    }

    /** @test */
    public function it_can_update_a_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->put("/admin/updateSupplier/{$supplier->id}", [
            'name' => 'Updated Supplier Name',
            'phone' => '+0987654321',
            'email' => 'updatedsupplier@example.com',
            'address' => '456 Updated Street',
        ]);

        $response->assertRedirect(route('admin.editSupplier', ['id' => $supplier->id]));
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => 'Updated Supplier Name',
            'phone' => '+0987654321',
            'email' => 'updatedsupplier@example.com',
            'address' => '456 Updated Street',
        ]);
    }

    /** @test */
    public function it_can_delete_a_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->delete("/admin/deleteSupplier/{$supplier->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id,
        ]);
    }
}
