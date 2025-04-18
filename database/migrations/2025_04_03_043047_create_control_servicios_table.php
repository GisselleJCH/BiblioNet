<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlServiciosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('control_servicios', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('miembro_id'); 
            $table->unsignedBigInteger('computadora_id')->nullable(); 
            $table->unsignedBigInteger('libro_id')->nullable(); 
            $table->string('sala_atencion', 255); 
            $table->string('tipo_servicio', 255); 
            $table->timestamp('ingreso')->nullable(); 
            $table->timestamp('fecha_devolucion')->nullable();
            $table->unsignedBigInteger('atendido_por');
            $table->string('numero_locker', 255)->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');
            $table->foreign('computadora_id')->references('id')->on('computadoras')->onDelete('cascade');
            $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');
            $table->foreign('atendido_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_servicios');
    }
}