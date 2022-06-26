<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollAttendanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_attendance_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_attendance_id');
            $table->integer('employee_id');
            $table->integer('approver_id');
            $table->time('time_in');
            $table->time('time_out_break');
            $table->time('time_in_break');
            $table->time('time_out');
            $table->text('remarks')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('payroll_attendance_requests');
    }
}
