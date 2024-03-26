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
        Schema::create('sale_return_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salereturnID')->constrained('sale_returns', 'id');
            $table->foreignId('productID')->constrained('products', 'id');
            $table->float('qty', 10, 2);
            $table->float('price', 10, 2);
            $table->float('amount', 10, 2);
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('sale_return_details');
    }
};
