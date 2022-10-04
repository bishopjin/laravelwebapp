<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrderBeverage;

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
            $table->softDeletes();
            $table->timestamps();
        });

        OrderBeverage::upsert(
            [
                ['order_beverage_name_id' => 1, 'order_beverage_size_id' => 1, 'price' => 30.0],
                ['order_beverage_name_id' => 1, 'order_beverage_size_id' => 2, 'price' => 45.0],
                ['order_beverage_name_id' => 2, 'order_beverage_size_id' => 1, 'price' => 30.0],
                ['order_beverage_name_id' => 2, 'order_beverage_size_id' => 2, 'price' => 45.0],
                ['order_beverage_name_id' => 3, 'order_beverage_size_id' => 1, 'price' => 50.0],
                ['order_beverage_name_id' => 3, 'order_beverage_size_id' => 2, 'price' => 65.0],
            ], [], []
        );
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
