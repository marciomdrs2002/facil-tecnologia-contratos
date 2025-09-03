<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConvenioServico extends Model
{
    protected $table = 'convenio_servico';
    
    protected $fillable = [
        'codigo',
        'convenio_id',
        'servico',
    ];

    public function convenio(): BelongsTo
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }

    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class, 'convenio_servico_id');
    }
}
