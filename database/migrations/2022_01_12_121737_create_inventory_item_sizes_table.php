<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\InventoryItemSize;

class CreateInventoryItemSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_sizes', function (Blueprint $table) {
            $table->id();
            $table->float('size');
            $table->softDeletes();
            $table->timestamps();
        });

        InventoryItemSize::upsert(
            [
                ['size' => 4.0],
                ['size' => 4.5],
                ['size' => 5.0],
                ['size' => 5.5],
                ['size' => 6.0],
                ['size' => 6.5],
                ['size' => 7.0],
                ['size' => 7.5],
                ['size' => 8.0],
                ['size' => 8.5],
                ['size' => 9.0],
                ['size' => 10.0],
                ['size' => 10.5],
                ['size' => 11.0],
                ['size' => 11.5],
                ['size' => 12.0]
            ], ['size'], []
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_item_sizes');
    }
}
