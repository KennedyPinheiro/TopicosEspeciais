<?php
$sucesso = $this->getFlash('sucesso') ?? '';
$erro = $this->getFlash('erro') ?? '';
$msg = $this->getFlash('msg') ?? '';

require_once '/var/www/site2.com/public_html/app/Services/PaginationService.php';

$termoBusca = PaginationService::getTermoBusca();
$paginacao = PaginationService::paginar($produtos, 15, $termoBusca);
$produtosPaginados = $paginacao['dados'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/produto.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]);
    ?>

    <main class="produto-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Gerenciar Produtos</h1>
                        <p class="lead mb-3 opacity-75">Gerencie todos os produtos do sistema</p>
                    </div>
                    <div class="header-actions">
                        <a href="/produtos/adicionar" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:plus" data-width="20" data-height="20"></span>
                            Novo Produto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="produto-layout">
                <div class="produto-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:filter" data-width="20" data-height="20"></span>
                                Filtros
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status do Estoque</label>
                                <select class="form-select">
                                    <option selected>Todos os produtos</option>
                                    <option>Em estoque</option>
                                    <option>Estoque baixo</option>
                                    <option>Sem estoque</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Categoria</label>
                                <select class="form-select">
                                    <option selected>Todas categorias</option>
                                    <option>Eletrônicos</option>
                                    <option>Informática</option>
                                    <option>Móveis</option>
                                    <option>Livros</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Preço</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Mín">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Máx">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary w-100">
                                <span class="iconify" data-icon="mdi:filter-apply" data-width="18" data-height="18"></span>
                                Aplicar Filtros
                            </button>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:chart-box" data-width="20" data-height="20"></span>
                                Estatísticas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total de Produtos</span>
                                    <span class="fw-semibold"><?= $paginacao['totalItens'] ?? 0 ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Em Estoque</span>
                                    <span class="fw-semibold text-success"><?= count(array_filter($produtos ?? [], fn($p) => ($p['quantidade_estoque'] ?? 0) > 0)) ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Sem Estoque</span>
                                    <span class="fw-semibold text-danger"><?= count(array_filter($produtos ?? [], fn($p) => ($p['quantidade_estoque'] ?? 0) <= 0)) ?></span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Valor Total</span>
                                    <span class="fw-semibold text-primary">
                                        R$ <?= number_format(array_sum(array_map(fn($p) => ($p['preco'] ?? 0) * ($p['quantidade_estoque'] ?? 0), $produtos ?? [])), 2, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
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
                                <a href="/produtos/adicionar" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:plus" data-width="18" data-height="18"></span>
                                    Novo Produto
                                </a>
                                <button type="button" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:download" data-width="18" data-height="18"></span>
                                    Exportar Relatório
                                </button>
                                <button type="button" class="btn btn-outline-warning text-start">
                                    <span class="iconify" data-icon="mdi:refresh" data-width="18" data-height="18"></span>
                                    Atualizar Estoque
                                </button>
                                <button type="button" class="btn btn-outline-info text-start">
                                    <span class="iconify" data-icon="mdi:chart-bar" data-width="18" data-height="18"></span>
                                    Relatório de Vendas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produto-content">
                    <div class="content-wrapper">
                        <div class="alerts-container mb-4">
                            <?php if ($sucesso): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php
                                    $mensagensSucesso = [
                                        'produto_adicionado' => '✅ Produto cadastrado com sucesso!',
                                        'produto_editado' => '✅ Produto atualizado com sucesso!',
                                        'produto_excluido' => '✅ Produto excluído com sucesso!'
                                    ];
                                    echo $mensagensSucesso[$sucesso] ?? '✅ Operação realizada com sucesso.';
                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if ($erro): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php
                                    $mensagens = [
                                        'id_nao_informado' => '❌ ID do produto não informado.',
                                        'produto_nao_encontrado' => '❌ Produto não encontrado.',
                                        'erro_exclusao' => '❌ Erro ao excluir o produto.',
                                        'erro_banco_dados' => '❌ Erro no banco de dados: ' . htmlspecialchars($msg),
                                        'sku_existente' => '❌ SKU já existe no sistema.',
                                        'campos_obrigatorios' => '❌ Preencha todos os campos obrigatórios.',
                                        'preco_invalido' => '❌ Preço deve ser maior que zero.',
                                        'quantidade_invalida' => '❌ Quantidade não pode ser negativa.'
                                    ];
                                    echo $mensagens[$erro] ?? '❌ Erro desconhecido.';
                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card profile-card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:package-variant" data-width="24" data-height="24"></span>
                                            Lista de Produtos
                                        </h5>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="GET" action="" class="d-flex">
                                            <div class="input-group">
                                                <input type="text"
                                                    name="busca"
                                                    class="form-control"
                                                    placeholder="Buscar por nome, descrição ou SKU..."
                                                    value="<?= htmlspecialchars($termoBusca) ?>"
                                                    id="campo-busca">
                                                <?php if (!empty($termoBusca)): ?>
                                                    <a href="?" class="btn btn-outline-secondary" type="button" id="limpar-busca">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 ps-4">Produto</th>
                                                <th class="border-0">Descrição</th>
                                                <th class="border-0 text-center">Estoque</th>
                                                <th class="border-0 text-end pe-4">Preço</th>
                                                <th class="border-0 text-center" style="width: 140px;">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($produtosPaginados)): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-5">
                                                        <div class="py-4">
                                                            <span class="iconify" data-icon="mdi:package-variant-remove" data-width="64" data-height="64" style="color: #6c757d;"></span>
                                                            <h5 class="mt-3 text-muted">
                                                                <?= empty($termoBusca) ? 'Nenhum produto cadastrado' : 'Nenhum produto encontrado' ?>
                                                            </h5>
                                                            <p class="text-muted mb-0">
                                                                <?= empty($termoBusca)
                                                                    ? 'Comece adicionando produtos ao sistema.'
                                                                    : 'Tente ajustar os termos da busca.' ?>
                                                            </p>
                                                            <?php if (empty($termoBusca)): ?>
                                                                <a href="/produtos/adicionar" class="btn btn-primary mt-3">
                                                                    <span class="iconify" data-icon="mdi:plus" data-width="18" data-height="18"></span>
                                                                    Adicionar Primeiro Produto
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="?" class="btn btn-outline-primary mt-3">
                                                                    Limpar Busca
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($produtosPaginados as $produto): ?>
                                                    <?php $this->renderComponent('produto', ['produto' => $produto]); ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <?php if (!empty($produtosPaginados)): ?>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Mostrando <?= count($produtosPaginados) ?> de <?= $paginacao['totalItens'] ?> produto(s)
                                            <?php if (!empty($termoBusca)): ?>
                                                <span class="badge bg-info ms-2">Filtrado</span>
                                            <?php endif; ?>
                                        </small>
                                        <small class="text-muted">
                                            Página <?= $paginacao['paginaAtual'] ?> de <?= $paginacao['totalPaginas'] ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($produtosPaginados)): ?>
                            <div class="mt-4">
                                <?= PaginationService::gerarLinksPaginacao($paginacao) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $this->renderComponent('footer', ['nome_usuario' => $nome_usuario]);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="/assets/js/produto.js"></script>
    <script>
        async function confirmarExclusaoSweet(nomeProduto, encryptedId) {
            const result = await Swal.fire({
                title: 'Confirmar Exclusão',
                html: `Tem certeza que deseja excluir o produto <strong>"${nomeProduto}"</strong>?<br>Esta ação não pode ser desfeita.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                document.getElementById(`form-excluir-${encryptedId}`).submit();
            }
        }
    </script>
</body>

</html>