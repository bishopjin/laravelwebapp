<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePayrollDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('rate');
            $table->float('amount');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });

        DB::table('payroll_deductions')->insert([
            [
                'name' => 'SSS',
                'rate' => 0,
                'amount' => 300 
            ],
            [
                'name' => 'PhilHealth',
                'rate' => 0,
                'amount' => 200
            ],
            [
                'name' => 'Absences',
                'rate' => 1.0,
                'amount' => 0
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
        Schema::dropIfExists('payroll_deductions');
    }
}
