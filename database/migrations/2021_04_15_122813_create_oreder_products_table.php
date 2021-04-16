<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrederProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->on('sellers')->references('id');
            $table->unsignedBigInteger('order_id');
            $table->integer('Quantity');
            $table->decimal('price',8,2);
            $table->decimal('total_price',8,2);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oreder_products');
    }
}
