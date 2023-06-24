<?php

use App\Models\CidadesBrasileira;
use App\Models\EstadosBrasileiro;
use App\Models\PropertyType;
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
        Schema::create('imovels', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->text("num_imovel");
            $table->foreignIdFor(CidadesBrasileira::class);
            $table->text('cidade');
            $table->foreignIdFor(EstadosBrasileiro::class);
            $table->text('estado');
            $table->string('cep');
            $table->string('bairro');
            $table->foreignIdFor(PropertyType::class);
            $table->string('tipo_imovel');
            $table->boolean('situacao')->nullable();
            $table->double('valor_venda', 15, 2, true)->nullable();
            $table->double('valor_avaliacao', 15, 2, true)->nullable();
            $table->double('desconto', 5, 2, true)->nullable();
            $table->boolean('financimento')->default(false);
            $table->boolean('consorcio')->default(false);
            $table->boolean('parcelamento')->default(false);
            $table->boolean('fgts')->default(false);
            $table->nullableMorphs("imovel");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imovels');
    }
};
