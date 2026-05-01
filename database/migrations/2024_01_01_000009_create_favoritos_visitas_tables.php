<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['cliente_id', 'propiedad_id']);
        });

        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agente_id')->constrained('agentes')->onDelete('cascade');
            $table->date('fecha_visita');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->foreignId('estado_visita_id')->constrained('estados_visita');
            $table->text('notas_cliente')->nullable();
            $table->text('notas_agente')->nullable();
            $table->timestamps();
        });

        Schema::create('solicitudes_contacto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nombre_contacto');
            $table->string('email_contacto');
            $table->string('telefono_contacto')->nullable();
            $table->text('mensaje');
            $table->boolean('respondida')->default(false);
            $table->timestamps();
        });

        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tipo_propiedad_id')->nullable()->constrained('tipos_propiedad')->nullOnDelete();
            $table->foreignId('tipo_operacion_id')->nullable()->constrained('tipos_operacion')->nullOnDelete();
            $table->foreignId('colonia_id')->nullable()->constrained('colonias')->nullOnDelete();
            $table->decimal('precio_min', 15, 2)->nullable();
            $table->decimal('precio_max', 15, 2)->nullable();
            $table->integer('habitaciones_min')->nullable();
            $table->decimal('metros_min', 10, 2)->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        Schema::create('historial_precios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->decimal('precio_anterior', 15, 2);
            $table->decimal('precio_nuevo', 15, 2);
            $table->date('fecha_cambio');
            $table->string('motivo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_precios');
        Schema::dropIfExists('alertas');
        Schema::dropIfExists('solicitudes_contacto');
        Schema::dropIfExists('visitas');
        Schema::dropIfExists('favoritos');
    }
};
