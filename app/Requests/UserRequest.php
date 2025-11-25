<?php
// app/Requests/UserRequest.php

namespace App\Requests;

class UserRequest
{
    private $data;
    private $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty(trim($this->data['nome'] ?? ''))) {
            $this->errors['nome'] = 'Nome completo é obrigatório';
        } elseif (strlen(trim($this->data['nome'])) < 2) {
            $this->errors['nome'] = 'Nome deve ter pelo menos 2 caracteres';
        }

        if (empty(trim($this->data['email'] ?? ''))) {
            $this->errors['email'] = 'E-mail é obrigatório';
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'E-mail inválido';
        }

        if (empty($this->data['senha'] ?? '')) {
            $this->errors['senha'] = 'Senha é obrigatória';
        } elseif (strlen($this->data['senha']) < 6) {
            $this->errors['senha'] = 'Senha deve ter pelo menos 6 caracteres';
        }

        if ($this->data['senha'] !== ($this->data['confirmar_senha'] ?? '')) {
            $this->errors['confirmar_senha'] = 'As senhas não coincidem';
        }

        if (!empty($this->data['telefone'] ?? '')) {
            $telefone = preg_replace('/\D/', '', $this->data['telefone']);
            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $this->errors['telefone'] = 'Telefone inválido';
            }
        }

        if (!empty($this->data['data_nascimento'] ?? '')) {
            $data = \DateTime::createFromFormat('Y-m-d', $this->data['data_nascimento']);
            if (!$data || $data->format('Y-m-d') !== $this->data['data_nascimento']) {
                $this->errors['data_nascimento'] = 'Data de nascimento inválida';
            } else {
                $hoje = new \DateTime();
                $idade = $hoje->diff($data)->y;
                if ($idade < 16) {
                    $this->errors['data_nascimento'] = 'Você deve ter pelo menos 16 anos';
                }
            }
        }

        $tiposPermitidos = ['visualizador', 'vendedor', 'estoque', 'gerente'];
        if (!empty($this->data['tipo_usuario'] ?? '') && !in_array($this->data['tipo_usuario'], $tiposPermitidos)) {
            $this->errors['tipo_usuario'] = 'Tipo de usuário inválido';
        }

        if (empty($this->data['termos'] ?? '')) {
            $this->errors['termos'] = 'Você deve aceitar os termos de uso';
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getValidatedData(): array
    {
        $data = [
            'nome' => trim($this->data['nome']),
            'email' => trim($this->data['email']),
            'senha' => $this->data['senha'],
            'tipo_usuario' => $this->data['tipo_usuario'] ?? 'visualizador'
        ];

        if (!empty($this->data['telefone'] ?? '')) {
            $data['telefone'] = $this->data['telefone'];
        }

        if (!empty($this->data['data_nascimento'] ?? '')) {
            $data['data_nascimento'] = $this->data['data_nascimento'];
        }

        if (!empty($this->data['departamento'] ?? '')) {
            $data['departamento'] = trim($this->data['departamento']);
        }

        return $data;
    }

    public function getOldData(): array
    {
        return [
            'nome' => $this->data['nome'] ?? '',
            'email' => $this->data['email'] ?? '',
            'telefone' => $this->data['telefone'] ?? '',
            'data_nascimento' => $this->data['data_nascimento'] ?? '',
            'tipo_usuario' => $this->data['tipo_usuario'] ?? 'visualizador',
            'departamento' => $this->data['departamento'] ?? ''
        ];
    }
}
?>