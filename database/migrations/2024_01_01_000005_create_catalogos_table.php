<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_propiedad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('icono')->nullable();
            $table->timestamps();
        });

        Schema::create('tipos_operacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('estados_propiedad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('estados_visita', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('etapas_venta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('orden');
            $table->timestamps();
        });

        Schema::create('amenidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('icono')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenidades');
        Schema::dropIfExists('etapas_venta');
        Schema::dropIfExists('estados_visita');
        Schema::dropIfExists('estados_propiedad');
        Schema::dropIfExists('tipos_operacion');
        Schema::dropIfExists('tipos_propiedad');
    }
};
