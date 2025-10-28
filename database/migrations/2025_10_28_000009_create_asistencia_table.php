<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id('id_asistencia'); // id_asistencia bigserial
            $table->date('fecha');
            $table->char('estado', 1); // 'P' (Presente), 'F' (Falta), 'L' (Licencia)
            $table->text('observaciones')->nullable();

            // Llave foránea para 'asignacion_horario'
            $table->unsignedBigInteger('id_asignacion');
            $table->foreign('id_asignacion')->references('id_asignacion')->on('asignacion_horario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};