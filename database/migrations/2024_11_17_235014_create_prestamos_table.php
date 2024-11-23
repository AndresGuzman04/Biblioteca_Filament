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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table-> foreignId('libro_id')->constrained('libros')->cascadeOnDelete();
            $table->foreignId('persona_id')->constrained('personas')->cascadeOnDelete();
            $table->date('fecha_prestamo')->default(DB::raw('CURRENT_DATE'));
            $table->date('fecha_devolucion');
            // Definir estado_id como unsignedBigInteger y agregar valor predeterminado
            $table->unsignedBigInteger('estado_id')->default(1);
            $table->foreign('estado_id')->references('id')->on('estados')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
