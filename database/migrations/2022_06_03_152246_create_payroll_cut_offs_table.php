<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PayrollCutOff;

class CreatePayrollCutOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_cut_offs', function (Blueprint $table) {
            $table->id();
            $table->string('cut_off');
            $table->softDeletes();
            $table->timestamps();
        });

        PayrollCutOff::upsert(
            [
                ['cut_off' => '1 to 15'],
                ['cut_off' => '16 to 30'],
            ], ['cut_off'], []
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_cut_offs');
    }
}
