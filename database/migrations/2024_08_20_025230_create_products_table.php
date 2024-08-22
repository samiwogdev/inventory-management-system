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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade')->nullable(false)->change();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->nullable(false)->change();
            $table->string('name'); 
            $table->string('sku')->unique(); // stock keeping unit
            $table->decimal('unitPrice', 8, 2); // Product price, decimal with 8 digits total and 2 decimal places
            $table->integer('quantity'); 
            $table->integer('reorderLevel'); 
            $table->text('description'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
