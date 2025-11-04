<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aula', function (Blueprint $table) {
            
            $table->bigInteger('id_aula');
            $table->primary('id_aula');
            $table->string('tipo', 30);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aula');
    }
};

