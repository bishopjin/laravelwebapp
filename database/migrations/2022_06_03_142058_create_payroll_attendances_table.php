<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_cut_off_id');
            $table->integer('payroll_holiday_id');
            $table->date('attendance_date');
            $table->time('time_in');
            $table->time('time_out_break');
            $table->time('time_in_break');
            $table->time('time_out');
            $table->float('manhour');
            $table->float('overtime');
            $table->float('night_diff');
            $table->float('tardiness');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_attendances');
    }
}
