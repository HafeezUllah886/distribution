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
        Schema::create('deposit_withdraws', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('accountID')->constrained('accounts', 'id');
            $table->string('type');
            $table->float('amount', 14);
            $table->text('notes')->nullable();
            $table->integer('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_withdraws');
    }
};
