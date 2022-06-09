<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollPayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_payslips', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_cut_off_id');
            $table->float('total_manhour');
            $table->integer('payroll_salary_addition_id');
            $table->float('total_addition');
            $table->integer('payroll_salary_deduction_id');
            $table->float('total_deduction');
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
        Schema::dropIfExists('payroll_payslips');
    }
}
