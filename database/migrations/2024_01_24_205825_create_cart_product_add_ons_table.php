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
        Schema::create('cart_product_add_ons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cart_item_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('parent_add_on_id')->nullable();
            $table->unsignedInteger('child_add_on_id')->nullable();
            $table->unsignedInteger('add_on_value_id');
            $table->float('add_value_price',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product_add_ons');
    }
};
