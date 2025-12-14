<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $usersComPapelCliente = User::whereHas('userRoles', function($query) {
            $query->where('role', 'cliente')->where('ativo', true);
        })->get();

        foreach ($usersComPapelCliente as $user) {
            $pessoa = $user->pessoa;
            
            if ($pessoa) {
                Cliente::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'tipo_pessoa' => $pessoa->tipo === 'FISICA' ? 'PF' : 'PJ',
                        'telefone' => $pessoa->telefone,
                        'data_nascimento' => $pessoa->data_nascimento,
                        'cpf' => $pessoa->cpf,
                        'cnpj' => $pessoa->cnpj,
                        'razao_social' => $pessoa->razao_social,
                        'nome_fantasia' => $pessoa->nome_fantasia,
                        'inscricao_estadual' => $pessoa->inscricao_estadual,
                    ]
                );
            }
        }
    }
}