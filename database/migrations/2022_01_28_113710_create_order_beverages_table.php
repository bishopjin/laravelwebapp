<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderBeveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_beverages', function (Blueprint $table) {
            $table->id()->from(20001);
            $table->integer('order_beverage_name_id');
            $table->integer('order_beverage_size_id');
            $table->float('price');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });

        DB::table('order_beverages')->insert([
            ['order_beverage_name_id' => 1, 'order_beverage_size_id' => 1, 'price' => 30.0],
            ['order_beverage_name_id' => 1, 'order_beverage_size_id' => 2, 'price' => 45.0],
            ['order_beverage_name_id' => 2, 'order_beverage_size_id' => 1, 'price' => 30.0],
            ['order_beverage_name_id' => 2, 'order_beverage_size_id' => 2, 'price' => 45.0],
            ['order_beverage_name_id' => 3, 'order_beverage_size_id' => 1, 'price' => 50.0],
            ['order_beverage_name_id' => 3, 'order_beverage_size_id' => 2, 'price' => 65.0],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_beverages');
    }
}
