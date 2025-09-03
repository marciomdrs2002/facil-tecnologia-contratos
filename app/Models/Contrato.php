<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contrato extends Model
{
    protected $table = 'contrato';
    
    protected $fillable = [
        'codigo',
        'prazo',
        'valor',
        'data_inclusao',
        'convenio_servico_id',
    ];

    protected $casts = [
        'prazo' => 'date',
        'data_inclusao' => 'datetime',
        'valor' => 'decimal:2',
    ];

    public function convenioServico(): BelongsTo
    {
        return $this->belongsTo(ConvenioServico::class, 'convenio_servico_id');
    }
}
