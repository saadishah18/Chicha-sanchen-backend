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
        Schema::create('cart_add_on_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('cart_item_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('add_on_id');
            $table->string('value_name'); // Ensure this column is defined as string
            $table->unsignedBigInteger('value_id');
            $table->decimal('value_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_add_on_values');
    }
};
