<?php

namespace App\Models;

use PDO;

class User
{
    private $pdo;
    private $table = 'usuarios';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): int|false
    {
        $sql = "INSERT INTO {$this->table} 
                (nome, email, telefone, data_nascimento, senha, tipo_usuario, departamento, created_at) 
                VALUES (:nome, :email, :telefone, :data_nascimento, :senha, :tipo_usuario, :departamento, NOW())";

        $stmt = $this->pdo->prepare($sql);

        $result = $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':telefone' => $data['telefone'] ?? null,
            ':data_nascimento' => $data['data_nascimento'] ?? null,
            ':senha' => password_hash($data['senha'], PASSWORD_DEFAULT),
            ':tipo_usuario' => $data['tipo_usuario'] ?? 'visualizador',
            ':departamento' => $data['departamento'] ?? null
        ]);

        if ($result) {
            return (int) $this->pdo->lastInsertId();
        }

        return false;
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT id, nome, email, telefone, data_nascimento, tipo_usuario, departamento, created_at 
                FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
    public function findByIdOrEmail(?int $id = null, ?string $email = null): ?array
    {
        if ($id) {
            return $this->findById($id);
        } elseif ($email) {
            return $this->findByEmail($email);
        }
        return null;
    }
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        $params = [':email' => $email];

        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
            $params[':exclude_id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id];

        $allowedFields = ['nome', 'email', 'telefone', 'data_nascimento', 'tipo_usuario', 'departamento'];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }

        if (isset($data['senha']) && !empty($data['senha'])) {
            $fields[] = "senha = :senha";
            $params[':senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }

        $fields[] = "updated_at = NOW()";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($params);
    }
    public function updateProfile(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET 
                nome = :nome, 
                email = :email, 
                telefone = :telefone, 
                data_nascimento = :data_nascimento,
                updated_at = NOW() 
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':telefone' => $data['telefone'] ?? null,
            ':data_nascimento' => $data['data_nascimento'] ?? null,
            ':id' => $id
        ]);
    }
    public function updatePassword(int $id, string $novaSenha): bool
    {
        $sql = "UPDATE {$this->table} SET 
                senha = :senha,
                updated_at = NOW() 
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':senha' => password_hash($novaSenha, PASSWORD_DEFAULT),
            ':id' => $id
        ]);
    }
     public function getUserStats(int $userId): array
    {
        return [
            'total_produtos' => 0,
            'produtos_ativos' => 0,
            'ultimo_acesso' => date('Y-m-d H:i:s')
        ];
    }
    

}
