<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePayrollHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('date');
            $table->boolean('is_legal');
            $table->boolean('is_local');
            $table->float('rate');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });

        DB::table('payroll_holidays')->insert([
            [
                'name' => 'Chinese New Year', 
                'date' => '2-1',
                'is_legal' => 0,
                'is_local' => 0,
                'rate' => 0.3
            ],
            [
                'name' => 'New Year\'s Day', 
                'date' => '1-1',
                'is_legal' => 1,
                'is_local' => 0,
                'rate' => 1.0
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_special_holidays');
    }
}
