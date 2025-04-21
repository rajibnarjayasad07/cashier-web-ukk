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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->integer('total_price');
            $table->integer('total_payment');
            $table->integer('total_return');
            $table->foreignId('customers_id')->constrained()->onDelete('cascade');
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->integer('loyalty_points');
            $table->integer('total_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
