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
            ['name' => 'Developers'],
            ['name' => 'Administrador'],
            ['name' => 'Usuário'],
        ];
        foreach ($roles as $role) {
            $role = Role::firstOrCreate([
                'name' => $role['name']
            ]);
        }
    }
}
