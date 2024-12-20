<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibroResource\Pages;
use App\Filament\Resources\LibroResource\RelationManagers;
use App\Models\Libro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\DB;


class LibroResource extends Resource
{
    protected static ?string $model = Libro::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //titulo
                Forms\Components\TextInput::make('titulo')
                ->required(),
                //genero_id
                Forms\Components\Select::make('genero_id')
                //label
                ->label('Genero')
                ->relationship('generos', 'nombre')
                ->preload()
                ->createOptionForm([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(100),
                ])
                ->required(),

                Forms\Components\Select::make('editorial_id')
                //label
                ->label('Editorial')
                ->relationship('editoriales', 'nombre')
                ->preload()
                ->searchable()
                ->createOptionForm([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(100),
                ])
                ->required(),

                Forms\Components\Select::make('autor_id')
                ->label('Autor')
                ->relationship('autors', 'id', fn ($query) =>
                    $query->selectRaw("id, CONCAT(nombres, ' ', apellidos) AS nombre_completo") // Alias en la consulta
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->nombre_completo) // Mostrar el nombre completo en la lista desplegable
                ->preload()
                ->required(),

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
                ->label('Editorial')
                ->searchable(),
                Tables\Columns\TextColumn::make('autors.nombres')
                ->label('Autor')
                ->searchable()
                ->getStateUsing(function ($record) {
                    // Llamar al procedimiento almacenado con el ID de la persona
                    $autorid = $record->id; // O ajusta según el nombre del campo que tiene el ID
                    $result = DB::select('CALL GetDatosAutorsById(?)', [$autorid]);

                    // Retornar el nombre de la persona si la consulta tiene un resultado
                    return $result[0]->nombre_AutorById ?? 'N/A'; // Si no se encuentra, retornar 'N/A'
                })
                ->sortable(),
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
            'index' => Pages\ListLibros::route('/'),
            'create' => Pages\CreateLibro::route('/create'),
            'edit' => Pages\EditLibro::route('/{record}/edit'),
        ];
    }
}
