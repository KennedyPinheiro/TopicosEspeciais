<?php

namespace App\Requests;

class VendaRequest
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

        if (empty($this->data['produto_id']) || !is_numeric($this->data['produto_id'])) {
            $this->errors['produto_id'] = 'ID do produto é obrigatório';
        }

        if (empty($this->data['quantidade']) || !is_numeric($this->data['quantidade'])) {
            $this->errors['quantidade'] = 'Quantidade é obrigatória';
        } elseif ($this->data['quantidade'] <= 0) {
            $this->errors['quantidade'] = 'Quantidade deve ser maior que zero';
        }

        if (!empty($this->data['observacoes']) && strlen($this->data['observacoes']) > 500) {
            $this->errors['observacoes'] = 'Observações não podem ter mais de 500 caracteres';
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
            'produto_id' => (int) $this->data['produto_id'],
            'quantidade' => (int) $this->data['quantidade'],
            'observacoes' => $this->data['observacoes'] ?? null
        ];
    }

    public static function createFromGlobals(): self
    {
        return new self($_POST);
    }
}