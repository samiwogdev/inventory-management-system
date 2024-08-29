<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoryTest extends TestCase
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
    public function it_shows_the_category_list()
    {
        // Create some categories
        Category::factory()->count(3)->create();

        $response = $this->get('/admin/categoryList');

        $response->assertStatus(200);
        $response->assertViewIs('admin.category.categoryList');
        $response->assertViewHas('categoryList');
    }

    /** @test */
    public function it_shows_the_add_category_page()
    {
        $response = $this->get('/admin/addCategory');

        $response->assertStatus(200);
        $response->assertViewIs('admin.category.addCategory');
    }

    /** @test */
    public function it_can_store_a_new_category()
    {
        $response = $this->post('/admin/addCategory', [
            'name' => 'New Category',
            'description' => 'A description for the new category',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'description' => 'A description for the new category',
        ]);
    }

    /** @test */
    public function it_shows_the_edit_category_page()
    {
        $category = Category::factory()->create();

        $response = $this->get("/admin/editCategory/{$category->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.category.editCategory');
        $response->assertViewHas('category', $category);
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->put("/admin/updateCategory/{$category->id}", [
            'name' => 'Updated Category Name',
            'description' => 'Updated Category Description',
        ]);

        $response->assertRedirect(route('admin.editCategory', ['id' => $category->id]));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category Name',
            'description' => 'Updated Category Description',
        ]);
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete("/admin/deleteCategory/{$category->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
