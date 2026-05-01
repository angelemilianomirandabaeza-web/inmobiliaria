<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->decimal('precio', 15, 2);
            $table->decimal('precio_anterior', 15, 2)->nullable();
            $table->foreignId('tipo_operacion_id')->constrained('tipos_operacion');
            $table->foreignId('tipo_propiedad_id')->constrained('tipos_propiedad');
            $table->foreignId('estado_propiedad_id')->constrained('estados_propiedad');
            $table->foreignId('agente_id')->constrained('agentes')->onDelete('cascade');
            $table->foreignId('colonia_id')->constrained('colonias');
            $table->string('direccion');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->decimal('metros_construccion', 10, 2)->nullable();
            $table->decimal('metros_terreno', 10, 2)->nullable();
            $table->integer('habitaciones')->default(0);
            $table->integer('banios')->default(0);
            $table->integer('medios_banios')->default(0);
            $table->integer('estacionamientos')->default(0);
            $table->integer('antiguedad_anios')->nullable();
            $table->integer('piso')->nullable();
            $table->integer('total_pisos')->nullable();
            $table->boolean('amueblado')->default(false);
            $table->boolean('destacada')->default(false);
            $table->boolean('aprobada')->default(false);
            $table->integer('visitas_contador')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propiedades');
    }
};
