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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerId');
            $table->unsignedBigInteger('productId');
            $table->integer('quantity');
            $table->decimal('total', 10, 2);
            $table->text('description');
            $table->enum('status', ['pending', 'approved', 'delivered'])->default('pending');
            $table->date('orderDate');
            $table->timestamps();
        
            $table->foreign('customerId')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
        
            $table->foreign('productId')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
