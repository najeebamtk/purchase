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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('inventory_location');
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // supplier dropdown
            $table->string('stock_unit');
            $table->decimal('unit_price', 8, 2);
            $table->json('item_images')->nullable(); 
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
