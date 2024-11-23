<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutorResource\Pages;
use App\Filament\Resources\AutorResource\RelationManagers;
use App\Models\Autor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AutorResource extends Resource
{
    protected static ?string $model = Autor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //nombre
                Forms\Components\TextInput::make('nombres')
                ->required()
                // max 
                ->maxLength(100),
                //apellidos
                Forms\Components\TextInput::make('apellidos')
                ->required()
                // max
                ->maxLength(100),
                //fecha nacimiento
                Forms\Components\DatePicker::make('fecha_nacimiento')
                ->required(),
                //constrained pais
                Forms\Components\Select::make('pais_id')
                //label
                ->label('Pais')
                ->relationship('paises', 'nombre')
                ->searchable()
                ->preload()
                ->createOptionForm([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(100),
                ])
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombres')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('apellidos')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento'),
                Tables\Columns\TextColumn::make('paises.nombre')
                ->label('Pais')
                ->searchable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAutors::route('/'),
            'create' => Pages\CreateAutor::route('/create'),
            'edit' => Pages\EditAutor::route('/{record}/edit'),
        ];
    }
}
