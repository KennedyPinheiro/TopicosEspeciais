<?php
// app/Models/FornecedorDetalhe.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FornecedorDetalhe extends Model
{
    use HasFactory;

    protected $table = 'fornecedor_detalhes';

    protected $fillable = [
        'user_role_id',
        'prazo_pagamento',
        'contato_compras',
        'categoria',
        'limite_compra',
        'observacoes',
    ];

    protected $casts = [
        'limite_compra' => 'decimal:2',
    ];

    // Relações
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            UserRole::class,
            'id',
            'id',
            'user_role_id',
            'user_id'
        );
    }
}