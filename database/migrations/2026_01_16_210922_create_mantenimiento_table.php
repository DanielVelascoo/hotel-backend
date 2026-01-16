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
      Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habitacion_id')->constrained('habitaciones');
            $table->foreignId('usuario_reporta')->constrained('users');
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
            $table->text('descripcion');
            $table->enum('estado', ['pendiente', 'en_progreso', 'resuelto'])->default('pendiente');
            $table->timestamp('reportado_en')->useCurrent();
            $table->timestamp('resuelto_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};
