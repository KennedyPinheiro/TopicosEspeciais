<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'user_id',
        'telefone',
        'data_nascimento',
        'imagem'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'enderecavel');
    }
}
