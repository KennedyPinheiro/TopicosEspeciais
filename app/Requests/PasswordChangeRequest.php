<?php
namespace App\Requests;

class PasswordChangeRequest
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

        if (empty(trim($this->data['senha_atual'] ?? ''))) {
            $this->errors['senha_atual'] = 'Senha atual é obrigatória';
        }

        if (empty(trim($this->data['nova_senha'] ?? ''))) {
            $this->errors['nova_senha'] = 'Nova senha é obrigatória';
        } elseif (strlen($this->data['nova_senha']) < 6) {
            $this->errors['nova_senha'] = 'Nova senha deve ter pelo menos 6 caracteres';
        }

        if (empty(trim($this->data['confirmar_nova_senha'] ?? ''))) {
            $this->errors['confirmar_nova_senha'] = 'Confirmação da senha é obrigatória';
        } elseif ($this->data['nova_senha'] !== $this->data['confirmar_nova_senha']) {
            $this->errors['confirmar_nova_senha'] = 'As senhas não coincidem';
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getValidatedData(): array
    {
        return [
            'senha_atual' => $this->data['senha_atual'],
            'nova_senha' => $this->data['nova_senha'],
            'confirmar_nova_senha' => $this->data['confirmar_nova_senha']
        ];
    }
}