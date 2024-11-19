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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            //genero constrained
            $table->foreignId('genero_id')->constrained('generos')->cascadeOnDelete();
            //editorial constrained
            $table->foreignId('editorial_id')->constrained('editoriales')->cascadeOnDelete();
            //autor constrainded
            $table->foreignId('autor_id')->constrained('autors')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
