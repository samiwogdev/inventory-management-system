<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\OrderModel;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReportTest extends TestCase
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
    public function it_displays_generate_report_form()
    {
        // Send a GET request to the showGenerateReport route
        $response = $this->get('/admin/generateReport');

        // Assert that the response is OK and the view is correct
        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.generateReport');
    }

    /** @test */
    public function it_generates_a_report_based_on_date_range()
    {
        // Create sample products and orders
        $product = Product::factory()->create(['name' => 'Product A']);
        OrderModel::factory()->create([
            'productId' => $product->id,
            'quantity' => 5,
            'total' => 100,
            'status' => 'delivered',
            'orderDate' => '2023-08-01',
        ]);

        OrderModel::factory()->create([
            'productId' => $product->id,
            'quantity' => 3,
            'total' => 60,
            'status' => 'delivered',
            'orderDate' => '2023-08-10',
        ]);

        // Send a GET request to generate the report within a specific date range
        $response = $this->get('/admin/reports?start_date=2023-08-01&end_date=2023-08-15');

        // Assert that the response is OK
        $response->assertStatus(200);

        // Assert that the view has the report data
        $response->assertViewHas('reportData', function ($reportData) {
            return $reportData->first()->total_quantity == 8 &&
                $reportData->first()->total_revenue == 160;
        });


        // Assert the overall totals
        $response->assertViewHas('startDate', '2023-08-01');
        $response->assertViewHas('endDate', '2023-08-15');
    }

/** @test */
public function it_exports_report_to_csv()
{
    // Create sample products and orders
    $product = Product::factory()->create(['name' => 'Product A']);
    OrderModel::factory()->create([
        'productId' => $product->id,
        'quantity' => 5,
        'total' => 100,
        'status' => 'delivered',
        'orderDate' => '2023-08-01',
    ]);

    // Send a GET request to export the report to CSV
    $response = $this->get('/admin/ReportToCsv?start_date=2023-08-01&end_date=2023-08-15');

    // Assert that the response is OK and the correct file is returned
    $response->assertStatus(200);

    // Use regex to account for optional quotes around filename
    $response->assertHeader('Content-Disposition', 'attachment; filename=orders_report_' . date('Ymd_His') . '.csv');

}


}
