<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained('admins')->onDelete('cascade'); // Assuming notifications are per user
            // $table->string('type'); // To store the type of notification (e.g., 'restock')
            // $table->string('produt_id')->constrained('products')->onDelete('cascade');
            $table->text('data'); // To store the notification message as JSON
            $table->boolean('read')->default(false); // To track if the notification has been read
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
