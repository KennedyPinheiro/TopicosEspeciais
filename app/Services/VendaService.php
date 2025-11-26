<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Venda;

class VendaService
{
    private $vendaModel;
    private $produtoModel;

    public function __construct(\PDO $pdo)
    {
        $this->vendaModel = new Venda($pdo);
        $this->produtoModel = new Product($pdo);
    }

     public function getHistoricoVendas(int $limit = 10): array
    {
        try {
            error_log("🔍 VendaService::getHistoricoVendas - Buscando $limit vendas");
            
            $tabelaExiste = $this->vendaModel->tabelaExiste();
            error_log("📊 Tabela existe no service: " . ($tabelaExiste ? 'SIM' : 'NÃO'));
            
            if (!$tabelaExiste) {
                error_log("❌ Tabela 'vendas' não existe no service");
                return [];
            }
            error_log("📋 Chamando vendaModel->listar($limit)...");
            $vendas = $this->vendaModel->listar($limit);
            error_log("✅ Vendas encontradas no model: " . count($vendas));
            if (!empty($vendas)) {
                error_log("🔍 Primeira venda do model: " . print_r($vendas[0], true));
            }
            return $vendas;
            
        } catch (\Exception $e) {
            error_log("💥 ERRO VendaService::getHistoricoVendas: " . $e->getMessage());
            error_log("📝 Stack trace: " . $e->getTraceAsString());
            return [];
        }
    }

    public function getTotalVendasHoje(): float
    {
        try {
            if (!$this->vendaModel->tabelaExiste()) {
                return 0.0;
            }

            return $this->vendaModel->totalVendasHoje();
            
        } catch (\Exception $e) {
            error_log("ERRO ao calcular total de vendas: " . $e->getMessage());
            return 0.0;
        }
    }

    public function getVendasPorPeriodo(string $dataInicio, string $dataFim): array
    {
        try {
            if (!$this->vendaModel->tabelaExiste()) {
                return [];
            }

            return $this->vendaModel->listarPorPeriodo($dataInicio, $dataFim);
            
        } catch (\Exception $e) {
            error_log("ERRO ao buscar vendas por período: " . $e->getMessage());
            return [];
        }
    }

    public function registrarVenda(array $dadosVenda): array
    {
        try {
            error_log("Registrando venda: " . print_r($dadosVenda, true));
            
            if (!$this->vendaModel->tabelaExiste()) {
                return ['sucesso' => false, 'erro' => 'Sistema de vendas não configurado'];
            }

            $produto = $this->produtoModel->findById($dadosVenda['produto_id']);
            if (!$produto) {
                return ['sucesso' => false, 'erro' => 'Produto não encontrado'];
            }

            if ($produto['quantidade'] < $dadosVenda['quantidade']) {
                return [
                    'sucesso' => false, 
                    'erro' => 'Estoque insuficiente. Disponível: ' . $produto['quantidade']
                ];
            }

            $precoUnitario = (float) $produto['preco'];
            $totalVenda = $precoUnitario * $dadosVenda['quantidade'];

            $dadosCompletos = [
                'produto_id' => $dadosVenda['produto_id'],
                'quantidade' => $dadosVenda['quantidade'],
                'preco_unitario' => $precoUnitario,
                'total_venda' => $totalVenda,
                'usuario_id' => $dadosVenda['usuario_id'] ?? null,
                'observacoes' => $dadosVenda['observacoes'] ?? null
            ];

            $this->vendaModel->getPdo()->beginTransaction();

            try {
                $vendaId = $this->vendaModel->criar($dadosCompletos);

                $novaQuantidade = $produto['quantidade'] - $dadosVenda['quantidade'];
                $this->produtoModel->update($dadosVenda['produto_id'], [
                    'quantidade' => $novaQuantidade
                ]);

                $this->vendaModel->getPdo()->commit();

                error_log("Venda registrada com sucesso - ID: " . $vendaId);

                return [
                    'sucesso' => true,
                    'venda_id' => $vendaId,
                    'produto' => $produto['nome'],
                    'quantidade' => $dadosVenda['quantidade'],
                    'total' => $totalVenda
                ];

            } catch (\Exception $e) {
                $this->vendaModel->getPdo()->rollBack();
                error_log("ERRO na transação: " . $e->getMessage());
                throw $e;
            }

        } catch (\PDOException $e) {
            error_log("ERRO PDO: " . $e->getMessage());
            return ['sucesso' => false, 'erro' => 'Erro de banco de dados: ' . $e->getMessage()];
        } catch (\Exception $e) {
            error_log("ERRO geral: " . $e->getMessage());
            return ['sucesso' => false, 'erro' => 'Erro ao registrar venda: ' . $e->getMessage()];
        }
    }

    public function estornarVenda(int $vendaId, ?int $usuarioId = null): array
    {
        try {
            error_log("Estornando venda ID: " . $vendaId);
            
            if (!$this->vendaModel->tabelaExiste()) {
                return ['sucesso' => false, 'erro' => 'Sistema de vendas não configurado'];
            }

            $sucesso = $this->vendaModel->estornar($vendaId, $usuarioId ?? 0);
            
            if ($sucesso) {
                error_log("Venda estornada com sucesso - ID: " . $vendaId);
                return [
                    'sucesso' => true,
                    'mensagem' => 'Venda estornada com sucesso. Estoque restaurado.'
                ];
            } else {
                return ['sucesso' => false, 'erro' => 'Venda não encontrada ou já estornada'];
            }

        } catch (\Exception $e) {
            error_log("ERRO ao estornar venda: " . $e->getMessage());
            return ['sucesso' => false, 'erro' => 'Erro ao estornar venda: ' . $e->getMessage()];
        }
    }
}