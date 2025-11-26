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

   <main style="min-height: calc(100vh - 120px); background: white;">
    <div class="full-width-header">
        <div class="container-fluid">
            <div class="p-4 bg-gradient-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-6 fw-bold">Gerenciar Produtos</h1>
                        <p class="lead mb-0 opacity-75">Gerencie todos os produtos do sistema</p>
                    </div>
                    <div class="text-end">
                        <a href="/produtos/adicionar" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:plus" data-width="20" data-height="20"></span>
                            Novo Produto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 py-5" style="background: white;">
        <div class="content-wrapper">
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

            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header bg-light border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0 fw-bold text-dark">
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
                                           value="<?= htmlspecialchars($termoBusca) ?>">
                                    <?php if (!empty($termoBusca)): ?>
                                        <a href="?" class="btn btn-outline-secondary" type="button">
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Produto</th>
                                    <th class="border-0">Descrição</th>
                                    <th class="border-0 text-center">Estoque</th>
                                    <th class="border-0 text-end">Preço</th>
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

                    <?= PaginationService::gerarLinksPaginacao($paginacao) ?>
                </div>
                
                <?php if (!empty($produtosPaginados)): ?>
                    <div class="card-footer bg-light border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Mostrando <?= count($produtosPaginados) ?> de <?= $paginacao['totalItens'] ?> produto(s)
                                <?php if (!empty($termoBusca)): ?>
                                    <span class="badge bg-info ms-2">Filtrado</span>
                                <?php endif; ?>
                            </small>
                            <small class="text-muted">
                                Página <?= $paginacao['paginaAtual'] ?> de <?= $paginacao['totalPaginas'] ?> |
                                Última atualização: <?= date('d/m/Y H:i') ?>
                            </small>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

    <?php
    $this->renderComponent('footer', ['nome_usuario' => $nome_usuario]);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script src="/assets/js/produto.js"></script>
</body>

</html>