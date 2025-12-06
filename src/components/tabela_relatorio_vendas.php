<?php

function TabelaRelatorioVendas($params = [])
{
    $vendas = $params['vendas'] ?? [];
    $dataInicio = $params['dataInicio'] ?? '';
    $dataFim = $params['dataFim'] ?? '';
    $totalPeriodo = $params['totalPeriodo'] ?? 0;
    $totalItens = $params['totalItens'] ?? 0;
    $limite = $params['limite'] ?? 10;

    require_once '/var/www/site2.com/public_html/app/Services/PaginationService.php';
    $paginacao = PaginationService::paginar($vendas, $limite);
    $vendasPaginadas = $paginacao['dados'];

    ob_start();
?>
    <div class="card profile-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <span class="iconify" data-icon="mdi:format-list-bulleted" data-width="20" data-height="20"></span>
                    Detalhes das Vendas
                </h5>
                <?php if (!empty($vendas)): ?>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-primary">
                            Período: <?= date('d/m/Y', strtotime($dataInicio)) ?> à <?= date('d/m/Y', strtotime($dataFim)) ?>
                        </span>
                        <span class="badge bg-secondary">
                            Página <?= $paginacao['paginaAtual'] ?> de <?= $paginacao['totalPaginas'] ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body p-0">
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
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4">Data/Hora</th>
                                <th class="border-0">Produto</th>
                                <th class="border-0 text-center">Qtd</th>
                                <th class="border-0 text-end">Unitário</th>
                                <th class="border-0 text-end pe-4">Total</th>
                                <th class="border-0 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendasPaginadas as $venda): ?>
                                <tr>
                                    <td class="text-dark ps-4">
                                        <small class="text-muted d-block"><?= date('d/m/Y', strtotime($venda['data_venda'])) ?></small>
                                        <small class="text-muted"><?= date('H:i', strtotime($venda['data_venda'])) ?></small>
                                    </td>
                                    <td class="text-dark fw-medium"><?= htmlspecialchars($venda['produto_nome'] ?? 'Produto não encontrado') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border">
                                            <?= $venda['quantidade'] ?>
                                        </span>
                                    </td>
                                    <td class="text-end text-dark">R$ <?= number_format($venda['preco_unitario'], 2, ',', '.') ?></td>
                                    <td class="text-end fw-bold text-success pe-4">R$ <?= number_format($venda['total_venda'], 2, ',', '.') ?></td>
                                    <td class="text-center">
                                        <?php if ($venda['estornada'] ?? false): ?>
                                            <span class="badge bg-secondary">
                                                <span class="iconify" data-icon="mdi:undo" data-width="14" data-height="14"></span>
                                                Estornada
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">
                                                <span class="iconify" data-icon="mdi:check" data-width="14" data-height="14"></span>
                                                Concluída
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="2" class="text-end fw-bold ps-4">Total do Período:</td>
                                <td class="text-center fw-bold text-dark">
                                    <?= $totalItens ?> itens
                                </td>
                                <td></td>
                                <td class="text-end fw-bold text-success pe-4">
                                    R$ <?= number_format($totalPeriodo, 2, ',', '.') ?>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if ($paginacao['totalPaginas'] > 1): ?>
                    <div class="card-footer border-top-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Mostrando <?= count($vendasPaginadas) ?> de <?= $paginacao['totalItens'] ?> vendas
                                </small>
                            </div>
                            <div>
                                <?= PaginationService::gerarLinksPaginacao($paginacao) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <span class="iconify" data-icon="mdi:clock" data-width="16" data-height="16"></span>
                                Relatório gerado em: <?= date('d/m/Y H:i') ?>
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="exportarPDF()">
                                <span class="iconify" data-icon="mdi:file-pdf" data-width="16" data-height="16"></span>
                                PDF
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="exportarExcel()">
                                <span class="iconify" data-icon="mdi:file-excel" data-width="16" data-height="16"></span>
                                Excel
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function exportarPDF() {
            const periodo = '<?= date('d/m/Y', strtotime($dataInicio)) ?> a <?= date('d/m/Y', strtotime($dataFim)) ?>';
            alert(`Exportação para PDF do período ${periodo} em desenvolvimento...`);
        }

        function exportarExcel() {
            const periodo = '<?= date('d/m/Y', strtotime($dataInicio)) ?> a <?= date('d/m/Y', strtotime($dataFim)) ?>';
            alert(`Exportação para Excel do período ${periodo} em desenvolvimento...`);
        }
    </script>

<?php
    return ob_get_clean();
}
