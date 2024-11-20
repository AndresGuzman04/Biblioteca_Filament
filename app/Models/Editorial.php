<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Editorial extends Model
{

    protected $table = 'editoriales';
    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class);
    }
}
