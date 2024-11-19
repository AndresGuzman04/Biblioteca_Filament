<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Persona extends Model
{

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
