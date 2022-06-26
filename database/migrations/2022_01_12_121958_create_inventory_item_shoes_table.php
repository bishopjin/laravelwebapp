<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemShoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_shoes', function (Blueprint $table) {
            $table->id()->from(1000000);
            $table->integer('inventory_item_brand_id');
            $table->integer('inventory_item_size_id');
            $table->integer('inventory_item_color_id');
            $table->integer('inventory_item_type_id');
            $table->integer('inventory_item_category_id');
            $table->float('price');
            $table->integer('in_stock');
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
        Schema::dropIfExists('inventory_item_shoes');
    }
}
