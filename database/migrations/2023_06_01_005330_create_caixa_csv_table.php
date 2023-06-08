<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caixa_csvs', function (Blueprint $table) {
            $table->id();
            $table->string('num_imovel', 50)->nullable();
            $table->text('endereco');
            $table->string('bairro')->nullable();
            $table->double('valor_venda', 15, 2, true)->nullable();
            $table->double('valor_avaliacao', 15, 2, true)->nullable();
            $table->double('desconto', 5, 2, true)->nullable();
            $table->string('modalidade_venda')->nullable();
            $table->string('md5_row', 32)->nullable();
            $table->timestamp('scrapped_at')->nullable();
            $table->foreignIdFor(\App\Models\FilesCaixaEconomica::class);
            $table->foreignIdFor(\App\Models\CidadesBrasileira::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixa_csvs');
    }
};
