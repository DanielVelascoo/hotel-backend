<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Renombrar 'name' a 'nombre' para trabajar en español
            $table->renameColumn('name', 'nombre');

            // Agregar campos útiles
            $table->string('telefono', 30)->nullable()->after('email');
            $table->string('tipo_documento', 20)->nullable()->after('telefono');
            $table->string('documento', 50)->nullable()->after('tipo_documento');

            // Estado del usuario
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('documento');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Revertir cambios
            $table->renameColumn('nombre', 'name');
            $table->dropColumn(['telefono', 'tipo_documento', 'documento', 'estado']);
        });
    }
};
