<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrderBurger;

class CreateOrderBurgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_burgers', function (Blueprint $table) {
            $table->id()->from(10001);
            $table->string('name')->unique();
            $table->float('price');
            $table->softDeletes();
            $table->timestamps();
        });

        OrderBurger::upsert(
            [
                ['name' => 'Hotdog', 'price' => 50.0],
                ['name' => 'Cheese Burger', 'price' => 60.0],
                ['name' => 'Fries', 'price' => 35.0],
            ], ['name'], ['price']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_burgers');
    }
}
