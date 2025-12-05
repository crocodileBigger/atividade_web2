<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use app\models\User;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'user_type'  => 'cliente', // padrão
            'birth_date' => fake()->date(),
            'password'   => Hash::make('123456'),
        ];
    }
}
