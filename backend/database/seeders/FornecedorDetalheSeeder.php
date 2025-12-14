<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\FornecedorDetalhe;

class FornecedorDetalheSeeder extends Seeder
{
    public function run(): void
    {
        $fornecedores = [
            'vendas@industriaabc.com' => [
                'prazo_pagamento' => 60,
                'contato_compras' => 'compras@industriaabc.com',
                'categoria' => 'MATERIA_PRIMA',
                'limite_compra' => 100000,
                'observacoes' => 'Fornecedor de matéria-prima principal',
            ],
            'admin@xyzcomercio.com' => [
                'prazo_pagamento' => 30,
                'contato_compras' => 'suporte@xyzcomercio.com',
                'categoria' => 'PRODUTO',
                'limite_compra' => 50000,
                'observacoes' => 'Fornecedor de produtos importados',
            ],
        ];

        foreach ($fornecedores as $email => $detalhes) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $userRole = UserRole::where('user_id', $user->id)
                    ->where('role', 'fornecedor')
                    ->first();
                
                if ($userRole) {
                    FornecedorDetalhe::firstOrCreate(
                        ['user_role_id' => $userRole->id],
                        $detalhes
                    );
                }
            }
        }
    }
}