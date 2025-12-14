<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Fornecedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'telefone',
        'email_contato',
        'responsavel',
        'site',
        'observacoes',
    ];

  
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enderecos(): MorphMany
    {
        return $this->morphMany(Endereco::class, 'enderecavel');
    }

    
    public function scopeAtivos($query)
    {
        return $query->whereHas('user', function($q) {
            $q->whereHas('userRoles', function($q2) {
                $q2->where('role', 'fornecedor')->where('ativo', true);
            });
        });
    }

    public function scopePorCnpj($query, $cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        return $query->where('cnpj', $cnpj);
    }

    
    public function pessoa()
    {
        return $this->user->pessoa ?? null;
    }

   
    public function getCnpjFormatadoAttribute()
    {
        $cnpj = $this->cnpj;
        if (strlen($cnpj) === 14) {
            return substr($cnpj, 0, 2) . '.' . 
                   substr($cnpj, 2, 3) . '.' . 
                   substr($cnpj, 5, 3) . '/' . 
                   substr($cnpj, 8, 4) . '-' . 
                   substr($cnpj, 12, 2);
        }
        return $cnpj;
    }

   
    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = preg_replace('/[^0-9]/', '', $value);
    }

   
    public function sincronizarComPessoa()
    {
        $pessoa = $this->user->pessoa;
        
        if ($pessoa && $pessoa->tipo === 'JURIDICA') {
            $this->update([
                'razao_social' => $pessoa->razao_social,
                'nome_fantasia' => $pessoa->nome_fantasia,
                'cnpj' => $pessoa->cnpj,
                'inscricao_estadual' => $pessoa->inscricao_estadual,
                'telefone' => $pessoa->telefone,
            ]);
        }
    }

   
    public function isCliente()
    {
        return $this->user->isCliente();
    }

   
    public function getDetalhesAttribute()
    {
        return $this->user->getFornecedorDetalhe();
    }
}