<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docente', function (Blueprint $table) {
            $table->id('id_docente'); // 'id_docente_serial' en el diagrama

            // Llave foránea que la conecta con la tabla usuario
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('cascade'); // Si se borra el usuario, se borra el docente

            // Aquí irían campos *específicos* del docente
            // Pero como no hay en la estructura actual, los dejamos comentados
            // $table->string('cubiculo')->nullable();
            // $table->string('especialidad')->nullable();

            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente');
    }
};