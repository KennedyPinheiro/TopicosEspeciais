<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card product-card border-0 shadow-sm h-100">
        <div class="card-img-container position-relative">
            <?php if (!empty($produto['imagem'])): ?>
                <img src="/<?= htmlspecialchars($produto['imagem']) ?>"
                    class="card-img-top"
                    alt="<?= htmlspecialchars($produto['nome']) ?>"
                    style="height: 200px; object-fit: cover;">
            <?php else: ?>
                <div class="card-img-top bg-gradient-dark d-flex align-items-center justify-content-center"
                    style="height: 200px;">
                    <span class="iconify text-white" data-icon="mdi:package-variant" data-width="48" data-height="48"></span>
                </div>
            <?php endif; ?>

            <div class="position-absolute top-0 end-0 m-2">
                <span class="badge <?= $produto['quantidade'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                    <?= $produto['quantidade'] > 0 ? 'Em estoque' : 'Sem estoque' ?>
                </span>
            </div>
        </div>

        <div class="card-body d-flex flex-column">
            <h5 class="card-title text-truncate" title="<?= htmlspecialchars($produto['nome']) ?>">
                <?= htmlspecialchars($produto['nome']) ?>
            </h5>

            <?php if (!empty($produto['descricao'])): ?>
                <p class="card-text text-muted small flex-grow-1">
                    <?= htmlspecialchars(mb_strimwidth($produto['descricao'], 0, 80, '...')) ?>
                </p>
            <?php endif; ?>

            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-3"> 
                    <span class="h5 mb-0 text-primary fw-bold">
                        R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                    </span>
                    <small class="text-muted">
                        SKU: <?= htmlspecialchars($produto['sku']) ?>
                    </small>
                </div>

                <?php if (!empty($produto['categoria'])): ?>
                    <div class="mb-3">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                            <?= htmlspecialchars($produto['categoria']) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <div class="d-grid gap-2">
                    <a href="/produtos/visualizar?id=<?= $produto['id'] ?>"
                        class="btn btn-outline-primary btn-sm">
                        <span class="iconify" data-icon="mdi:eye-outline" data-width="16" data-height="16"></span>
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>