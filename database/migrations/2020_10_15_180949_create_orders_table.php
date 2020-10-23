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
            $table->increments('id');
            $table->unsignedBigInteger('order_number');
            $table->unsignedBigInteger('customer_number');
            $table->unsignedBigInteger('product_number');
            $table->foreign('order_number')
                ->references('id')
                ->on('ordered_items');
            $table->foreign('customer_number')
                ->references('id')
                ->on('customers');
            $table->foreign('product_number')
                ->references('id')
                ->on('products`');
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
