<?php
namespace App\Requests;

class RegisterRequest
{
    private $data;
    private $errors = [];

    public function __construct($postData)
    {
        $this->data = [
            'nome' => trim($postData['nome'] ?? ''),
            'email' => trim($postData['email'] ?? ''),
            'senha' => $postData['senha'] ?? '',
            'confirmar_senha' => $postData['confirmar_senha'] ?? '',
            'telefone' => isset($postData['telefone']) ? trim($postData['telefone']) : null,
            'data_nascimento' => isset($postData['data_nascimento']) ? trim($postData['data_nascimento']) : null,
            'tipo_usuario' => isset($postData['tipo_usuario']) ? trim($postData['tipo_usuario']) : 'gerente',
            'departamento' => isset($postData['departamento']) ? trim($postData['departamento']) : '',
            'termos' => isset($postData['termos']) && $postData['termos'] === 'on'
        ];
    }

    public function validate()
    {
        $this->errors = [];

        $required_fields = ['nome', 'email', 'senha', 'confirmar_senha'];
        foreach ($required_fields as $field) {
            if (empty($this->data[$field])) {
                $this->errors[$field] = 'Campo obrigatório';
            }
        }
        if (!empty($this->data['nome']) && strlen($this->data['nome']) < 3) {
            $this->errors['nome'] = 'O nome deve ter pelo menos 3 caracteres';
        }

        if (!empty($this->data['email']) && !filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'E-mail inválido';
        }

        if (!empty($this->data['senha']) && strlen($this->data['senha']) < 6) {
            $this->errors['senha'] = 'A senha deve ter pelo menos 6 caracteres';
        }

        if (!empty($this->data['senha']) && !empty($this->data['confirmar_senha']) && 
            $this->data['senha'] !== $this->data['confirmar_senha']) {
            $this->errors['confirmar_senha'] = 'As senhas não coincidem';
        }

        if (!$this->data['termos']) {
            $this->errors['termos'] = 'Você deve aceitar os termos de uso';
        }

        if (!empty($this->data['data_nascimento'])) {
            $data_timestamp = strtotime($this->data['data_nascimento']);
            if (!$data_timestamp) {
                $this->errors['data_nascimento'] = 'Data de nascimento inválida';
            } elseif ($data_timestamp > time()) {
                $this->errors['data_nascimento'] = 'Data de nascimento não pode ser futura';
            }
        }

        $tipos_permitidos = ['gerente', 'vendedor', 'estoque', 'visualizador'];
        if (!in_array($this->data['tipo_usuario'], $tipos_permitidos)) {
            $this->data['tipo_usuario'] = 'visualizador';
        }

        return empty($this->errors);
    }

    public function getValidatedData()
    {
        return [
            'nome' => $this->data['nome'],
            'email' => $this->data['email'],
            'senha' => $this->data['senha'],
            'telefone' => $this->data['telefone'],
            'data_nascimento' => $this->data['data_nascimento'] ?: null,
            'tipo_usuario' => $this->data['tipo_usuario'],
            'departamento' => $this->data['departamento']
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFormData()
    {
        return [
            'nome' => $this->data['nome'],
            'email' => $this->data['email'],
            'telefone' => $this->data['telefone'],
            'data_nascimento' => $this->data['data_nascimento'],
            'tipo_usuario' => $this->data['tipo_usuario'],
            'departamento' => $this->data['departamento']
        ];
    }
}