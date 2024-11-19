<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pais extends Model
{
    protected $table = 'paises';
    
    public function autors(): HasMany
    {
        return $this->hasMany(Autor::class);
    }
}
