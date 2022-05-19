<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });

        DB::table('order_burgers')->insert([
            ['name' => 'Hotdog', 'price' => 50.0],
            ['name' => 'Cheese Burger', 'price' => 60.0],
            ['name' => 'Fries', 'price' => 35.0],
        ]);
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
