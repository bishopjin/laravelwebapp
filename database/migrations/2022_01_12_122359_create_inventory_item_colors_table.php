<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
        // Insert some stuff
        DB::table('inventory_item_colors')->insert([
            ['color' => 'RED'],
            ['color' => 'BLUE'],
            ['color' => 'BLACK'],
            ['color' => 'BROWN'],
            ['color' => 'WHITE'],
            ['color' => 'GREEN']
        ]);
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
