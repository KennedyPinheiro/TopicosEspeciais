<?php

namespace App\Requests;

class ProductRequest
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
            $this->errors['nome'] = 'Nome do produto é obrigatório';
        } elseif (strlen(trim($this->data['nome'])) < 2) {
            $this->errors['nome'] = 'Nome deve ter pelo menos 2 caracteres';
        } elseif (strlen(trim($this->data['nome'])) > 255) {
            $this->errors['nome'] = 'Nome deve ter no máximo 255 caracteres';
        }

        if (empty(trim($this->data['sku'] ?? ''))) {
            $this->errors['sku'] = 'SKU é obrigatório';
        } elseif (strlen(trim($this->data['sku'])) < 2) {
            $this->errors['sku'] = 'SKU deve ter pelo menos 2 caracteres';
        } elseif (strlen(trim($this->data['sku'])) > 50) {
            $this->errors['sku'] = 'SKU deve ter no máximo 50 caracteres';
        } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $this->data['sku'])) {
            $this->errors['sku'] = 'SKU deve conter apenas letras, números, hífens e underscores';
        }

        if (empty($this->data['preco'] ?? '')) {
            $this->errors['preco'] = 'Preço é obrigatório';
        } else {
            $precoNumerico = $this->formatPriceForValidation($this->data['preco']);
            if (!is_numeric($precoNumerico) || $precoNumerico <= 0) {
                $this->errors['preco'] = 'Preço deve ser maior que zero';
            }
        }

        if (!isset($this->data['quantidade']) || $this->data['quantidade'] === '') {
            $this->errors['quantidade'] = 'Quantidade é obrigatória';
        } elseif (!is_numeric($this->data['quantidade']) || $this->data['quantidade'] < 0) {
            $this->errors['quantidade'] = 'Quantidade deve ser um número maior ou igual a zero';
        }

        if (!empty($this->data['categoria']) && strlen(trim($this->data['categoria'])) > 100) {
            $this->errors['categoria'] = 'Categoria deve ter no máximo 100 caracteres';
        }

        if (!empty($this->data['descricao']) && strlen(trim($this->data['descricao'])) > 1000) {
            $this->errors['descricao'] = 'Descrição deve ter no máximo 1000 caracteres';
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
            'sku' => trim($this->data['sku']),
            'descricao' => isset($this->data['descricao']) ? trim($this->data['descricao']) : null,
            'preco' => $this->data['preco'], 
            'quantidade' => (int) $this->data['quantidade'],
            'categoria' => isset($this->data['categoria']) ? trim($this->data['categoria']) : null
        ];
    }

    private function formatPriceForValidation($price)
    {
        if (is_numeric($price)) {
            return floatval($price);
        }
        
        $cleanPrice = str_replace(['R$', ' ', '.'], '', $price);
        $cleanPrice = str_replace(',', '.', $cleanPrice);
        
        return floatval($cleanPrice);
    }
}
?>