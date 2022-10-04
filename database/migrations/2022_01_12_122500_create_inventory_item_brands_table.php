<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\InventoryItemBrand;

class CreateInventoryItemBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->softDeletes();
            $table->timestamps();
        });

        InventoryItemBrand::upsert(
            [
                ['brand' => 'VANS'],
                ['brand' => 'WBROWN'],
                ['brand' => 'FILA'],
                ['brand' => 'NIKE']
            ], ['brand'], []
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_item_brands');
    }
}
