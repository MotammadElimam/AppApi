<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('user_id');
          $table->text('address');
          $table->string('status')->default('ACCCEPTED');
          $table->decimal('total_price',8,2)->nullable();
          $table->String('payment_type');
          $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
