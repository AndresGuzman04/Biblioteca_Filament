<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonaResource\Pages;
use App\Filament\Resources\PersonaResource\RelationManagers;
use App\Models\Persona;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonaResource extends Resource
{
    protected static ?string $model = Persona::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombres')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('apellidos')
                        ->required()
                        ->maxLength(100),
                    //telefono
                    Forms\Components\TextInput::make('telefono')
                    ->required()
                    ->maxLength(20)
                    ->rule('regex:/^[267]{1}[0-9]{7}$/'),
                    //direccion
                    Forms\Components\TextInput::make('direccion')
                    ->required()
                    ->maxLength(100),
                    //correo
                    Forms\Components\TextInput::make('correo')
                    ->required()
                    ->maxLength(100)
                    ->email(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombres')
                ->searchable(),
                Tables\Columns\TextColumn::make('apellidos')
                ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                ->searchable(),
                Tables\Columns\TextColumn::make('direccion'),
                Tables\Columns\TextColumn::make('correo'),
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
            'index' => Pages\ListPersonas::route('/'),
            'create' => Pages\CreatePersona::route('/create'),
            'edit' => Pages\EditPersona::route('/{record}/edit'),
        ];
    }
}
