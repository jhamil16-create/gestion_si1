<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrador', function (Blueprint $table) {
            $table->id('id_administrador'); // 'id_admin_serial' en el diagrama

            // Esta es la llave foránea que la conecta con la tabla usuario
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('cascade'); // Si se borra el usuario, se borra el admin

            // Aquí irían campos *específicos* del administrador si los tuviera
            // Pero en este caso no los tiene, así que dejamos solo la llave foránea
            // $table->string('permiso_especial')->nullable();

            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrador');
    }
};