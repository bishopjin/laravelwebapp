<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PayrollAddition;

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
            $table->softDeletes();
            $table->timestamps();
        });

        PayrollAddition::upsert(
            [
                ['name' => 'Night Differentials', 'rate' => 0.1, 'amount' => 0],
                ['name' => 'COLA', 'rate' => 0, 'amount' => 50.0],
            ], ['name'], ['rate', 'amount']
        );
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
