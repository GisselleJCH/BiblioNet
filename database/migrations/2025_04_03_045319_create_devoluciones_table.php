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
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('miembro_id'); 
            $table->unsignedBigInteger('control_servicio_id');
            $table->unsignedBigInteger('usuario_atendio'); 
            $table->string('tipo_servicio', 255); 
            $table->string('signatura_topografica')->nullable(); 
            $table->string('codigo_computadora')->nullable(); 
            $table->integer('cantidad')->default(1); 
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_devolucion')->nullable();
            $table->enum('estado', ['Devuelto', 'Dañado', 'Extraviado'])->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');
            $table->foreign('control_servicio_id')->references('id')->on('control_servicios')->onDelete('cascade');
            $table->foreign('usuario_atendio')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
