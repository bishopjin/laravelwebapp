<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\InventoryItemType;

class CreateInventoryItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->softDeletes(); 
            $table->timestamps();
        });

        InventoryItemType::upsert(
            [
                ['type' => 'RUBBER'],
                ['type' => 'LEATHER']
            ], ['type'], []            
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_item_types');
    }
}
