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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
//            $table->unsignedInteger('product_id');
//            $table->unsignedInteger('outlet_id');
//            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');
            $table->integer('quantity')->nullable();
            $table->float('price')->nullable();
            $table->date('order_date');
            $table->string('payment_status')->nullable();
            $table->string('payment_object')->nullable();
//            $table->foreign('product_id')->references('id')->on('products');
//            $table->foreign('outlet_id')->references('id')->on('outlets');
//            $table->foreign('category_id')->references('id')->on('categories');
//            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
