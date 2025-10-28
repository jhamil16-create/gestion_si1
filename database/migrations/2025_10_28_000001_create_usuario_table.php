<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario'); // El diagrama físico usa 'id_usuario_serial'
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombre');
            $table->string('telefono')->nullable();
            // $table->softDeletes('deleted_at');
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};