<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrestamoResource\Pages;
use App\Filament\Resources\PrestamoResource\RelationManagers;
use App\Models\Prestamo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrestamoResource extends Resource
{
    protected static ?string $model = Prestamo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Libro
                Forms\Components\Select::make('libro_id')
                ->label('Libro')
                ->relationship('libros', 'titulo')
                ->preload()
                ->required(),

                //Persona
                Forms\Components\Select::make('persona_id')
                ->label('Persona')
                ->relationship('personas', 'id', fn ($query) =>
                    $query->selectRaw("id, CONCAT(nombres, ' ', apellidos) AS nombre_completo") // Alias en la consulta
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->nombre_completo) // Mostrar el nombre completo en la lista desplegable
                ->preload()
                ->createOptionForm([
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
                ])
                ->required(),
                
                //Fecha de prestamo
                Forms\Components\DatePicker::make('fecha_prestamo')
                ->label('Fecha de préstamo')
                ->default(fn () => now()->format('Y-m-d')) // Define la fecha actual automáticamente
                ->disabled(fn (callable $get) => $get('id') === null)// Desactiva si el formulario está en modo de creación
                ->required(),
                
                //Fecha de devolucion
                Forms\Components\DatePicker::make('fecha_devolucion')->afterOrEqual('fecha_prestamo')
                ->label('Fecha de devolución')
                ->required()
                ->reactive()
                ->default(fn () => now()->format('Y-m-d')) // Define la fecha actual automáticamente
                ->afterStateHydrated(function (callable $set, callable $get) {
                    // Revisa automáticamente si la fecha de devolución ya pasó
                    if ($get('estado') === 0 && $get('fecha_devolucion') < now()->format('Y-m-d')) {
                        $set('estado', 2); // Cambia el estado a "Vencido"
                    }
                }),

                //Estado
                Forms\Components\Select::make('estado')
                ->label('Estado')
                ->options([
                    0 => 'Pendiente',
                    1 => 'Devuelto',
                    2 => 'Vencido',
                ])
                ->default(0) // Estado inicial como "Pendiente" (clave 0)
                ->required()
                ->disabled(fn (callable $get) => $get('id') === null) // Desactiva si el formulario está en modo de creación
                ->reactive() // Permite observar cambios en este campo
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state === 1) { // Devuelto
                        $set('fecha_devolucion', now()->format('Y-m-d')); // Establece la fecha de devolución
                    }
                }),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('generos.nombre')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('editoriales.nombre')
                ->searchable(),
                Tables\Columns\TextColumn::make('autors.nombres')
                ->label('Autor')
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
            'index' => Pages\ListPrestamos::route('/'),
            'create' => Pages\CreatePrestamo::route('/create'),
            'edit' => Pages\EditPrestamo::route('/{record}/edit'),
        ];
    }
}
