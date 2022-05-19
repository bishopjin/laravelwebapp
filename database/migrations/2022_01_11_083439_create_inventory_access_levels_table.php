<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryAccessLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_access_levels', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
        // Insert some stuff
        DB::table('inventory_access_levels')->insert([
            ['user_type' => 'ADMIN'],
            ['user_type' => 'NON-ADMIN'],
            ['user_type' => 'GUEST']
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_access_levels');
    }
}
