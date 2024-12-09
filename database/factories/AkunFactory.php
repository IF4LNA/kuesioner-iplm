<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AkunFcatoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password123'),
            'role'     => $this->faker->randomElement(['admin', 'pustakawan']),
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
