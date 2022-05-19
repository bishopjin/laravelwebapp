<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_number');
            $table->integer('user_id');
            $table->integer('order_burger_id');
            $table->integer('burgers_qty');
            $table->integer('order_beverage_id');
            $table->integer('beverages_qty');
            $table->integer('order_combo_meal_id');
            $table->integer('combo_meals_qty');
            $table->integer('order_coupon_id');
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
        Schema::dropIfExists('order_orders');
    }
}
