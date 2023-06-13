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
        Schema::create('nivel_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->text('description');
            $table->decimal('price', 8,2);
            $table->foreignIdFor(\App\Models\Role::class)->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nivel_pagamentos');
    }
};
