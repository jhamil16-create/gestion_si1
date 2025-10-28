<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gestion_academica', function (Blueprint $table) {
            $table->id('id_gestion'); // id_gestion serial
            $table->string('nombre', 30);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestion_academica');
    }
};