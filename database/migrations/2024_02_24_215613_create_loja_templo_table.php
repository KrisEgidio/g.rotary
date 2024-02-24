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
        Schema::create('loja_templo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loja_id')->constrained('lojas')->onDelete('cascade');
            $table->foreignId('templo_id')->constrained('templos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loja_templo');
    }
};