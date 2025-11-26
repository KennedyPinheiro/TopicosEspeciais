<?php
$vendas = $vendas ?? [];
$titulo = $titulo ?? 'Histórico de Vendas';
$limite = $limite ?? 10;
$mostrarEstorno = $mostrarEstorno ?? true;

if ($limite > 0 && count($vendas) > $limite) {
    $vendas = array_slice($vendas, 0, $limite);
}
?>

<div class="card border-0 shadow-lg h-100">
    <div class="card-header bg-white border-0 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-bold text-dark">
                <i class="fas fa-history me-2 text-primary"></i>
                <?= htmlspecialchars($titulo) ?>
            </h5>
            <span class="badge bg-primary fs-6">
                <?= count($vendas) ?> vendas
            </span>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($vendas)): ?>
            <div class="text-center text-muted py-5">
                <i class="fas fa-receipt fa-4x mb-3 opacity-50"></i>
                <h5 class="text-muted">Nenhuma venda registrada</h5>
                <p class="text-muted mb-0">As vendas aparecerão aqui automaticamente</p>
            </div>
        <?php else: ?>
            <div class="vendas-list" style="max-height: 600px; overflow-y: auto;">
                <?php foreach ($vendas as $venda): ?>
                    <?php 
                    $isEstornada = $venda->estornada ?? $venda['estornada'] ?? false;
                    $vendaClass = $isEstornada ? 'venda-item estornada' : 'venda-item';
                    ?>
                    <div class="<?= $vendaClass ?> p-3 mb-3 rounded">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-receipt me-2 text-primary"></i>
                                Venda #<?= $venda->id ?? $venda['id'] ?>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?= date('d/m/Y H:i', strtotime($venda->data_venda ?? $venda['data_venda'])) ?>
                            </small>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted">Produto:</small>
                            <p class="mb-1 fw-semibold text-dark">
                                <?= htmlspecialchars($venda->produto_nome ?? $venda['produto_nome'] ?? 'Produto não encontrado') ?>
                            </p>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-6">
                                <small class="text-muted">Quantidade:</small>
                                <p class="mb-1 fw-bold"><?= $venda->quantidade ?? $venda['quantidade'] ?></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Preço Unitário:</small>
                                <p class="mb-1 fw-bold text-primary">
                                    R$ <?= number_format($venda->preco_unitario ?? $venda['preco_unitario'] ?? 0, 2, ',', '.') ?>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-<?= $isEstornada ? 'danger' : 'success' ?> fs-6">
                                <?= $isEstornada ? 'Estornada' : 'Concluída' ?>
                            </span>
                            <strong class="text-success fs-5">
                                R$ <?= number_format($venda->total_venda ?? $venda['total_venda'] ?? 0, 2, ',', '.') ?>
                            </strong>
                        </div>

                        <?php if (!$isEstornada && $mostrarEstorno): ?>
                            <div class="mt-3 text-end">
                                <form method="POST" action="/vendas/estornar/<?= $venda->id ?? $venda['id'] ?>" 
                                      class="d-inline" onsubmit="return confirm('Tem certeza que deseja estornar esta venda?')">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-undo me-1"></i> Estornar Venda
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <small class="text-muted">
                    Mostrando as últimas <?= count($vendas) ?> vendas
                </small>
                <a href="/vendas/relatorio" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-chart-bar me-1"></i> Ver Relatório Completo
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.venda-item {
    border-left: 4px solid #28a745;
    transition: all 0.3s ease;
    background: white;
}
.venda-item.estornada {
    border-left-color: #dc3545;
    background-color: #f8f9fa;
    opacity: 0.8;
}
.venda-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>