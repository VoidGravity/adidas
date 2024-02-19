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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->double("amount"); //la je peut aussi fair decimal comme ca : decimal('amount', 8, 2) with 8 beign before decimal and 2 after decimal
            $table->string("status");
            $table->text("notes")->nullable();
            $table->text("shipping_address")->nullable();
            $table->text("billing_address")->nullable();
            $table->string("payment_method");
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
