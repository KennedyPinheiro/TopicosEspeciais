<?php

namespace App\Models;

use PDO;

class Venda
{
    private $pdo;
    private $table = 'vendas';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar(array $dados): int
    {
        $sql = "INSERT INTO {$this->table} 
                (produto_id, quantidade, preco_unitario, total_venda, usuario_id, observacoes, data_venda) 
                VALUES (:produto_id, :quantidade, :preco_unitario, :total_venda, :usuario_id, :observacoes, NOW())";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            ':produto_id' => $dados['produto_id'],
            ':quantidade' => $dados['quantidade'],
            ':preco_unitario' => $dados['preco_unitario'],
            ':total_venda' => $dados['total_venda'],
            ':usuario_id' => $dados['usuario_id'] ?? null,
            ':observacoes' => $dados['observacoes'] ?? null
        ]);

        return $this->pdo->lastInsertId();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT v.*, p.nome as produto_nome 
                FROM {$this->table} v 
                JOIN produtos p ON v.produto_id = p.id 
                WHERE v.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

  public function listar(int $limit = 10): array
    {
        try {
            error_log("🎯 VendaModel::listar - Iniciando busca por $limit vendas");
            
            $sql = "SELECT v.*, p.nome as produto_nome, p.sku 
                    FROM {$this->table} v 
                    LEFT JOIN produtos p ON v.produto_id = p.id 
                    ORDER BY v.data_venda DESC 
                    LIMIT ?";
                    
            error_log("📝 SQL: " . $sql);
            error_log("🔢 Limit: $limit");
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("✅ VendaModel::listar - " . count($resultados) . " vendas encontradas");

            if (empty($resultados)) {
                error_log("⚠️ Nenhuma venda encontrada na tabela");
                $count = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}")->fetch(PDO::FETCH_ASSOC);
                error_log("📊 Total de registros na tabela vendas: " . ($count['total'] ?? 0));
            }
            
            return $resultados ?: [];
            
        } catch (\Exception $e) {
            error_log("💥 ERRO VendaModel::listar: " . $e->getMessage());
            error_log("📝 Stack trace: " . $e->getTraceAsString());
            return [];
        }
    }

    public function listarPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "SELECT v.*, p.nome as produto_nome, p.sku 
                FROM {$this->table} v 
                JOIN produtos p ON v.produto_id = p.id 
                WHERE DATE(v.data_venda) BETWEEN ? AND ? 
                ORDER BY v.data_venda DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$dataInicio, $dataFim]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    

     public function totalVendasHoje(): float
    {
        try {
            $sql = "SELECT COALESCE(SUM(total_venda), 0) as total 
                    FROM {$this->table} 
                    WHERE DATE(data_venda) = CURDATE() 
                    AND (estornada IS NULL OR estornada = 0)";
                    
            error_log("📝 SQL totalVendasHoje: " . $sql);
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $total = (float) ($result['total'] ?? 0);
            error_log("💰 VendaModel::totalVendasHoje - Total: $total");
            
            return $total;
            
        } catch (\Exception $e) {
            error_log("💥 ERRO VendaModel::totalVendasHoje: " . $e->getMessage());
            return 0.0;
        }
    }

    public function estornar(int $vendaId, int $usuarioId): bool
    {
        $this->pdo->beginTransaction();

        try {
            $venda = $this->buscarPorId($vendaId);
            if (!$venda || $venda['estornada']) {
                return false;
            }

            $stmt = $this->pdo->prepare("
                UPDATE produtos 
                SET quantidade = quantidade + ? 
                WHERE id = ?
            ");
            $stmt->execute([$venda['quantidade'], $venda['produto_id']]);

            $stmt = $this->pdo->prepare("
                UPDATE {$this->table} 
                SET estornada = 1, usuario_estorno = ?, data_estorno = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$usuarioId, $vendaId]);

            $this->pdo->commit();
            return true;

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function tabelaExiste(): bool
    {
        try {
            $result = $this->pdo->query("SHOW TABLES LIKE '{$this->table}'");
            $existe = $result->rowCount() > 0;
            error_log("🔍 VendaModel::tabelaExiste - Tabela '{$this->table}' existe: " . ($existe ? 'SIM' : 'NÃO'));
            return $existe;
        } catch (\Exception $e) {
            error_log("💥 ERRO VendaModel::tabelaExiste: " . $e->getMessage());
            return false;
        }
    }



    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}