<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable CSRF protection for tests
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Run migrations
        $this->artisan('migrate');

        // Create a sample admin user
        $this->admin = Admin::create([
            'name' => 'Ade Babs',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin'),
            'type' => 'superadmin',
            'status' => '1',
        ]);
    }

    /** @test */
    public function it_displays_the_login_page()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertViewIs('admin.login');
    }

    /** @test */
    public function it_allows_admin_to_login()
    {
        $response = $this->post('/admin/login', [
            'email' => 'superadmin@gmail.com',
            'password' => 'superadmin',
        ]);

        $response->assertRedirect('/admin/dashboard');

        // Ensure authentication with the correct guard
        $this->assertAuthenticatedAs($this->admin, 'admin');
    }
}
