<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => 'admin',
            'password' => '$2y$10$a6a8RxxpTgoIYMeA8Frr9OQsPNMY.3r708jlOHkPKTxrfjA2ncsay', 
            'firstname' => 'John',
            'middlename' => 'Smith',
            'lastname' => 'Wick',
            'email' => 'john@mail.com',
            'gender_id' => 1,
            'online_course_id' => 1,
            'DOB' => date('Y-m-d', strtotime('1990-12-01'))
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                //'email_verified_at' => null,
            ];
        });
    }
}
