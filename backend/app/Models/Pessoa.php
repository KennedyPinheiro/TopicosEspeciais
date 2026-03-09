<?php
// app/Models/Pessoa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo',
        'telefone',
        'celular',
        'imagem',
        'cpf',
        'rg',
        'data_nascimento',
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'inscricao_estadual',
        'data_fundacao',
        'responsavel',
    ];

    protected $casts = [
        'imagem' => 'array',
        'data_nascimento' => 'date',
        'data_fundacao' => 'date',
    ];

    // Relações
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'enderecavel');
    }

    // Accessors
    public function getDocumentoAttribute()
    {
        return $this->tipo === 'FISICA' ? $this->cpf : $this->cnpj;
    }

    public function getNomeCompletoAttribute()
    {
        if ($this->tipo === 'FISICA') {
            return $this->user->name;
        } else {
            return $this->razao_social ?: $this->nome_fantasia;
        }
    }

    // Mutators
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = preg_replace('/[^0-9]/', '', $value);
    }

    // Scopes
    public function scopePessoasFisicas($query)
    {
        return $query->where('tipo', 'FISICA');
    }

    public function scopePessoasJuridicas($query)
    {
        return $query->where('tipo', 'JURIDICA');
    }

    public function scopePorDocumento($query, $documento)
    {
        $documento = preg_replace('/[^0-9]/', '', $documento);
        
        if (strlen($documento) === 11) {
            return $query->where('cpf', $documento);
        } elseif (strlen($documento) === 14) {
            return $query->where('cnpj', $documento);
        }
        
        return $query;
    }
}