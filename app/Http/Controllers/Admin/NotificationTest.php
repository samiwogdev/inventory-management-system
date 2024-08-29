<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a sample admin user
        $this->admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
        ]);

        // Authenticate as admin
        $this->actingAs($this->admin, 'admin');
    }

    /** @test */
    public function it_can_clear_unread_notifications()
    {
        // Create some unread notifications
        Notification::factory()->count(3)->create(['read' => false]);
        Notification::factory()->count(2)->create(['read' => true]);

        // Send a PUT request to clear unread notifications
        $response = $this->put('/admin/notifications');

        // Assert the response redirects back
        $response->assertRedirect();

        // Assert all notifications are now marked as read
        $this->assertDatabaseCount('notifications', 5);
        $this->assertDatabaseMissing('notifications', ['read' => false]);
    }
}
