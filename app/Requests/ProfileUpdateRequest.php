<?php
namespace App\Requests;

class ProfileUpdateRequest
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
            $this->errors['nome'] = 'Nome é obrigatório';
        } elseif (strlen(trim($this->data['nome'])) < 2) {
            $this->errors['nome'] = 'Nome deve ter pelo menos 2 caracteres';
        }

        if (empty(trim($this->data['email'] ?? ''))) {
            $this->errors['email'] = 'E-mail é obrigatório';
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'E-mail inválido';
        }

        if (!empty($this->data['telefone'])) {
            $telefone = preg_replace('/[^0-9]/', '', $this->data['telefone']);
            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $this->errors['telefone'] = 'Telefone inválido';
            }
        }

        if (!empty($this->data['data_nascimento'])) {
            $data = \DateTime::createFromFormat('Y-m-d', $this->data['data_nascimento']);
            if (!$data || $data->format('Y-m-d') !== $this->data['data_nascimento']) {
                $this->errors['data_nascimento'] = 'Data de nascimento inválida';
            } else {
                $hoje = new \DateTime();
                $idade = $hoje->diff($data)->y;
                if ($idade < 14 || $idade > 120) {
                    $this->errors['data_nascimento'] = 'Data de nascimento deve ser entre 14 e 120 anos';
                }
            }
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
            'nome' => trim($this->data['nome']),
            'email' => trim($this->data['email']),
            'telefone' => $this->data['telefone'] ?? null,
            'data_nascimento' => !empty($this->data['data_nascimento']) ? $this->data['data_nascimento'] : null
        ];
    }

    public function getFormData(): array
    {
        return $this->data;
    }
}