<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_horario', function (Blueprint $table) {
            $table->id('id_asignacion'); // id_asignacion bigserial
            $table->string('dia', 10);
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Llave foránea para 'aula'
            $table->unsignedBigInteger('id_aula');
            $table->foreign('id_aula')->references('id_aula')->on('aula');

            // Llave foránea para 'grupo'
            $table->unsignedBigInteger('id_grupo');
            $table->foreign('id_grupo')->references('id_grupo')->on('grupo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_horario');
    }
};