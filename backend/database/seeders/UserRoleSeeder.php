<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@ivendas.com')->first();
        if ($admin) {
            UserRole::firstOrCreate(
                ['user_id' => $admin->id, 'role' => 'admin'],
                ['ativo' => true]
            );
        }

        $funcionarios = ['joao@ivendas.com', 'maria@ivendas.com'];
        foreach ($funcionarios as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                UserRole::firstOrCreate(
                    ['user_id' => $user->id, 'role' => 'funcionario'],
                    ['ativo' => true]
                );
            }
        }

        $clientesPF = ['carlos@email.com', 'ana@email.com', 'roberto@email.com'];
        foreach ($clientesPF as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                UserRole::firstOrCreate(
                    ['user_id' => $user->id, 'role' => 'cliente'],
                    ['ativo' => true]
                );
            }
        }

        $clientesPJ = [
            'contato@techsolutions.com' => ['cliente'],
            'vendas@industriaabc.com' => ['cliente', 'fornecedor'],
            'admin@xyzcomercio.com' => ['cliente', 'fornecedor'],
        ];

        foreach ($clientesPJ as $email => $roles) {
            $user = User::where('email', $email)->first();
            if ($user) {
                foreach ($roles as $role) {
                    UserRole::firstOrCreate(
                        ['user_id' => $user->id, 'role' => $role],
                        ['ativo' => true]
                    );
                }
            }
        }
    }
}