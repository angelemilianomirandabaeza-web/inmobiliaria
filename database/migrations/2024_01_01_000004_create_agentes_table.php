<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agencia_id')->nullable()->constrained('agencias')->nullOnDelete();
            $table->string('licencia_numero')->nullable();
            $table->text('biografia')->nullable();
            $table->string('especialidad')->nullable();
            $table->integer('anios_experiencia')->default(0);
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->integer('total_ventas')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agentes');
    }
};
