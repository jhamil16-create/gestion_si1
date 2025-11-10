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
        Schema::table('gestion_academica', function (Blueprint $table) {
            // Le decimos que AÑADE la columna 'estado'
            // por defecto será 'borrador' y aparecerá después de 'fecha_fin'
            $table->string('estado', 20)->default('borrador')->after('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestion_academica', function (Blueprint $table) {
            // Le decimos cómo REVERTIR el cambio (borrando la columna)
            $table->dropColumn('estado');
        });
    }
};