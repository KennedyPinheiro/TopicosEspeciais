<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@ivendas.com'],
            [
                'name' => 'Administrador Sistema',
                'password' => Hash::make('senha123'),
                'email_verified_at' => now(),
            ]
        );

        $funcionarios = [
            [
                'name' => 'João Silva',
                'email' => 'joao@ivendas.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@ivendas.com',
                'password' => Hash::make('senha123'),
            ],
        ];

        foreach ($funcionarios as $funcionario) {
            User::firstOrCreate(
                ['email' => $funcionario['email']],
                $funcionario
            );
        }

        $clientesPF = [
            [
                'name' => 'Carlos Oliveira',
                'email' => 'carlos@email.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Ana Pereira',
                'email' => 'ana@email.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Roberto Alves',
                'email' => 'roberto@email.com',
                'password' => Hash::make('senha123'),
            ],
        ];

        foreach ($clientesPF as $cliente) {
            User::firstOrCreate(
                ['email' => $cliente['email']],
                $cliente
            );
        }

        $clientesPJ = [
            [
                'name' => 'Empresa Tech Solutions',
                'email' => 'contato@techsolutions.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Indústria ABC Ltda',
                'email' => 'vendas@industriaabc.com',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Comércio XYZ S/A',
                'email' => 'admin@xyzcomercio.com',
                'password' => Hash::make('senha123'),
            ],
        ];

        foreach ($clientesPJ as $cliente) {
            User::firstOrCreate(
                ['email' => $cliente['email']],
                $cliente
            );
        }
    }
}