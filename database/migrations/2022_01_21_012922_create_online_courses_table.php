<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OnlineCourse;

class CreateOnlineCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_courses', function (Blueprint $table) {
            $table->id();
            $table->string('course');
            $table->softDeletes();
            $table->timestamps();
        });

        OnlineCourse::create([
            'course' => 'N/A'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_courses');
    }
}
