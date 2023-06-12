<?php

use App\Models\CaixaImovel;
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
        Schema::create('caixa_imovels_caixa_imovels_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CaixaImovel::class);
            $table->foreignIdFor(\App\Models\CaixaImovelsItem::class);
            $table->text('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixa_imovels_caixa_imovels_items');
    }
};
