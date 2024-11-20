<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Libro extends Model
{
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }

    public function generos(): BelongsTo
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    public function editoriales(): BelongsTo
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }

    public function autors(): BelongsTo
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }
}
