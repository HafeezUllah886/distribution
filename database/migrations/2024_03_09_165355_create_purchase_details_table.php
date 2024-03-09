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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchaseID')->constrained('purchases', 'id');
            $table->foreignId('productID')->constrained('products', 'id');
            $table->float('qty', 10, 2);
            $table->float('price', 10, 2);
            $table->float('value', 14, 2);
            $table->float('discount_per', 14, 2);
            $table->float('discount_val', 14, 2);
            $table->float('gst_per', 14, 2);
            $table->float('gst_val', 14, 2);
            $table->float('fst_per', 14, 2);
            $table->float('fst_val', 14, 2);
            $table->float('amount', 14, 2);
            $table->date('date');
            $table->integer('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
