<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Autor extends Model
{

    public function paises(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class);
    }
    
}
