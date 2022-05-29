<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_examinations', function (Blueprint $table) {
            $table->id();
            $table->integer('online_exam_id');
            $table->integer('user_id');
            $table->integer('faculty_id');
            $table->integer('total_question');
            $table->integer('exam_score')->nullable();
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
        Schema::dropIfExists('online_examinations');
    }
}
