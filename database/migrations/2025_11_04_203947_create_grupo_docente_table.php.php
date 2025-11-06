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
        Schema::create('docente_grupo', function (Blueprint $table) {
            
            // 1. TU NUEVA COLUMNA (PK)
            // Esto crea la columna 'id_doc_grup' como BigInteger, 
            // auto-incremental y llave primaria.
            $table->id('id_doc_grup'); 

            // 2. Llave foránea para docente
            $table->unsignedBigInteger('id_docente');
            $table->foreign('id_docente')
                ->references('id_docente')
                ->on('docente');

            // 3. Llave foránea para grupo
            // ¡OJO! Esto asume que 'id_grupo' en la tabla 'grupo' es un STRING
            $table->string('id_grupo', 100); 
            $table->foreign('id_grupo')
                ->references('id_grupo')
                ->on('grupo');
            
            // 4. (Opcional pero recomendado)
            // Esto evita que puedas asignar el MISMO docente al MISMO grupo dos veces.
            $table->unique(['id_docente', 'id_grupo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_grupo');
    }
};