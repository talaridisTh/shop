<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->name();

        return [
            'name' => $title,
            'slug' => str::slug($title, "-"),
            'email' => $this->faker->unique()->safeemail(),
            'status' => User::STATUS[rand(0, 1)],
            'email_verified_at' => now(),
            'password' => "password", // password
            'remember_token' => str::random(10),
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
                'email_verified_at' => null,
            ];
        });
    }

}
