<?php
namespace App\Requests;

class ContactRequest
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
        } elseif (strlen(trim($this->data['nome'])) > 100) {
            $this->errors['nome'] = 'Nome deve ter no máximo 100 caracteres';
        }

        if (empty(trim($this->data['email'] ?? ''))) {
            $this->errors['email'] = 'E-mail é obrigatório';
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'E-mail inválido';
        } elseif (strlen(trim($this->data['email'])) > 150) {
            $this->errors['email'] = 'E-mail deve ter no máximo 150 caracteres';
        }

        if (empty(trim($this->data['assunto'] ?? ''))) {
            $this->errors['assunto'] = 'Assunto é obrigatório';
        } elseif (strlen(trim($this->data['assunto'])) < 5) {
            $this->errors['assunto'] = 'Assunto deve ter pelo menos 5 caracteres';
        } elseif (strlen(trim($this->data['assunto'])) > 200) {
            $this->errors['assunto'] = 'Assunto deve ter no máximo 200 caracteres';
        }

        if (empty(trim($this->data['mensagem'] ?? ''))) {
            $this->errors['mensagem'] = 'Mensagem é obrigatória';
        } elseif (strlen(trim($this->data['mensagem'])) < 10) {
            $this->errors['mensagem'] = 'Mensagem deve ter pelo menos 10 caracteres';
        } elseif (strlen(trim($this->data['mensagem'])) > 2000) {
            $this->errors['mensagem'] = 'Mensagem deve ter no máximo 2000 caracteres';
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
            'assunto' => trim($this->data['assunto']),
            'mensagem' => trim($this->data['mensagem']),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'N/A',
            'data_envio' => date('Y-m-d H:i:s'),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'N/A'
        ];
    }

    public function getFormData(): array
    {
        return [
            'nome' => $this->data['nome'] ?? '',
            'email' => $this->data['email'] ?? '',
            'assunto' => $this->data['assunto'] ?? '',
            'mensagem' => $this->data['mensagem'] ?? ''
        ];
    }
}
?>