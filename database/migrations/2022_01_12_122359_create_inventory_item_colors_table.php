<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\InventoryItemColor;

class CreateInventoryItemColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->softDeletes();
            $table->timestamps();
        });

        InventoryItemColor::upsert(
            [
                ['color' => 'RED'],
                ['color' => 'BLUE'],
                ['color' => 'BLACK'],
                ['color' => 'BROWN'],
                ['color' => 'WHITE'],
                ['color' => 'GREEN']
            ], ['color'], []
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_item_colors');
    }
}
