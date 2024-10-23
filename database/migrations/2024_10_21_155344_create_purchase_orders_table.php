<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();  // Order number
            $table->date('order_date')->default(DB::raw('CURRENT_DATE'));
            $table->foreignId('supplier_id')->constrained('suppliers');  // Foreign key to supplier
            $table->decimal('item_total', 10, 2)->default(0);  // Sum of line item net amounts
            $table->decimal('discount', 10, 2)->default(0);    // Sum of discounts on items
            $table->decimal('net_amount', 10, 2)->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
