<?php
namespace App\Models;

use PDO;

class Contact
{
    private $pdo;
    private $table = 'contatos';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} 
                (nome, email, assunto, mensagem, ip, user_agent, created_at) 
                VALUES (:nome, :email, :assunto, :mensagem, :ip, :user_agent, NOW())";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':assunto' => $data['assunto'],
            ':mensagem' => $data['mensagem'],
            ':ip' => $data['ip'],
            ':user_agent' => $data['user_agent']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        return $contact ?: null;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findRecent(int $limit = 10): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
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

    public function markAsRead(int $id): bool
    {
        $sql = "UPDATE {$this->table} SET lido = 1, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }
}
?>