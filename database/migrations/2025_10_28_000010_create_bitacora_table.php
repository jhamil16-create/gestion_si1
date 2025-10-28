<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id('id_bitacora'); // id_bitacora bigserial
            $table->text('descripcion');
            $table->timestamp('fecha_hora')->useCurrent();
            $table->string('ip_origen', 45)->nullable();

            // Llave foránea para 'usuario'
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};