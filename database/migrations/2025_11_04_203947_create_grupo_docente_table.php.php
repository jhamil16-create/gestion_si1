<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Esta es tu "clase intermedia"
        Schema::create('docente_grupo', function (Blueprint $table) {
            
            // Llave foránea para docente
            $table->unsignedBigInteger('id_docente');
            $table->foreign('id_docente')->references('id_docente')->on('docente');

            // Llave foránea para grupo (DEBE SER STRING)
            $table->string('id_grupo', 100);
            $table->foreign('id_grupo')->references('id_grupo')->on('grupo');

            // Clave primaria compuesta para evitar duplicados
            $table->primary(['id_docente', 'id_grupo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente_grupo');
    }
};