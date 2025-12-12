<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'user_type'  => 'admin',
            'birth_date' => '2000-01-01',
            'password'   => Hash::make('123456'),
        ]);
        User::create([
            'name'       => 'Bibliotecário',
            'email'      => 'bibliotecario@gmail.com',
            'user_type'  => 'bibliotecario',
            'birth_date' => '2001-01-01',
            'password'   => Hash::make('123456'),
        ]);
        User::create([
            'name'       => 'Cliente',
            'email'      => 'cliente@gmail.com',
            'user_type'  => 'cliente',
            'birth_date' => '2002-01-01',
            'password'   => Hash::make('123456'),
        ]);
    }
}
