<?php
// app/Models/Endereco.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'enderecavel_id',
        'enderecavel_type',
        'logradouro',
        'numero',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'complemento',
    ];

    // Relação polimórfica
    public function enderecavel()
    {
        return $this->morphTo();
    }

    // Accessors
    public function getEnderecoCompletoAttribute()
    {
        $parts = [
            $this->logradouro,
            $this->numero,
            $this->bairro,
            $this->cidade,
            $this->estado,
            $this->cep,
            $this->complemento,
        ];

        return implode(', ', array_filter($parts));
    }

    public function getCepFormatadoAttribute()
    {
        if (strlen($this->cep) === 8) {
            return substr($this->cep, 0, 5) . '-' . substr($this->cep, 5);
        }
        
        return $this->cep;
    }
}