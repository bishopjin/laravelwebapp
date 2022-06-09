<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('salary_grade');
            $table->boolean('night_diff_applied');
            $table->boolean('overtime_applied');
            $table->boolean('cola_applied');
            $table->boolean('ecola_applied');
            $table->boolean('meal_allowance_applied');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });

        DB::table('payroll_salary_grades')->insert([
            [
                'salary_grade' => 'Minimum Wage', 
                'night_diff_applied' => 1,
                'overtime_applied' => 1,
                'cola_applied' => 1,
                'ecola_applied' => 1,
                'meal_allowance_applied' => 0
            ],
            [
                'salary_grade' => 'Supervisor', 
                'night_diff_applied' => 1,
                'overtime_applied' => 0,
                'cola_applied' => 0,
                'ecola_applied' => 1,
                'meal_allowance_applied' => 1
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
        Schema::dropIfExists('payroll_salary_grades');
    }
}
