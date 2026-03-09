<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\ClienteDetalhe;

class ClienteDetalheSeeder extends Seeder
{
    public function run(): void
    {
        $clientesPF = ['carlos@email.com', 'ana@email.com', 'roberto@email.com'];
        $categorias = ['NORMAL', 'VIP', 'ESPECIAL'];
        $i = 0;

        foreach ($clientesPF as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $userRole = UserRole::where('user_id', $user->id)
                    ->where('role', 'cliente')
                    ->first();
                
                if ($userRole) {
                    ClienteDetalhe::firstOrCreate(
                        ['user_role_id' => $userRole->id],
                        [
                            'limite_credito' => rand(1000, 10000),
                            'categoria' => $categorias[$i % 3],
                            'data_adesao' => now()->subDays(rand(30, 365)),
                            'observacoes' => "Cliente desde " . now()->subDays(rand(30, 365))->format('d/m/Y'),
                        ]
                    );
                    $i++;
                }
            }
        }

        $clientesPJ = [
            'contato@techsolutions.com' => [
                'limite_credito' => 50000,
                'categoria' => 'VIP',
                'observacoes' => 'Cliente corporativo, pagamento em 30 dias',
            ],
            'vendas@industriaabc.com' => [
                'limite_credito' => 75000,
                'categoria' => 'ESPECIAL',
                'observacoes' => 'Grande volume de compras, contrato anual',
            ],
            'admin@xyzcomercio.com' => [
                'limite_credito' => 30000,
                'categoria' => 'VIP',
                'observacoes' => 'Cliente internacional, pagamento antecipado',
            ],
        ];

        foreach ($clientesPJ as $email => $detalhes) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $userRole = UserRole::where('user_id', $user->id)
                    ->where('role', 'cliente')
                    ->first();
                
                if ($userRole) {
                    ClienteDetalhe::firstOrCreate(
                        ['user_role_id' => $userRole->id],
                        array_merge($detalhes, [
                            'data_adesao' => now()->subDays(rand(180, 720)),
                        ])
                    );
                }
            }
        }
    }
}