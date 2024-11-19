<?php

namespace App\Filament\Resources\AutorResource\Pages;

use App\Filament\Resources\AutorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutors extends ListRecords
{
    protected static string $resource = AutorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
