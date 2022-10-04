<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrderBeverageSize;

class CreateOrderBeverageSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_beverage_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        OrderBeverageSize::upsert(
            [
                ['size' => 'Medium'],
                ['size' => 'Large'],
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
        Schema::dropIfExists('order_beverage_sizes');
    }
}
