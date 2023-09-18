<?php

namespace App\Traits;

use App\Models\Configuration;
use Illuminate\Support\Facades\DB;

trait DynamicConnection
{
    // Assim que o trait é usado por uma model, ele define a conexão
    public function initializeDynamicConnection()
    {
        $this->setConnection($this->determineConnection());
    }

    protected function determineConnection()
    {
        // Suponha que sua tabela de configuração seja "configurations" 
        // e você tenha uma coluna chamada "database_connection"
        try {
            $config = (array) DB::table('configurations')->first();
        } catch (\Throwable $th) {
            $config = ['database_connection' => 'pgsqlA'];
        }

        // Se um registro for encontrado e a coluna database_connection estiver definida, retorne o valor.
        if ($config && isset($config['database_connection'])) {
            return $config['database_connection'];
        }

        // Caso contrário, retorne a conexão padrão.
        return config('database.default');
    }
}
