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
       Schema::create('estadias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas');
            $table->foreignId('habitacion_id')->constrained('habitaciones');
            $table->timestamp('check_in')->useCurrent();
            $table->timestamp('check_out')->nullable();
            $table->enum('estado', ['hospedado', 'finalizado'])->default('hospedado');
            $table->foreignId('usuario_checkin')->nullable()->constrained('users');
            $table->foreignId('usuario_checkout')->nullable()->constrained('users');
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadias');
    }
};
