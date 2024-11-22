<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestamo extends Model
{
    protected $fillable = ['libro_id', 'persona_id', 'fecha_prestamo', 'fecha_devolucion','estado', 'created_at', 'updated_at'];
    public function personas(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function libros(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
