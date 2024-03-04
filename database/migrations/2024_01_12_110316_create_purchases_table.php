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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('desc');
            $table->string('brand');
            $table->string('model');
            $table->string('color');
            $table->string('hp');
            $table->string('reg_no');
            $table->string('chassis_no');
            $table->string('eng_no');
            $table->string('seller');
            $table->string('seller_father')->nullable();
            $table->string('seller_cnic');
            $table->string('seller_contact');
            $table->string('seller_address');
            $table->string('broker');
            $table->string('broker_cnic');
            $table->string('broker_contact');
            $table->string('broker_address');
            $table->float('price', 14);
            $table->text('partner')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
