<?php

namespace App\Models;

use PDO;

class Product
{
    private $pdo;
    private $table = 'produtos';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (nome, sku, descricao, preco, quantidade, categoria, imagem, created_at) 
                VALUES (:nome, :sku, :descricao, :preco, :quantidade, :categoria, :imagem, NOW())";

        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':nome' => $data['nome'],
            ':sku' => $data['sku'],
            ':descricao' => $data['descricao'] ?? null,
            ':preco' => $this->formatPrice($data['preco']),
            ':quantidade' => $data['quantidade'],
            ':categoria' => $data['categoria'] ?? null,
            ':imagem' => $data['imagem'] ?? null
        ]);
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

     public function getAll($limit = null): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }

    public function getCountWithStock(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE quantidade > 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }

    public function getCountWithoutStock(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE quantidade = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function findBySku(string $sku, ?int $excludeId = null): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE sku = :sku";
        $params = [':sku' => $sku];

        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
            $params[':exclude_id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id];

        $allowedFields = ['nome', 'sku', 'descricao', 'preco', 'quantidade', 'categoria', 'imagem'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                if ($field === 'preco') {
                    $params[":{$field}"] = $this->formatPrice($data[$field]);
                } else {
                    $params[":{$field}"] = $data[$field];
                }
            }
        }

        $fields[] = "updated_at = NOW()";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }

    public function skuExists(string $sku, ?int $excludeId = null): bool
    {
        $product = $this->findBySku($sku, $excludeId);
        return $product !== null;
    }

    private function formatPrice($price): float
    {
        if (is_string($price)) {
            $price = str_replace(['R$', ' ', '.'], '', $price);
            $price = str_replace(',', '.', $price);
        }
        
        return (float) $price;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
?>