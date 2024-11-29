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

    // Crear el procedimiento GetDatosPersonasById
    DB::unprepared('
        CREATE PROCEDURE GetDatosPersonasById(IN personaid BIGINT)
        BEGIN
            SELECT CONCAT(nombres, " ", apellidos) AS nombre_PersonaById
            FROM personas
            WHERE id = personaid;
        END
    ');

    // Crear el procedimiento GetDatosAutorsById
    DB::unprepared('
        CREATE PROCEDURE GetDatosAutorsById(IN autorsid BIGINT)
        BEGIN
            SELECT CONCAT(nombres, " ", apellidos) AS nombre_AutorById
            FROM autors
            WHERE id = autorsid;
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDatosPersonasById');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDatosAutorsById');
    }
};
