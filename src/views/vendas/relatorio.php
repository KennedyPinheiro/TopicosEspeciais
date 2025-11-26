<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/home.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => 'vendas', 'nome_usuario' => $nome_usuario]);
    ?>

    <main style="min-height: calc(100vh - 120px);">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="p-4 bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-6 fw-bold">Relatórios de Vendas</h1>
                            <p class="lead mb-0 opacity-75">Análise e relatórios detalhados das vendas</p>
                        </div>
                        <div class="text-end">
                            <a href="/vendas" class="btn btn-light btn-lg px-4">
                                <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                                Voltar para Vendas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4 py-5">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:filter" data-width="20" data-height="20"></span>
                                Filtros do Relatório
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="/vendas/relatorio" class="row g-3">
                                <div class="col-md-4">
                                    <label for="data_inicio" class="form-label fw-bold">Data Início</label>
                                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                                           value="<?= $dataInicio ?? date('Y-m-01') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="data_fim" class="form-label fw-bold">Data Fim</label>
                                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                                           value="<?= $dataFim ?? date('Y-m-t') ?>">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <span class="iconify" data-icon="mdi:chart-box" data-width="18" data-height="18"></span>
                                        Gerar Relatório
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($vendas)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:chart-pie" data-width="20" data-height="20"></span>
                                Resumo do Período
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <div class="h2 text-primary fw-bold mb-1">
                                            <?= count($vendas) ?>
                                        </div>
                                        <small class="text-muted">Total de Vendas</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <div class="h2 text-success fw-bold mb-1">
                                            <?= $totalItens ?? 0 ?>
                                        </div>
                                        <small class="text-muted">Itens Vendidos</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <div class="h2 text-warning fw-bold mb-1">
                                            R$ <?= number_format($totalPeriodo ?? 0, 2, ',', '.') ?>
                                        </div>
                                        <small class="text-muted">Faturamento Total</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="h2 text-info fw-bold mb-1">
                                        R$ <?= number_format(($totalPeriodo ?? 0) / max(count($vendas), 1), 2, ',', '.') ?>
                                    </div>
                                    <small class="text-muted">Ticket Médio</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Tabela de Vendas -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:format-list-bulleted" data-width="20" data-height="20"></span>
                                    Detalhes das Vendas
                                </h5>
                                <?php if (!empty($vendas)): ?>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border">
                                        Período: <?= date('d/m/Y', strtotime($dataInicio)) ?> à <?= date('d/m/Y', strtotime($dataFim)) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($vendas)): ?>
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <span class="iconify" data-icon="mdi:chart-box-outline" data-width="80" data-height="80" style="color: #6c757d;"></span>
                                    </div>
                                    <h3 class="text-muted">Nenhuma venda no período</h3>
                                    <p class="text-muted mb-4">Selecione um período diferente ou realize vendas.</p>
                                    <a href="/vendas" class="btn btn-primary">
                                        <span class="iconify" data-icon="mdi:cart" data-width="18" data-height="18"></span>
                                        Ir para Vendas
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0">Data/Hora</th>
                                                <th class="border-0">Produto</th>
                                                <th class="border-0 text-center">Qtd</th>
                                                <th class="border-0 text-end">Unitário</th>
                                                <th class="border-0 text-end">Total</th>
                                                <th class="border-0 text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($vendas as $venda): ?>
                                                <tr>
                                                    <td class="text-dark"><?= date('d/m/Y H:i', strtotime($venda['data_venda'])) ?></td>
                                                    <td class="text-dark fw-medium"><?= htmlspecialchars($venda['produto_nome']) ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary bg-opacity-10 text-primary border">
                                                            <?= $venda['quantidade'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end text-dark">R$ <?= number_format($venda['preco_unitario'], 2, ',', '.') ?></td>
                                                    <td class="text-end fw-bold text-success">R$ <?= number_format($venda['total_venda'], 2, ',', '.') ?></td>
                                                    <td class="text-center">
                                                        <?php if ($venda['estornada'] ?? false): ?>
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border">
                                                                Estornada
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success bg-opacity-10 text-success border">
                                                                Concluída
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Total do Período:</td>
                                                <td class="text-end fw-bold text-dark">
                                                    <?= $totalItens ?? 0 ?> itens
                                                </td>
                                                <td class="text-end fw-bold text-success">
                                                    R$ <?= number_format($totalPeriodo ?? 0, 2, ',', '.') ?>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <small class="text-muted">
                                            Relatório gerado em: <?= date('d/m/Y H:i') ?>
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary">
                                            <span class="iconify" data-icon="mdi:file-pdf" data-width="18" data-height="18"></span>
                                            Exportar PDF
                                        </button>
                                        <button class="btn btn-outline-success">
                                            <span class="iconify" data-icon="mdi:file-excel" data-width="18" data-height="18"></span>
                                            Exportar Excel
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $this->renderComponent('footer');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</body>
</html>