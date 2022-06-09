<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePayrollAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_additions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('rate');
            $table->float('amount');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
        DB::table('payroll_additions')->insert([
            [
                'name' => 'Night Differentials',
                'rate' => 0.1,
                'amount' => 0
            ],
            [
                'name' => 'COLA',
                'rate' => 0,
                'amount' => 50.0
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
        Schema::dropIfExists('payroll_additions');
    }
}
