<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // El nombre de la tabla es 'grupo' según tu archivo
        Schema::create('grupo', function (Blueprint $table) {
            
            // 1. ID como VARCHAR (ej. 'FIS100-SA') y llave primaria
            $table->string('id_grupo', 100);
            $table->primary('id_grupo');

            // 2. Nombre del grupo (ej. 'SA')
            $table->string('nombre', 30);

            // 3. Llave foránea para materia
            // (Asegúrate que la PK en 'materia' sea 'sigla')
            $table->string('sigla', 10);
            $table->foreign('sigla')->references('sigla')->on('materia');

            // 4. Llave foránea para gestion_academica
            $table->unsignedBigInteger('id_gestion');
            $table->foreign('id_gestion')->references('id_gestion')->on('gestion_academica');
        });
    }

    public function down(): void
    {
        // Ajusta esto para que sea 'grupo'
        Schema::dropIfExists('grupo');
    }
};