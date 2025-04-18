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
        Schema::create('miembros', function (Blueprint $table) {
            $table->id();
            $table->string('carnet', 10)->unique();
            $table->string('cedula', 15)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('carrera', 100)->nullable();
            $table->enum('turno', ['Matutino', 'Vespertino', 'Nocturno', 'Sabatino', 'Dominical']);
            $table->enum('sexo', ['Masculino', 'Femenino']);
            $table->string('area_conocimiento', 100);
            $table->string('sede', 100);
            $table->enum('tipo_miembro', ['Estudiante', 'Maestro']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
