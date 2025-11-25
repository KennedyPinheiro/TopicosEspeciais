<?php
namespace App\Requests;

class LoginRequest
{
    private $data;
    private $errors = [];

    public function __construct($postData)
    {
        $this->data = [
            'email' => trim($postData['email'] ?? ''),
            'senha' => $postData['senha'] ?? '',
            'lembrar' => isset($postData['lembrar']) && $postData['lembrar'] == 'on'
        ];
    }

    public function validate()
    {
        if (empty($this->data['email'])) {
            $this->errors['email'] = 'E-mail é obrigatório';
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'E-mail inválido';
        }

        if (empty($this->data['senha'])) {
            $this->errors['senha'] = 'Senha é obrigatória';
        }

        return empty($this->errors);
    }

    public function getValidatedData()
    {
        return $this->data;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFormData()
    {
        return $this->data;
    }
}
?>