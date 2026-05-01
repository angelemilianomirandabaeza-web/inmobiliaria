<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_propiedad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->string('url_imagen');
            $table->boolean('es_principal')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('propiedad_amenidad', function (Blueprint $table) {
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->foreignId('amenidad_id')->constrained('amenidades')->onDelete('cascade');
            $table->primary(['propiedad_id', 'amenidad_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propiedad_amenidad');
        Schema::dropIfExists('imagenes_propiedad');
    }
};
