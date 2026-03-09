<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pessoa;

class PessoaSeeder extends Seeder
{
    public function run(): void
    {
        
        $funcionarios = [
            'joao@ivendas.com' => [
                'tipo' => 'FISICA',
                'cpf' => '23456789012',
                'rg' => 'SP7654321',
                'telefone' => '(11) 3333-4444',
                'celular' => '(11) 97777-6666',
                'data_nascimento' => '1990-08-20',
            ],
            'maria@ivendas.com' => [
                'tipo' => 'FISICA',
                'cpf' => '34567890123',
                'rg' => 'RJ9876543',
                'telefone' => '(21) 2222-3333',
                'celular' => '(21) 96666-5555',
                'data_nascimento' => '1985-12-10',
            ],
        ];

        foreach ($funcionarios as $email => $dados) {
            $user = User::where('email', $email)->first();
            if ($user) {
                Pessoa::firstOrCreate(
                    ['user_id' => $user->id],
                    $dados
                );
            }
        }

        $pessoasFisicas = [
            'carlos@email.com' => [
                'tipo' => 'FISICA',
                'cpf' => '45678901234',
                'rg' => 'MG1112223',
                'telefone' => '(31) 4444-5555',
                'celular' => '(31) 95555-4444',
                'data_nascimento' => '1975-03-25',
            ],
            'ana@email.com' => [
                'tipo' => 'FISICA',
                'cpf' => '56789012345',
                'rg' => 'SP4445556',
                'telefone' => '(11) 5555-6666',
                'celular' => '(11) 94444-3333',
                'data_nascimento' => '1988-07-30',
            ],
            'roberto@email.com' => [
                'tipo' => 'FISICA',
                'cpf' => '67890123456',
                'rg' => 'RJ7778889',
                'telefone' => '(21) 6666-7777',
                'celular' => '(21) 93333-2222',
                'data_nascimento' => '1992-11-05',
            ],
        ];

        foreach ($pessoasFisicas as $email => $dados) {
            $user = User::where('email', $email)->first();
            if ($user) {
                Pessoa::firstOrCreate(
                    ['user_id' => $user->id],
                    $dados
                );
            }
        }

        $pessoasJuridicas = [
            'contato@techsolutions.com' => [
                'tipo' => 'JURIDICA',
                'cnpj' => '12345678000195',
                'razao_social' => 'Tech Solutions Tecnologia Ltda',
                'nome_fantasia' => 'Tech Solutions',
                'inscricao_estadual' => '123456789',
                'telefone' => '(11) 7777-8888',
                'celular' => '(11) 92222-1111',
                'responsavel' => 'Fernanda Costa',
                'data_fundacao' => '2010-06-15',
            ],
            'vendas@industriaabc.com' => [
                'tipo' => 'JURIDICA',
                'cnpj' => '23456789000106',
                'razao_social' => 'Indústria ABC de Produtos Ltda',
                'nome_fantasia' => 'Indústria ABC',
                'inscricao_estadual' => '987654321',
                'telefone' => '(19) 8888-9999',
                'celular' => '(19) 91111-0000',
                'responsavel' => 'Ricardo Mendes',
                'data_fundacao' => '2005-09-20',
            ],
            'admin@xyzcomercio.com' => [
                'tipo' => 'JURIDICA',
                'cnpj' => '34567890000117',
                'razao_social' => 'Comércio XYZ Importação e Exportação S/A',
                'nome_fantasia' => 'Comércio XYZ',
                'inscricao_estadual' => '456123789',
                'telefone' => '(21) 9999-0000',
                'celular' => '(21) 90000-9999',
                'responsavel' => 'Patrícia Lima',
                'data_fundacao' => '2015-03-10',
            ],
        ];

        foreach ($pessoasJuridicas as $email => $dados) {
            $user = User::where('email', $email)->first();
            if ($user) {
                Pessoa::firstOrCreate(
                    ['user_id' => $user->id],
                    $dados
                );
            }
        }
    }
}