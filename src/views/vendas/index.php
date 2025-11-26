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
    <link rel="stylesheet" href="/assets/css/home.css">

</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => 'vendas', 'nome_usuario' => $nome_usuario]);
    ?>

    <main style="min-height: calc(100vh - 120px); background: #f8f9fa;">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="p-4 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-6 fw-bold">Sistema de Vendas</h1>
                            <p class="lead mb-0 opacity-75">Realize vendas e acompanhe o histórico</p>
                        </div>
                        <div class="text-end">
                            <div class="bg-light text-dark rounded-pill px-3 py-2">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                <strong>Total Hoje:</strong>
                                <span class="text-success fw-bold">R$ <?= number_format($totalHoje, 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4 py-4">
            <?php if ($sucesso): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($erro): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card card-venda">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="fas fa-cash-register me-2 text-primary"></i>
                                Nova Venda
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/vendas/registrar" id="form-venda">
                                <div class="mb-4">
                                    <label for="produto_id" class="form-label fw-semibold">Selecionar Produto *</label>
                                    <select class="form-select select2-produtos" id="produto_id" name="produto_id" required>
                                        <option value="">Selecione um produto...</option>
                                        <?php foreach ($produtosDisponiveis as $produto): ?>
                                            <option value="<?= $produto->id ?>"
                                                data-preco="<?= $produto->preco ?>"
                                                data-estoque="<?= $produto->quantidade_estoque ?>"
                                                data-nome="<?= htmlspecialchars($produto->nome) ?>"
                                                data-sku="<?= htmlspecialchars($produto->sku) ?>">
                                                <?= htmlspecialchars($produto->nome) ?>
                                                - R$ <?= number_format($produto->preco, 2, ',', '.') ?>
                                                - Estoque: <?= $produto->quantidade_estoque ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text estoque-info mt-2" id="estoque-info">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Selecione um produto para ver informações detalhadas
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="quantidade" class="form-label fw-semibold">Quantidade *</label>
                                        <input type="number" class="form-control form-control-lg" id="quantidade"
                                            name="quantidade" min="1" value="1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Preço Unitário</label>
                                        <div class="form-control bg-light py-3 fw-bold text-primary" id="preco-unitario">
                                            R$ 0,00
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="observacoes" class="form-label fw-semibold">Observações (Opcional)</label>
                                    <textarea class="form-control" id="observacoes" name="observacoes"
                                        rows="2" placeholder="Observações sobre a venda..."></textarea>
                                </div>

                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <strong class="fs-5">Total da Venda:</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <span class="total-display" id="total-venda">R$ 0,00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Finalizar Venda
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
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
    </main>

    <?php
    $this->renderComponent('footer', ['nome_usuario' => $nome_usuario]);
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>

    <script src="/assets/js/venda.js">

    </script>
</body>

</html>