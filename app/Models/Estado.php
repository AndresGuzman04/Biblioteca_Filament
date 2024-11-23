<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estado extends Model
{

    protected $fillable = ['name_estado'];
    protected $table = 'estados';
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
