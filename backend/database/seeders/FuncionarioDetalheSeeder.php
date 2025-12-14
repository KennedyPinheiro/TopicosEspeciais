<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\FuncionarioDetalhe;

class FuncionarioDetalheSeeder extends Seeder
{
    public function run(): void
    {
        $funcionarios = [
            'joao@ivendas.com' => [
                'cargo' => 'Vendedor',
                'salario' => 3500.00,
                'data_admissao' => '2022-03-15',
                'ctps' => '123456789',
                'pis' => '12345678901',
                'observacoes' => 'Funcionário dedicado, bom relacionamento com clientes',
            ],
            'maria@ivendas.com' => [
                'cargo' => 'Gerente Comercial',
                'salario' => 6500.00,
                'data_admissao' => '2020-08-10',
                'ctps' => '987654321',
                'pis' => '98765432109',
                'observacoes' => 'Excelente gestora, responsável por toda equipe comercial',
            ],
        ];

        foreach ($funcionarios as $email => $detalhes) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $userRole = UserRole::where('user_id', $user->id)
                    ->where('role', 'funcionario')
                    ->first();
                
                if ($userRole) {
                    FuncionarioDetalhe::firstOrCreate(
                        ['user_role_id' => $userRole->id],
                        $detalhes
                    );
                }
            }
        }
    }
}