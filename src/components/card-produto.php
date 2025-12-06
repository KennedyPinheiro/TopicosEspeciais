<?php
?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="card product-card border-0 shadow-sm h-100">
        <div class="card-img-container">
            <?php if (!empty($produto['imagem'])): ?>
                <img src="/<?php echo htmlspecialchars($produto['imagem']); ?>"
                    class="card-img-top"
                    alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                    style="height: 200px; object-fit: cover;">
            <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                    style="height: 200px;">
                    <span class="iconify" data-icon="mdi:package-variant" data-width="60" data-height="60" style="color: #6c757d;"></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-body d-flex flex-column">
            <h5 class="card-title text-dark fw-bold"><?php echo htmlspecialchars($produto['nome']); ?></h5>

            <?php if (!empty($produto['descricao'])): ?>
                <p class="card-text text-muted small flex-grow-1">
                    <?php echo htmlspecialchars(mb_strimwidth($produto['descricao'], 0, 100, '...')); ?>
                </p>
            <?php endif; ?>

            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="h5 text-primary fw-bold mb-0">
                        R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    </span>
                    <span class="badge <?php echo $produto['quantidade'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                        <?php echo $produto['quantidade'] > 0 ? 'Em estoque' : 'Sem estoque'; ?>
                    </span>
                </div>

                <div class="d-flex gap-2">
                    <div class="d-flex gap-2 mt-2">
                        <a href="/produtos/editar?id=<?php echo $produto['encrypted_id']; ?>"
                            class="btn btn-outline-primary btn-sm flex-fill">
                            <span class="iconify" data-icon="mdi:pencil" data-width="16" data-height="16"></span>
                            Editar
                        </a>

                        <?php if ($produto['quantidade'] > 0): ?>
                            <button type="button" class="btn btn-success btn-sm flex-fill"
                                data-bs-toggle="modal" data-bs-target="#vendaModal<?= $produto['encrypted_id'] ?>">
                                <span class="iconify" data-icon="mdi:cart" data-width="16" data-height="16"></span>
                                Vender
                            </button>
                        <?php else: ?>
                            <button class="btn btn-outline-secondary btn-sm flex-fill" disabled>
                                Sem Estoque
                            </button>
                        <?php endif; ?>
                        <form action="/produtos/excluir" method="POST" class="flex-fill">
                            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                <span class="iconify" data-icon="mdi:delete" data-width="16" data-height="16"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
