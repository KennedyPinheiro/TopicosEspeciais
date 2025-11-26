<?php

namespace App\Controllers;

use App\Services\VendaService;

class VendaController extends BaseController
{
    private $vendaService;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->vendaService = new VendaService($pdo);
    }

    public function index()
    {
        $this->requireAuth();

        try {
            error_log("🎯 === INICIANDO VENDACONTROLLER::INDEX ===");

            $tabelaExiste = $this->pdo->query("SHOW TABLES LIKE 'vendas'")->rowCount() > 0;
            error_log("📊 Tabela 'vendas' existe: " . ($tabelaExiste ? 'SIM' : 'NÃO'));

            if ($tabelaExiste) {
                $totalVendas = $this->pdo->query("SELECT COUNT(*) as total FROM vendas")->fetch(\PDO::FETCH_ASSOC);
                error_log("📈 Total de vendas na tabela: " . ($totalVendas['total'] ?? 0));
            }

            error_log("🛍️ Buscando produtos disponíveis...");
            $stmt = $this->pdo->prepare("
                SELECT id, nome, preco, quantidade as quantidade_estoque, sku, descricao 
                FROM produtos 
                WHERE quantidade > 0 
                ORDER BY nome
            ");

            $stmt->execute();
            $produtos = $stmt->fetchAll(\PDO::FETCH_OBJ);

            error_log("✅ Produtos encontrados: " . count($produtos));
            if (!empty($produtos)) {
                error_log("🔍 Primeiro produto: " . print_r($produtos[0], true));
            } else {
                error_log("⚠️ Nenhum produto encontrado com estoque > 0");

                $stmtAll = $this->pdo->query("SELECT COUNT(*) as total FROM produtos");
                $totalProdutos = $stmtAll->fetch(\PDO::FETCH_ASSOC);
                error_log("📊 Total de produtos na tabela: " . ($totalProdutos['total'] ?? 0));
            }

            error_log("📋 Chamando getHistoricoVendas(10)...");
            $vendas = $this->vendaService->getHistoricoVendas(10);
            error_log("🎫 Vendas retornadas do service: " . count($vendas));

            $totalHoje = $this->vendaService->getTotalVendasHoje();
            error_log("💰 Total hoje: " . $totalHoje);

            $this->render('vendas/index', [
                'vendas' => $vendas,
                'produtos' => $produtos,
                'totalHoje' => $totalHoje,
                'currentPage' => 'vendas',
                'pageTitle' => 'Sistema de Vendas'
            ]);
        } catch (\Exception $e) {
            error_log("💥 ERRO NO VENDACONTROLLER::INDEX: " . $e->getMessage());
            error_log("📝 Stack trace: " . $e->getTraceAsString());
            $this->handleError($e, "Erro ao carregar página de vendas");
        }
    }
    public function registrar()
    {
        $this->requireAuth();
        $this->validateMethod('POST');

        try {
            $postData = $this->getPostData();
            $produtoId = (int) ($postData['produto_id'] ?? 0);
            $quantidade = (int) ($postData['quantidade'] ?? 0);
            $observacoes = $postData['observacoes'] ?? null;
            $usuarioId = $_SESSION['usuario_id'] ?? null;

            if ($produtoId <= 0 || $quantidade <= 0) {
                $this->setFlash('erro', 'dados_invalidos');
                $this->setFlash('msg', 'Produto e quantidade são obrigatórios');
                $this->redirect('/vendas');
            }

            $resultado = $this->vendaService->registrarVenda([
                'produto_id' => $produtoId,
                'quantidade' => $quantidade,
                'observacoes' => $observacoes,
                'usuario_id' => $usuarioId
            ]);

            if ($resultado['sucesso']) {
                $this->setFlash('sucesso', 'venda_registrada');
                $this->setFlash(
                    'msg',
                    "Venda registrada: {$resultado['produto']} - " .
                        "Quantidade: {$resultado['quantidade']} - " .
                        "Total: R$ " . number_format($resultado['total'], 2, ',', '.')
                );
            } else {
                $this->setFlash('erro', 'erro_venda');
                $this->setFlash('msg', $resultado['erro']);
            }

            $this->redirect('/vendas');
        } catch (\Exception $e) {
            $this->setFlash('erro', 'erro_venda');
            $this->setFlash('msg', 'Erro interno: ' . $e->getMessage());
            $this->redirect('/vendas');
        }
    }

    public function relatorio()
    {
        $this->requireAuth();

        try {
            $queryParams = $this->getQueryParams();
            $dataInicio = $queryParams['data_inicio'] ?? date('Y-m-01');
            $dataFim = $queryParams['data_fim'] ?? date('Y-m-t');

            $vendas = $this->vendaService->getVendasPorPeriodo($dataInicio, $dataFim);

            $totalPeriodo = array_sum(array_column($vendas, 'total_venda'));
            $totalItens = array_sum(array_column($vendas, 'quantidade'));

            $this->render('vendas/relatorio', [
                'vendas' => $vendas,
                'dataInicio' => $dataInicio,
                'dataFim' => $dataFim,
                'totalPeriodo' => $totalPeriodo,
                'totalItens' => $totalItens
            ]);
        } catch (\Exception $e) {
            $this->handleError($e, "Erro ao gerar relatório de vendas");
        }
    }

    public function apiVendasHoje()
    {
        $this->requireAuth();

        if (!$this->isAjaxRequest()) {
            $this->jsonError('Requisição inválida', 400);
        }

        try {
            $totalHoje = $this->vendaService->getTotalVendasHoje();
            $vendasHoje = $this->vendaService->getVendasPorPeriodo(date('Y-m-d'), date('Y-m-d'));

            $this->jsonSuccess('Dados carregados', [
                'total_hoje' => $totalHoje,
                'total_vendas_hoje' => count($vendasHoje),
                'vendas' => $vendasHoje
            ]);
        } catch (\Exception $e) {
            $this->jsonError('Erro ao carregar dados: ' . $e->getMessage());
        }
    }

    public function estornar($vendaId)
    {
        $this->requireAuth();
        $this->validateMethod('POST');

        try {
            $vendaId = $this->validateId($vendaId);
            $resultado = $this->vendaService->estornarVenda($vendaId, $_SESSION['usuario_id']);

            if ($resultado['sucesso']) {
                $this->setFlash('sucesso', 'venda_estornada');
                $this->setFlash('msg', $resultado['mensagem']);
            } else {
                $this->setFlash('erro', 'erro_estorno');
                $this->setFlash('msg', $resultado['erro']);
            }

            $this->redirect('/vendas');
        } catch (\Exception $e) {
            $this->handleError($e, "Erro ao estornar venda");
        }
    }
}
