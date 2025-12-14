<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder
{
    public function run(): void
    {
        $usersComPapelFornecedor = User::whereHas('userRoles', function($query) {
            $query->where('role', 'fornecedor')->where('ativo', true);
        })->get();

        foreach ($usersComPapelFornecedor as $user) {
            $pessoa = $user->pessoa;
            
            if ($pessoa && $pessoa->tipo === 'JURIDICA') {
                Fornecedor::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'razao_social' => $pessoa->razao_social,
                        'nome_fantasia' => $pessoa->nome_fantasia,
                        'cnpj' => $pessoa->cnpj,
                        'inscricao_estadual' => $pessoa->inscricao_estadual,
                        'telefone' => $pessoa->telefone,
                        'email_contato' => $user->email,
                        'responsavel' => $pessoa->responsavel,
                        'observacoes' => 'Fornecedor cadastrado via sistema',
                    ]
                );
            }
        }
    }
}