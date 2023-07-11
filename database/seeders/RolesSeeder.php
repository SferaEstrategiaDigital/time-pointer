<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['title' => 'Developer', 'homepage' => 'AdminDashboard'],
            ['title' => 'Administrador', 'homepage' => 'AdminDashboard'],
            ['title' => 'Usuário'],
        ];
        foreach ($roles as $role) {
            $role = Role::firstOrCreate($role);
        }
    }
}
