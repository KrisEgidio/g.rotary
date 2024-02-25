<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'hora',
        'data',
        'grau',
        'endereco',
        'bairro',
        'cep',
        'cidade_id',
        'loja_id',
        'criado_por',
        'imagem_id',
    ];

    protected $casts = [
        'data' => 'date',
        'hora' => 'time',
        'cidade_id' => 'integer',
        'loja_id' => 'integer',
        'criado_por' => 'integer',
        'imagem_id' => 'integer',
    ];

    public function cidade() : BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }

    public function loja() : BelongsTo
    {
        return $this->belongsTo(Loja::class);
    }

    public function usuario() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function imagem() : MorphMany
    {
        return $this->morphMany(Imagem::class, 'model');
    }

    public function compartilhamentos() : HasMany
    {
        return $this->hasMany(Compartilhamento::class);
    }

    public function confirmacoes() : MorphMany
    {
        return $this->morphMany(Confirmacao::class, 'model');
    }
}