<!-- Modal de Venda -->
<div class="modal fade" id="vendaModal<?= $produto['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/vendas/registrar" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Produto:</strong></label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($produto['nome']) ?></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Preço Unitário:</strong></label>
                                <p class="form-control-plaintext text-success fw-bold">
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Estoque:</strong></label>
                                <p class="form-control-plaintext">
                                    <?= $produto['quantidade'] ?> unidades
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="quantidade<?= $produto['id'] ?>" class="form-label">Quantidade *</label>
                        <input type="number" class="form-control" id="quantidade<?= $produto['id'] ?>"
                            name="quantidade" min="1" max="<?= $produto['quantidade'] ?>" value="1" required>
                        <div class="form-text">
                            Máximo: <?= $produto['quantidade'] ?> unidades disponíveis
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes<?= $produto['id'] ?>" class="form-label">Observações (Opcional)</label>
                        <textarea class="form-control" id="observacoes<?= $produto['id'] ?>"
                            name="observacoes" rows="2" placeholder="Observações sobre a venda..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-cart-plus me-1"></i>
                        Registrar Venda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>