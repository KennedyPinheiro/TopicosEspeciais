<?php
// app/Models/UserRole.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'role',
        'ativo',
        'config',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'config' => 'array',
    ];

    // Relações (agora as models existem)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clienteDetalhe()
    {
        return $this->hasOne(ClienteDetalhe::class, 'user_role_id');
    }

    public function fornecedorDetalhe()
    {
        return $this->hasOne(FornecedorDetalhe::class, 'user_role_id');
    }

    public function funcionarioDetalhe()
    {
        return $this->hasOne(FuncionarioDetalhe::class, 'user_role_id');
    }

    // Métodos helper
    public function getDetalhe()
    {
        switch ($this->role) {
            case 'cliente':
                return $this->clienteDetalhe;
            case 'fornecedor':
                return $this->fornecedorDetalhe;
            case 'funcionario':
                return $this->funcionarioDetalhe;
            default:
                return null;
        }
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorRole($query, $role)
    {
        return $query->where('role', $role);
    }
}