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
            $table->integer('user_id');
            $table->integer('payroll_cut_off_id');
            $table->integer('payroll_holiday_id');
            $table->integer('payroll_work_schedule_id');
            $table->time('time_in');
            $table->time('time_out_break')->nullable();
            $table->time('time_in_break')->nullable();
            $table->time('time_out')->nullable();
            $table->float('manhour')->default(0);
            $table->float('overtime')->default(0);
            $table->float('night_diff')->default(0);
            $table->float('tardiness')->default(0);
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
