<?php

namespace App\Requests;

class ProductRequest
{
    private $data;
    private $errors = [];
    private $modo;

    public function __construct(array $data, string $modo = 'cadastro')
    {
        $this->data = $data;
        $this->modo = $modo;
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty(trim($this->data['nome'] ?? ''))) {
            $this->errors['nome'] = 'Nome do produto é obrigatório';
        } elseif (strlen(trim($this->data['nome'])) < 2) {
            $this->errors['nome'] = 'Nome deve ter pelo menos 2 caracteres';
        }

        if (empty(trim($this->data['sku'] ?? ''))) {
            $this->errors['sku'] = 'SKU é obrigatório';
        } elseif (strlen(trim($this->data['sku'])) < 2) {
            $this->errors['sku'] = 'SKU deve ter pelo menos 2 caracteres';
        }

        if (empty($this->data['preco'] ?? '')) {
            $this->errors['preco'] = 'Preço é obrigatório';
        } else {
            $preco = $this->formatPrice($this->data['preco']);
            if ($preco <= 0) {
                $this->errors['preco'] = 'Preço deve ser maior que zero';
            }
        }

        if (!isset($this->data['quantidade']) || $this->data['quantidade'] === '') {
            $this->errors['quantidade'] = 'Quantidade é obrigatória';
        } else {
            $quantidade = (int) $this->data['quantidade'];
            if ($quantidade < 0) {
                $this->errors['quantidade'] = 'Quantidade não pode ser negativa';
            }
        }

        if (!empty($this->data['descricao'] ?? '') && strlen($this->data['descricao']) > 1000) {
            $this->errors['descricao'] = 'Descrição deve ter no máximo 1000 caracteres';
        }

        if (!empty($this->data['categoria'] ?? '') && strlen($this->data['categoria']) > 100) {
            $this->errors['categoria'] = 'Categoria deve ter no máximo 100 caracteres';
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
            'sku' => trim($this->data['sku']),
            'preco' => $this->data['preco'],
            'quantidade' => (int) $this->data['quantidade']
        ];

        if (!empty($this->data['descricao'] ?? '')) {
            $data['descricao'] = trim($this->data['descricao']);
        }

        if (!empty($this->data['categoria'] ?? '')) {
            $data['categoria'] = trim($this->data['categoria']);
        }

        if (isset($this->data['imagem']) && $this->data['imagem'] !== '') {
            $data['imagem'] = $this->data['imagem'];
        }

        return $data;
    }

    public function getOldData(): array
    {
        return [
            'nome' => $this->data['nome'] ?? '',
            'sku' => $this->data['sku'] ?? '',
            'descricao' => $this->data['descricao'] ?? '',
            'preco' => $this->data['preco'] ?? '',
            'quantidade' => $this->data['quantidade'] ?? '',
            'categoria' => $this->data['categoria'] ?? '',
            'imagem' => $this->data['imagem'] ?? ($this->data['imagem_atual'] ?? '')
        ];
    }

    private function formatPrice($price): float
    {
        if (is_string($price)) {            $price = str_replace(['R$', ' ', '.'], '', $price);
            $price = str_replace(',', '.', $price);
        }
        
        return (float) $price;
    }
}
?>