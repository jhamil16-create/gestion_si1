<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupo', function (Blueprint $table) {
            $table->id('id_grupo'); // id_grupo serial
            $table->string('nombre', 30);
            $table->smallInteger('capacidad');

            // llave foránea para docente
            $table->unsignedBigInteger('id_docente');
            $table->foreign('id_docente')->references('id_docente')->on('docente');

            // llave foránea para materia
            $table->string('sigla', 10);
            $table->foreign('sigla')->references('sigla')->on('materia');

            // llave foránea para gestion_academica
            $table->unsignedBigInteger('id_gestion');
            $table->foreign('id_gestion')->references('id_gestion')->on('gestion_academica');
            
            // $table->timestamps(); sin timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aula');
    }
};