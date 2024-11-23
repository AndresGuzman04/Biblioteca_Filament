<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Autor;
use App\Models\Libro;
use App\Models\Persona;
use App\Models\Prestamo;


class AutorTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Autores',Autor::query()->count()),
            Card::make('Libros',Libro::query()->count()),
            Card::make('Personas',Persona::query()->count()),
            Card::make('Prestamos Realizados',Prestamo::query()->count()),

        ];
    }
}
