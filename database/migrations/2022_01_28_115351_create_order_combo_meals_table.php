<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrderComboMeal;

class CreateOrderComboMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_combo_meals', function (Blueprint $table) {
            $table->id()->from(30001);
            $table->string('name')->unique();
            $table->float('price');
            $table->softDeletes();
            $table->timestamps();
        });

        OrderComboMeal::upsert(
            [
                ['name' => 'Chicken Combo', 'price' => 105.0],
                ['name' => 'Pork Combo', 'price' => 155.0],
                ['name' => 'Fish Combo', 'price' => 125.0],
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
        Schema::dropIfExists('order_combo_meals');
    }
}
