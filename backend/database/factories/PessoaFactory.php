<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PessoaFactory extends Factory
{
    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['FISICA', 'JURIDICA']);
        
        $dados = [
            'user_id' => User::factory(),
            'tipo' => $tipo,
            'telefone' => $this->faker->phoneNumber(),
            'celular' => $this->faker->phoneNumber(),
        ];

        if ($tipo === 'FISICA') {
            $dados['cpf'] = $this->faker->cpf(false);
            $dados['rg'] = $this->faker->rg(false);
            $dados['data_nascimento'] = $this->faker->date();
        } else {
            $dados['cnpj'] = $this->faker->cnpj(false);
            $dados['razao_social'] = $this->faker->company();
            $dados['nome_fantasia'] = $this->faker->companySuffix();
            $dados['inscricao_estadual'] = $this->faker->numerify('###.###.###.###');
            $dados['data_fundacao'] = $this->faker->date();
            $dados['responsavel'] = $this->faker->name();
        }

        return $dados;
    }
}