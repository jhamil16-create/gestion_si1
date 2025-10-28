<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aula', function (Blueprint $table) {
            $table->id('id_aula'); // id_aula serial
            $table->smallInteger('capacidad');
            $table->string('tipo', 30);
            // $table->timestamps(); sin timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aula');
    }
};