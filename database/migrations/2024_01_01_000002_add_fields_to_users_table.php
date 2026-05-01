<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rol_id')->default(3)->after('id')->constrained('roles');
            $table->string('telefono')->nullable()->after('email');
            $table->string('foto_perfil')->nullable()->after('telefono');
            $table->boolean('activo')->default(true)->after('foto_perfil');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rol_id']);
            $table->dropColumn(['rol_id', 'telefono', 'foto_perfil', 'activo']);
        });
    }
};
