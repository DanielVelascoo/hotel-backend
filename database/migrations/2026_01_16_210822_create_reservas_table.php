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
 Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huesped_id')->constrained('huespedes');
            $table->foreignId('tipo_habitacion_id')->constrained('tipos_habitacion');
            $table->foreignId('habitacion_id')->nullable()->constrained('habitaciones');
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'no_show'])->default('pendiente');
            $table->string('origen', 50)->default('recepcion');
            $table->decimal('monto_estimado', 10, 2)->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->timestamps();

            // Prevención de sobrebooking
            $table->index(['tipo_habitacion_id', 'fecha_entrada', 'fecha_salida']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
