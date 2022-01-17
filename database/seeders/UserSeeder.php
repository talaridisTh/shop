<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {

    public function run()
    {
        User::create([
            'name' => "Admin",
            'slug' => "admin",
            'email' => "admin@gmail.com",
            'status' => User::STATUS[1],
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
        ])->assignRole("admin");
        User::factory()->count(10)->create();
    }

}
