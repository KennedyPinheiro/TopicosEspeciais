<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pessoa()
    {
        return $this->hasOne(Pessoa::class);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function enderecos()
    {
        return $this->morphMany(Endereco::class, 'enderecavel');
    }

    public function hasRole($role)
    {
        return $this->userRoles()
            ->where('role', $role)
            ->where('ativo', true)
            ->exists();
    }

    public function isCliente()
    {
        return $this->hasRole('cliente');
    }

    public function isFornecedor()
    {
        return $this->hasRole('fornecedor');
    }

    public function isFuncionario()
    {
        return $this->hasRole('funcionario');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function getClienteDetalhe()
    {
        $userRole = $this->userRoles()
            ->where('role', 'cliente')
            ->where('ativo', true)
            ->first();

        return $userRole ? $userRole->clienteDetalhe : null;
    }

    public function getFornecedorDetalhe()
    {
        $userRole = $this->userRoles()
            ->where('role', 'fornecedor')
            ->where('ativo', true)
            ->first();

        return $userRole ? $userRole->fornecedorDetalhe : null;
    }

    public function getFuncionarioDetalhe()
    {
        $userRole = $this->userRoles()
            ->where('role', 'funcionario')
            ->where('ativo', true)
            ->first();

        return $userRole ? $userRole->funcionarioDetalhe : null;
    }

    public function addRole($role, $detalhes = [])
    {
        $userRole = $this->userRoles()->updateOrCreate(
            ['role' => $role],
            ['ativo' => true]
        );

        if (!empty($detalhes)) {
            $this->criarDetalhesPorRole($userRole, $role, $detalhes);
        }

        return $userRole;
    }

    private function criarDetalhesPorRole($userRole, $role, $detalhes)
    {
        switch ($role) {
            case 'cliente':
                $userRole->clienteDetalhe()->updateOrCreate([], $detalhes);
                break;
            case 'fornecedor':
                $userRole->fornecedorDetalhe()->updateOrCreate([], $detalhes);
                break;
            case 'funcionario':
                $userRole->funcionarioDetalhe()->updateOrCreate([], $detalhes);
                break;
        }
    }

    public function removeRole($role)
    {
        return $this->userRoles()
            ->where('role', $role)
            ->update(['ativo' => false]);
    }

    public function getRolesAtivos()
    {
        return $this->userRoles()
            ->ativos()
            ->pluck('role')
            ->toArray();
    }
}
