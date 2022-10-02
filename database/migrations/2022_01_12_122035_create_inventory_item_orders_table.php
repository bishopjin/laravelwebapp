<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_orders', function (Blueprint $table) {
            $table->id()->from(1000000000);
            $table->integer('inventory_item_shoe_id');
            $table->integer('qty');
            $table->integer('user_id');
            $table->integer('prepared_by_id')->nullable();
            $table->integer('released_by_id')->nullable();
            $table->dateTime('prepared_at')->nullable();
            $table->dateTime('released_at')->nullable();
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
        Schema::dropIfExists('inventory_item_orders');
    }
}
