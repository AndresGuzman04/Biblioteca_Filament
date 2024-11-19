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
        return $this->belongsTo(Genero::class);
    }

    public function editorial(): BelongsTo
    {
        return $this->belongsTo(Editorial::class);
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(Autor::class);
    }
}
