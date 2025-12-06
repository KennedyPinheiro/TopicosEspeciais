<?php
$erro = $this->getFlash('erro') ?? '';
$msg = $this->getFlash('msg') ?? '';
$sucesso = $this->getFlash('sucesso') ?? '';

$form_data = $this->getFlash('form_data') ?? $produto ?? [];
$form_errors = $this->getFlash('form_errors') ?? [];

$titulo = match ($modo) {
    'visualizar' => 'Visualizar Produto',
    'editar' => 'Editar Produto',
    default => 'Cadastrar Produto'
};

$subtitulo = match ($modo) {
    'visualizar' => 'Visualize os detalhes do produto',
    'editar' => 'Edite as informações do produto',
    default => 'Adicione um novo produto ao sistema'
};
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/form.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]);
    ?>

    <main class="form-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold"><?= $titulo ?></h1>
                        <p class="lead mb-3 opacity-75"><?= $subtitulo ?></p>
                    </div>
                    <div class="header-actions">
                        <a href="/produtos" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="form-layout">
                <div class="form-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                Status do Produto
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Modo</span>
                                    <span class="badge bg-<?= match ($modo) {
                                                                'visualizar' => 'info',
                                                                'editar' => 'warning',
                                                                default => 'success'
                                                            } ?>">
                                        <?= ucfirst($modo) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Data Criação</span>
                                    <span class="fw-semibold"><?= !empty($form_data['data_criacao']) ? date('d/m/Y', strtotime($form_data['data_criacao'])) : date('d/m/Y') ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Última Atualização</span>
                                    <span class="fw-semibold"><?= !empty($form_data['data_atualizacao']) ? date('d/m/Y H:i', strtotime($form_data['data_atualizacao'])) : 'N/A' ?></span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Status</span>
                                    <span class="badge bg-<?= (!empty($form_data['quantidade']) && $form_data['quantidade'] > 0) ? 'success' : 'danger' ?>">
                                        <?= (!empty($form_data['quantidade']) && $form_data['quantidade'] > 0) ? 'Em Estoque' : 'Sem Estoque' ?>
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
                                <a href="/produtos" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:view-list" data-width="18" data-height="18"></span>
                                    Lista de Produtos
                                </a>
                                <?php if ($modo === 'editar' || $modo === 'visualizar'): ?>
                                    <a href="/produtos/adicionar" class="btn btn-outline-success text-start">
                                        <span class="iconify" data-icon="mdi:plus" data-width="18" data-height="18"></span>
                                        Novo Produto
                                    </a>
                                <?php endif; ?>
                                <?php if ($modo === 'visualizar' && isset($produto['encrypted_id'])): ?>
                                    <a href="/produtos/editar?id=<?= $produto['encrypted_id'] ?>" class="btn btn-outline-warning text-start">
                                        <span class="iconify" data-icon="mdi:pencil" data-width="18" data-height="18"></span>
                                        Editar Produto
                                    </a>
                                <?php endif; ?>
                                <button type="button" class="btn btn-outline-info text-start">
                                    <span class="iconify" data-icon="mdi:content-duplicate" data-width="18" data-height="18"></span>
                                    Duplicar Produto
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:package-variant" data-width="20" data-height="20"></span>
                                Informações de Estoque
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Quantidade Atual</span>
                                    <span class="fw-semibold <?= (!empty($form_data['quantidade']) && $form_data['quantidade'] > 0) ? 'text-success' : 'text-danger' ?>">
                                        <?= $form_data['quantidade'] ?? 0 ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Valor Unitário</span>
                                    <span class="fw-semibold text-primary">
                                        R$ <?= !empty($form_data['preco']) ? number_format($form_data['preco'], 2, ',', '.') : '0,00' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Valor Total</span>
                                    <span class="fw-semibold text-success">
                                        R$ <?= !empty($form_data['preco']) && !empty($form_data['quantidade']) ?
                                                number_format($form_data['preco'] * $form_data['quantidade'], 2, ',', '.') : '0,00' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-content">
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
                                        'campos_obrigatorios' => '❌ Preencha todos os campos obrigatórios.',
                                        'preco_invalido' => '❌ Preço deve ser maior que zero.',
                                        'quantidade_invalida' => '❌ Quantidade não pode ser negativa.',
                                        'sku_existente' => '❌ SKU já existe no sistema.',
                                        'erro_banco_dados' => '❌ Erro ao salvar produto.',
                                        'produto_nao_encontrado' => '❌ Produto não encontrado.',
                                        'id_nao_informado' => '❌ ID do produto não informado.',
                                        'metodo_nao_permitido' => '❌ Método não permitido.'
                                    ];
                                    echo $mensagens[$erro] ?? '❌ Erro desconhecido.';
                                    ?>
                                    <?php if ($msg): ?>
                                        <div class="mt-2 small">Detalhes: <?= htmlspecialchars($msg) ?></div>
                                    <?php endif; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-xl-8">
                                <div class="card profile-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                            Informações do Produto
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo $modo === 'editar' ? '/produtos/processar-edicao' : '/produtos/processar'; ?>"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            id="form-produto"
                                            class="needs-validation"
                                            novalidate>

                                            <?php if ($modo === 'editar' && isset($produto['encrypted_id'])): ?>
                                                <input type="hidden" name="encrypted_id" value="<?= $produto['encrypted_id'] ?>">
                                                <input type="hidden" name="imagem_atual" value="<?= $form_data['imagem'] ?? '' ?>">
                                            <?php endif; ?>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="nome" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:tag" data-width="16" data-height="16"></span>
                                                        Nome do Produto <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" id="nome" name="nome" class="form-control form-control-lg <?= isset($form_errors['nome']) ? 'is-invalid' : '' ?>"
                                                        placeholder="Digite o nome do produto"
                                                        value="<?= htmlspecialchars($form_data['nome'] ?? '') ?>"
                                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                                    <?php if (isset($form_errors['nome'])): ?>
                                                        <div class="invalid-feedback"><?= $form_errors['nome'] ?></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="sku" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:barcode" data-width="16" data-height="16"></span>
                                                        SKU <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" id="sku" name="sku" class="form-control form-control-lg <?= isset($form_errors['sku']) ? 'is-invalid' : '' ?>"
                                                        placeholder="Código único do produto"
                                                        value="<?= htmlspecialchars($form_data['sku'] ?? '') ?>"
                                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                                    <?php if (isset($form_errors['sku'])): ?>
                                                        <div class="invalid-feedback"><?= $form_errors['sku'] ?></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-12">
                                                    <label for="descricao" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:text" data-width="16" data-height="16"></span>
                                                        Descrição
                                                    </label>
                                                    <textarea id="descricao" name="descricao" class="form-control <?= isset($form_errors['descricao']) ? 'is-invalid' : '' ?>" rows="4"
                                                        placeholder="Descreva o produto..."
                                                        <?= $modo === 'visualizar' ? 'readonly' : '' ?>><?= htmlspecialchars($form_data['descricao'] ?? '') ?></textarea>
                                                    <?php if (isset($form_errors['descricao'])): ?>
                                                        <div class="invalid-feedback"><?= $form_errors['descricao'] ?></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="preco" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:cash" data-width="16" data-height="16"></span>
                                                        Preço <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" id="preco" name="preco" class="form-control form-control-lg money <?= isset($form_errors['preco']) ? 'is-invalid' : '' ?>"
                                                        placeholder="0,00"
                                                        value="<?= $modo !== 'visualizar' ? ($form_data['preco'] ?? '') : ($form_data['preco'] ?? '') ?>"
                                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                                    <?php if (isset($form_errors['preco'])): ?>
                                                        <div class="invalid-feedback"><?= $form_errors['preco'] ?></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="quantidade" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:package" data-width="16" data-height="16"></span>
                                                        Quantidade <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" id="quantidade" name="quantidade" class="form-control form-control-lg <?= isset($form_errors['quantidade']) ? 'is-invalid' : '' ?>"
                                                        placeholder="0"
                                                        value="<?= htmlspecialchars($form_data['quantidade'] ?? '') ?>"
                                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?> min="0">
                                                    <?php if (isset($form_errors['quantidade'])): ?>
                                                        <div class="invalid-feedback"><?= $form_errors['quantidade'] ?></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="categoria" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:folder" data-width="16" data-height="16"></span>
                                                        Categoria
                                                    </label>
                                                    <input type="text" id="categoria" name="categoria" class="form-control form-control-lg <?= isset($form_errors['categoria']) ? 'is-invalid' : '' ?>"
                                                        placeholder="Ex: Eletrônicos"
                                                        value="<?= htmlspecialchars($form_data['categoria'] ?? '') ?>"
                                                        <?= $modo === 'visualizar' ? 'readonly' : '' ?>>
                                                    <?php if (isset($form_errors['categoria'])): ?>
                                                        <div class="invalid-feedback"><?= $form_errors['categoria'] ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if ($modo !== 'visualizar'): ?>
                                                <div class="d-flex justify-content-end gap-3 pt-4 mt-4 border-top">
                                                    <?php if ($modo === 'editar'): ?>
                                                        <a href="/produtos" class="btn btn-outline-secondary btn-lg px-4">Cancelar</a>
                                                    <?php endif; ?>
                                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                                        <span class="iconify" data-icon="mdi:check" data-width="20" data-height="20"></span>
                                                        <?= $modo === 'editar' ? 'ATUALIZAR' : 'SALVAR PRODUTO' ?>
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <div class="d-flex justify-content-end gap-3 pt-4 mt-4 border-top">
                                                    <a href="/produtos" class="btn btn-outline-secondary btn-lg px-4">Voltar</a>
                                                    <?php if (isset($produto['encrypted_id'])): ?>
                                                        <a href="/produtos/editar?id=<?= $produto['encrypted_id'] ?>" class="btn btn-primary btn-lg px-4">
                                                            <span class="iconify" data-icon="mdi:pencil" data-width="20" data-height="20"></span>
                                                            Editar Produto
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-4">
                                <div class="card profile-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:image" data-width="20" data-height="20"></span>
                                            Imagem do Produto
                                        </h5>
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                                        <div id="image-container"
                                            class="image-preview-container mb-3 <?= !empty($form_data['imagem']) ? 'has-image' : '' ?>"
                                            <?= $modo !== 'visualizar' ? 'onclick="document.getElementById(\'image-input\').click()"' : '' ?>>

                                            <?php if (!empty($form_data['imagem'])): ?>
                                                <img id="image-preview" src="/<?= $form_data['imagem'] ?>" alt="Imagem do produto" style="display: block;">
                                                <span id="placeholder-text" style="display: none;">
                                                    <span class="iconify" data-icon="mdi:image-area" data-width="48" data-height="48" style="color: #6c757d;"></span>
                                                    <div class="mt-2 text-muted">Clique para adicionar imagem</div>
                                                </span>
                                            <?php else: ?>
                                                <span id="placeholder-text">
                                                    <span class="iconify" data-icon="mdi:image-area" data-width="48" data-height="48" style="color: #6c757d;"></span>
                                                    <div class="mt-2 text-muted">
                                                        <?= $modo !== 'visualizar' ? 'Clique para adicionar imagem' : 'Sem imagem' ?>
                                                    </div>
                                                </span>
                                                <img id="image-preview" src="" alt="Preview da imagem do produto" style="display: none;">
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($modo !== 'visualizar'): ?>
                                            <div class="w-100 text-center">
                                                <input type="file" name="imagem" id="image-input" accept="image/*" class="form-control d-none">
                                                <button type="button" class="btn btn-outline-primary btn-lg w-100 mb-2" onclick="document.getElementById('image-input').click()">
                                                    <span class="iconify" data-icon="mdi:upload" data-width="18" data-height="18"></span>
                                                    Escolher Imagem
                                                </button>
                                                <button type="button" id="remove-image" class="btn btn-outline-danger btn-lg w-100" style="<?= !empty($form_data['imagem']) ? 'display: block;' : 'display: none;' ?>">
                                                    <span class="iconify" data-icon="mdi:trash-can" data-width="18" data-height="18"></span>
                                                    Remover Imagem
                                                </button>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($form_data['imagem'])): ?>
                                            <div class="mt-3 text-center">
                                                <small class="text-muted">Imagem atual do produto</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script src="/assets/js/form.js"></script>
</body>

</html>