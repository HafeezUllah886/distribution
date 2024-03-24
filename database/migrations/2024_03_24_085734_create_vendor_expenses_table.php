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
        Schema::create('vendor_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accountID')->constrained('accounts', 'id');
            $table->foreignId('vendorID')->constrained('accounts', 'id');
            $table->date('date');
            $table->float('amount', 10, 2);
            $table->text('notes');
            $table->integer('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_expenses');
    }
};
