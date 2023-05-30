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
        Schema::create('files_caixa_economicas', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('md5', 32)->nullable();
            $table->foreignIdFor(\App\Models\EstadosBrasileiro::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_caixa_economicas');
    }
};
