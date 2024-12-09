<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        // return [
        //     'username' => $this->faker->unique()->userName(),
        //     'password' => Hash::make('password123'), // Ganti dengan password yang sesuai
        //     'role' => $this->faker->randomElement(['admin', 'pustakawan']),
        // ];
    }
}


