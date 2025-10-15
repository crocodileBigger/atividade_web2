<?php

namespace Database\Factories;

use app\models\publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    protected $model = Publisher::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company, // Gera um nome de empresa único
            'address' => $this->faker->address,
        ];
    }
}
