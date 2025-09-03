<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Convenio extends Model
{
    protected $table = 'convenio';
    
    protected $fillable = [
        'codigo',
        'convenio',
        'verba',
        'banco_id',
    ];

    public function banco(): BelongsTo
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    public function convenioServicos(): HasMany
    {
        return $this->hasMany(ConvenioServico::class, 'convenio_id');
    }
}
