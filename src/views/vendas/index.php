<?php
$sucesso = $this->getFlash('sucesso') ?? '';
$erro = $this->getFlash('erro') ?? '';
$msg = $this->getFlash('msg') ?? '';

$historicoVendas = $vendas ?? [];
$produtosDisponiveis = $produtos ?? [];
$totalHoje = $totalHoje ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/venda.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => 'vendas', 'nome_usuario' => $nome_usuario]);
    ?>

    <main class="venda-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Sistema de Vendas</h1>
                        <p class="lead mb-3 opacity-75">Realize vendas e acompanhe o histórico</p>
                    </div>
                    <div class="header-actions">
                        <div class="total-hoje-badge">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            <strong>Total Hoje:</strong>
                            <span class="total-value">R$ <?= number_format($totalHoje, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="venda-layout">
                <div class="venda-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:chart-box" data-width="20" data-height="20"></span>
                                Estatísticas do Dia
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total de Vendas</span>
                                    <span class="fw-semibold"><?= count($historicoVendas) ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Valor Total</span>
                                    <span class="fw-semibold text-success">
                                        R$ <?= number_format($totalHoje, 2, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Ticket Médio</span>
                                    <span class="fw-semibold text-primary">
                                        R$ <?= count($historicoVendas) > 0 ? number_format($totalHoje / count($historicoVendas), 2, ',', '.') : '0,00' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Produtos Vendidos</span>
                                    <span class="fw-semibold text-info">
                                        <?= array_sum(array_map(fn($v) => $v['quantidade'], $historicoVendas)) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:star" data-width="20" data-height="20"></span>
                                Produtos Mais Vendidos
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $produtosVendidos = [];
                            foreach ($historicoVendas as $venda) {
                                $produtoId = $venda['produto_id'];
                                $quantidade = $venda['quantidade'];

                                if (!isset($produtosVendidos[$produtoId])) {
                                    $produtosVendidos[$produtoId] = [
                                        'quantidade_total' => 0,
                                        'produto' => null
                                    ];
                                }
                                $produtosVendidos[$produtoId]['quantidade_total'] += $quantidade;

                                foreach ($produtosDisponiveis as $produto) {
                                    if ($produto['id'] == $produtoId) { 
                                        $produtosVendidos[$produtoId]['produto'] = $produto;
                                        break;
                                    }
                                }
                            }

                            usort($produtosVendidos, function ($a, $b) {
                                return $b['quantidade_total'] - $a['quantidade_total'];
                            });

                            $produtosMaisVendidos = array_slice($produtosVendidos, 0, 3);

                            if (!empty($produtosMaisVendidos)):
                            ?>
                                <?php foreach ($produtosMaisVendidos as $item):
                                    $produto = $item['produto'];
                                    $quantidadeVendida = $item['quantidade_total'];
                                ?>
                                    <?php if ($produto): ?>
                                        <div class="produto-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                            <div class="produto-avatar me-3">
                                                <span class="iconify" data-icon="mdi:package-variant" data-width="24" data-height="24"></span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($produto['nome']) ?></h6>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">Vendidos: <?= $quantidadeVendida ?></small>
                                                    <small class="text-muted">Estoque: <?= $produto['quantidade_estoque'] ?></small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold text-primary">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-muted py-3">
                                    <span class="iconify" data-icon="mdi:package-variant-remove" data-width="32" data-height="32"></span>
                                    <p class="mt-2 mb-0 small">Nenhuma venda registrada hoje</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:rocket-launch" data-width="20" data-height="20"></span>
                                Ações Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="/produtos" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:package-variant" data-width="18" data-height="18"></span>
                                    Gerenciar Produtos
                                </a>
                                <button type="button" class="btn btn-outline-success text-start">
                                    <span class="iconify" data-icon="mdi:chart-bar" data-width="18" data-height="18"></span>
                                    Relatório de Vendas
                                </button>
                                <button type="button" class="btn btn-outline-info text-start">
                                    <span class="iconify" data-icon="mdi:history" data-width="18" data-height="18"></span>
                                    Histórico Completo
                                </button>
                                <button type="button" class="btn btn-outline-warning text-start">
                                    <span class="iconify" data-icon="mdi:cash-refund" data-width="18" data-height="18"></span>
                                    Estornar Venda
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="venda-content">
                    <div class="content-wrapper">
                        <div class="alerts-container mb-4">
                            <?php if ($sucesso): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                                    <?= htmlspecialchars($msg) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if ($erro): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                                    <?= htmlspecialchars($msg) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-xl-8">
                                <div class="card profile-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:cash-register" data-width="20" data-height="20"></span>
                                            Nova Venda
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="/vendas/registrar" id="form-venda">
                                            <div class="row g-4">
                                                <div class="col-12">
                                                    <label for="produto_id" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:package-variant" data-width="16" data-height="16"></span>
                                                        Selecionar Produto *
                                                    </label>
                                                    <select class="form-select select2-produtos" id="produto_id" name="produto_id" required>
                                                        <option value="">Selecione um produto...</option>
                                                        <?php foreach ($produtosDisponiveis as $produto): ?>
                                                            <option value="<?= $produto['encrypted_id'] ?>"
                                                                data-preco="<?= $produto['preco'] ?>"
                                                                data-estoque="<?= $produto['quantidade_estoque'] ?>"
                                                                data-nome="<?= htmlspecialchars($produto['nome']) ?>"
                                                                data-sku="<?= htmlspecialchars($produto['sku']) ?>">
                                                                <?= htmlspecialchars($produto['nome']) ?>
                                                                - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                                                - Estoque: <?= $produto['quantidade_estoque'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="form-text estoque-info mt-2" id="estoque-info">
                                                        <span class="iconify" data-icon="mdi:information" data-width="16" data-height="16"></span>
                                                        Selecione um produto para ver informações detalhadas
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="quantidade" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:numeric" data-width="16" data-height="16"></span>
                                                        Quantidade *
                                                    </label>
                                                    <input type="number" class="form-control form-control-lg" id="quantidade"
                                                        name="quantidade" min="1" value="1" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:cash" data-width="16" data-height="16"></span>
                                                        Preço Unitário
                                                    </label>
                                                    <div class="form-control bg-light py-3 fw-bold text-primary" id="preco-unitario">
                                                        R$ 0,00
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="observacoes" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:text" data-width="16" data-height="16"></span>
                                                        Observações (Opcional)
                                                    </label>
                                                    <textarea class="form-control" id="observacoes" name="observacoes"
                                                        rows="2" placeholder="Observações sobre a venda..."></textarea>
                                                </div>

                                                <div class="col-12">
                                                    <div class="card bg-light border-0">
                                                        <div class="card-body py-3">
                                                            <div class="row align-items-center">
                                                                <div class="col-6">
                                                                    <strong class="fs-5">Total da Venda:</strong>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    <span class="total-display fs-4 fw-bold text-success" id="total-venda">R$ 0,00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold">
                                                        <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                                                        Finalizar Venda
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-4">
                                <?php
                                $this->renderComponent('historico_vendas', [
                                    'vendas' => $historicoVendas,
                                    'titulo' => 'Histórico de Vendas',
                                    'limite' => 10,
                                    'mostrarEstorno' => true
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $this->renderComponent('footer', ['nome_usuario' => $nome_usuario]);
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script src="/assets/js/venda.js"></script>
</body>

</html>