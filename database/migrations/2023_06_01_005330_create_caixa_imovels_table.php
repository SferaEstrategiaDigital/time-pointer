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
        Schema::create('caixa_imovels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CidadesBrasileira::class)->nullable();
            $table->foreignIdFor(\App\Models\PropertyType::class)->nullable();
            $table->foreignIdFor(\App\Models\FilesCaixaEconomica::class);
            $table->string('num_imovel', 50)->nullable();
            $table->string('bairro')->nullable();
            $table->double('valor_venda', 15, 2, true)->nullable();
            $table->double('valor_avaliacao', 15, 2, true)->nullable();
            $table->double('desconto', 5, 2, true)->nullable();
            $table->string('modalidade_venda')->nullable();
            $table->string('insc_imobiliaria')->nullable();
            $table->string('averbacao_leiloes_negativos')->nullable();
            $table->string('num_quartos')->nullable();
            $table->string('md5_row', 32)->nullable();
            $table->timestamps();
            $table->timestamp('scrapped_at')->nullable();
            $table->text('endereco');
            $table->text('detalhes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixa_imovels');
    }
};
