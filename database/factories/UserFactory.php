<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'user_type' => $this->faker->randomElement(['admin', 'bibliotecario', 'cliente']),
            'birth_date' => $this->faker->date('Y-m-d', '2008-01-01'),
            'password' => Hash::make('12345678') // senha padrão
        ];
    }
}
