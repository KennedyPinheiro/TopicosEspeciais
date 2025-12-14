<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pessoa;
use App\Models\Endereco;

class EnderecoSeeder extends Seeder
{
    public function run(): void
    {
        $enderecos = [
            'admin@ivendas.com' => [
                'logradouro' => 'Rua Principal',
                'numero' => '123',
                'bairro' => 'Centro',
                'cep' => '30130000',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'complemento' => 'Sala 101',
            ],
            'carlos@email.com' => [
                'logradouro' => 'Av. Paulista',
                'numero' => '1000',
                'bairro' => 'Bela Vista',
                'cep' => '01310000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'complemento' => 'Apto 502',
            ],
            'ana@email.com' => [
                'logradouro' => 'Rua das Flores',
                'numero' => '45',
                'bairro' => 'Jardim Botânico',
                'cep' => '22460032',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
            ],
            'contato@techsolutions.com' => [
                'logradouro' => 'Av. Brigadeiro Faria Lima',
                'numero' => '3500',
                'bairro' => 'Itaim Bibi',
                'cep' => '04538000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'complemento' => '10º andar',
            ],
            'vendas@industriaabc.com' => [
                'logradouro' => 'Rodovia Anhanguera',
                'numero' => 'KM 10',
                'bairro' => 'Distrito Industrial',
                'cep' => '13000000',
                'cidade' => 'Campinas',
                'estado' => 'SP',
            ],
        ];

        foreach ($enderecos as $email => $endereco) {
            $user = User::where('email', $email)->first();
            if ($user) {
                Endereco::firstOrCreate(
                    [
                        'enderecavel_id' => $user->id,
                        'enderecavel_type' => User::class,
                    ],
                    $endereco
                );
                $pessoa = $user->pessoa;
                if ($pessoa) {
                    Endereco::firstOrCreate(
                        [
                            'enderecavel_id' => $pessoa->id,
                            'enderecavel_type' => Pessoa::class,
                        ],
                        $endereco
                    );
                }
            }
        }
    }
}