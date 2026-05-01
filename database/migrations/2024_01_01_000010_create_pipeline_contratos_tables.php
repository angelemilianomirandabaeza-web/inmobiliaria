<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pipeline_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agente_id')->constrained('agentes')->onDelete('cascade');
            $table->foreignId('etapa_id')->constrained('etapas_venta');
            $table->text('notas')->nullable();
            $table->date('fecha_estimada_cierre')->nullable();
            $table->timestamps();
        });

        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id')->constrained('propiedades');
            $table->foreignId('cliente_id')->constrained('users');
            $table->foreignId('agente_id')->constrained('agentes');
            $table->enum('tipo_contrato', ['compraventa', 'arrendamiento']);
            $table->decimal('precio_acordado', 15, 2);
            $table->date('fecha_firma');
            $table->date('fecha_entrega')->nullable();
            $table->decimal('comision_agente', 10, 2)->nullable();
            $table->string('archivo_pdf')->nullable();
            $table->timestamps();
        });

        Schema::create('planes_publicacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('max_propiedades');
            $table->integer('duracion_dias');
            $table->decimal('precio_plan', 10, 2)->default(0);
            $table->boolean('propiedades_destacadas')->default(false);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agente_id')->constrained('agentes')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('planes_publicacion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        Schema::create('resenias_agente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agente_id')->constrained('agentes')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();
            $table->unique(['agente_id', 'cliente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenias_agente');
        Schema::dropIfExists('suscripciones');
        Schema::dropIfExists('planes_publicacion');
        Schema::dropIfExists('contratos');
        Schema::dropIfExists('pipeline_ventas');
    }
};
