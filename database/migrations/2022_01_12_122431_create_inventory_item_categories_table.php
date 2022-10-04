<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\InventoryItemCategory;

class CreateInventoryItemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->softDeletes();
            $table->timestamps();
        });

        InventoryItemCategory::upsert(
            [
                ['category' => 'MALE'],
                ['category' => 'FEMALE'],
                ['category' => 'UNISEX']
            ], ['category'], []
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_item_categorys');
    }
}
