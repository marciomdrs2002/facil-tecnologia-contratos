<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banco extends Model
{
    protected $table = 'banco';
    
    protected $fillable = [
        'codigo',
        'nome',
    ];

    public function convenios(): HasMany
    {
        return $this->hasMany(Convenio::class, 'banco_id');
    }
}
