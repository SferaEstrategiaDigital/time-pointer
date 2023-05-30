<?php

namespace Database\Seeders;

use App\Models\EstadosBrasileiro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosBrasileirosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = file_get_contents(database_path('seeders/data/EstadosBrasileiros.json'));
        foreach (json_decode($data) as $info) {
            EstadosBrasileiro::create([
                'uf' => $info->uf,
                'name' => $info->nome,
                'region' => $info->regiao,
            ]);
        }
    }
}
