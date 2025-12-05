<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use app\models\User;

class AdminUserSeederFactory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'       => 'Administrador do Sistema',
            'email'      => 'admin@gmail.com',
            'user_type'  => 'admin',  // <--- Aqui define que é admin
            'birth_date' => '2000-01-01', // opcional
            'password'   => Hash::make('123456'), // senha fixa
        ]);
    }
}
