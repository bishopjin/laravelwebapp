<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollSalaryGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_salary_grades', function (Blueprint $table) {
            $table->id();
            $table->string('salary_grade')->unique();
            $table->boolean('night_diff_applied');
            $table->boolean('overtime_applied');
            $table->boolean('cola_applied');
            $table->boolean('ecola_applied');
            $table->boolean('meal_allowance_applied');
            $table->softDeletes();
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
        Schema::dropIfExists('payroll_salary_grades');
    }
}
