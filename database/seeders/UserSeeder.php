<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Desenvolvedor',
                'email' => 'dev@investcubo.com.br',
                'password' => 'cp4rpHm6h8jeMR3Ek',
                'role' => 'developer'
            ],
            [
                'name' => 'Administrador',
                'email' => 'organizador@investcubo.com.br',
                'password' => 'cp46jeMREkrkpHmh',
                'role' => 'administrador'
            ],
            [
                'name' => 'Usuário',
                'email' => 'jogador@investcubo.com.br',
                'password' => 'senhasegura',
                'role' => 'usuario'
            ]
        ];

        foreach ($users as $user) {
            $role = array_pop($user);
            $newUser = User::create($user);
            $newUser->assignRole(Role::where('name', $role)->value('id'));
        }
    }
}
