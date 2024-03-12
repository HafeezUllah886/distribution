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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salesID')->constrained('sales', 'id');
            $table->foreignId('productID')->constrained('products', 'id');
            $table->float('qty', 10, 2);
            $table->float('price', 10, 2);
            $table->float('rt_per', 14, 2);
            $table->float('rt_val', 14, 2);
            $table->float('ws_per', 14, 2);
            $table->float('ws_val', 14, 2);
            $table->float('slb_per', 14, 2);
            $table->float('slb_val', 14, 2);
            $table->integer('bonus');
            $table->float('deal_per', 14, 2);
            $table->float('deal_val', 14, 2);
            $table->float('gross', 14, 2);
            $table->float('gst_per', 14, 2);
            $table->float('gst_val', 14, 2);
            $table->float('mrp_per', 14, 2);
            $table->float('mrp_val', 14, 2);
            $table->float('fst_per', 14, 2);
            $table->float('fst_val', 14, 2);
            $table->float('amount', 14, 2);
            $table->float('unit_price', 14, 2);
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
        Schema::dropIfExists('sale_details');
    }
};
