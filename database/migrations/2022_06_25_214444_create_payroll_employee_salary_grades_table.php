<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollEmployeeSalaryGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_employee_salary_grades', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_employee_id');
            $table->integer('payroll_salary_grade_id');
            $table->integer('payroll_employee_salary_gradeable_id');
            $table->string('payroll_employee_salary_gradeable_type');
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
        Schema::dropIfExists('payroll_employee_salary_grades');
    }
}
