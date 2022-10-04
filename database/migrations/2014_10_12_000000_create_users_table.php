<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->integer('gender_id');
            $table->integer('online_course_id');
            $table->date('DOB');
            $table->string('remember_token');
            $table->softDeletes(); 
            $table->timestamps();
        });

        User::create([
            'username' => 'admin',
            'firstname' => 'John',
            'middlename' => 'Smith',
            'lastname' => 'Wick',
            'email' => 'john@mail.com',
            'password' => '$2y$10$a6a8RxxpTgoIYMeA8Frr9OQsPNMY.3r708jlOHkPKTxrfjA2ncsay', 
            'gender_id' => 1,
            'online_course_id' => 1,
            'DOB' => date('Y-m-d', strtotime('1990-12-01')),
            'created_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
