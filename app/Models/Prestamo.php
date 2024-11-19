<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestamo extends Model
{

    public function personas(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }
    public function libros(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }
}
