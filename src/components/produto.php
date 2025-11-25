<?php
// components/produto.php

// Este componente recebe $produto automaticamente do controller
?>
<tr>
    <td>
        <div class="d-flex align-items-center gap-2">
            <?php if (!empty($produto['imagem'])): ?>
                <img src="/<?= htmlspecialchars($produto['imagem']) ?>"
                    alt="<?= htmlspecialchars($produto['nome']) ?>"
                    class="rounded"
                    style="width: 40px; height: 40px; object-fit: cover;">
            <?php else: ?>
                <div class="rounded bg-light d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <span class="iconify" data-icon="mdi:image-off" data-width="20" data-height="20" style="color: #6c757d;"></span>
                </div>
            <?php endif; ?>
            <div>
                <div class="fw-semibold"><?= htmlspecialchars($produto['nome']) ?></div>
                <div class="small text-muted">
                    SKU: <?= htmlspecialchars($produto['sku']) ?>
                    <?php if (!empty($produto['categoria'])): ?>
                        | Categoria: <?= htmlspecialchars($produto['categoria']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="text-truncate" style="max-width: 300px;" title="<?= htmlspecialchars($produto['descricao'] ?? '') ?>">
            <?= htmlspecialchars($produto['descricao'] ?? 'Sem descrição') ?>
        </div>
    </td>

    <td class="text-center">
        <span class="badge <?= $produto['quantidade'] > 0 ? 'bg-success' : 'bg-danger' ?> bg-opacity-10 text-<?= $produto['quantidade'] > 0 ? 'success' : 'danger' ?> px-2 py-1">
            <?= $produto['quantidade'] ?>
        </span>
    </td>

    <td class="text-end fw-semibold">
        R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
    </td>

    <td class="text-center">
        <div class="d-flex gap-2 justify-content-center">
            <a href="/produtos/visualizar?id=<?= $produto['id'] ?>"
                class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px;"
                title="Visualizar">
                <span class="iconify" data-icon="mdi:eye-outline" data-width="16" data-height="16"></span>
            </a>

            <a href="/produtos/editar?id=<?= $produto['id'] ?>"
                class="btn btn-sm btn-outline-primary rounded-circle d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px;"
                title="Editar">
                <span class="iconify" data-icon="mdi:pencil-outline" data-width="16" data-height="16"></span>
            </a>

            <form action="/produtos/excluir" method="POST" class="d-inline">
                <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                <button type="submit"
                    class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;"
                    onclick="return confirm('Tem certeza que deseja excluir o produto \'<?= addslashes($produto['nome']) ?>\'? Esta ação não pode ser desfeita.')"
                    title="Excluir">
                    <span class="iconify" data-icon="mdi:trash-can-outline" data-width="16" data-height="16"></span>
                </button>
            </form>
        </div>
    </td>
</tr>