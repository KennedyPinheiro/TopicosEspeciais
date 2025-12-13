<?php
// app/Models/FuncionarioDetalhe.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioDetalhe extends Model
{
    use HasFactory;

    protected $table = 'funcionario_detalhes';

    protected $fillable = [
        'user_role_id',
        'cargo',
        'salario',
        'data_admissao',
        'data_demissao',
        'ctps',
        'pis',
        'observacoes',
    ];

    protected $casts = [
        'salario' => 'decimal:2',
        'data_admissao' => 'date',
        'data_demissao' => 'date',
    ];

    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function scopeAtivos($query)
    {
        return $query->whereNull('data_demissao');
    }
}