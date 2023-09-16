<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            // ID da configuração. Chave primária autoincremental.
            $table->id();

            // Coluna para armazenar a conexão de banco de dados atual (e.g., 'BancoA' ou 'BancoB').
            // Pode ser útil para alternar entre diferentes bancos de dados.
            $table->string('database_connection')->nullable()->comment('Nome da conexão de banco de dados atual');

            // Coluna para armazenar timestamps: created_at e updated_at.
            // created_at: A data/hora em que o registro foi criado.
            // updated_at: A data/hora da última atualização do registro.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
