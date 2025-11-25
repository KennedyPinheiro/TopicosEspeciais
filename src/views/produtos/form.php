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
    <style>
        :root {
            --primary-dark: #0f172a;
            --primary-medium: #1e293b;
            --primary-light: #334155;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --shadow-dark: 0 4px 12px rgba(2, 6, 23, 0.3);
            --shadow-light: 0 2px 8px rgba(2, 6, 23, 0.15);
        }

        .bg-gradient-dark {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border: none;
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .image-preview-container {
            width: 100%;
            height: 200px;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .image-preview-container:hover {
            border-color: #3b82f6;
        }

        .image-preview-container.has-image {
            border: 2px solid #007bff;
            padding: 0.5rem;
        }

        #image-preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        #placeholder-text {
            text-align: center;
            color: #6c757d;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php 
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]); 
    ?>

    <main style="min-height: calc(100vh - 120px); padding: 20px 30px;">
        <div class="mt-4">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-4 bg-gradient-dark text-white rounded-3 shadow">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-6 fw-bold"><?= $titulo ?></h1>
                                <p class="lead mb-0 opacity-75"><?= $subtitulo ?></p>
                            </div>
                            <div class="text-end">
                                <a href="/produtos" class="btn btn-light btn-lg px-4">
                                    <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
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

                                <?php if ($modo === 'editar' && isset($form_data['id'])): ?>
                                    <input type="hidden" name="id" value="<?= $form_data['id'] ?>">
                                    <input type="hidden" name="imagem_atual" value="<?= $form_data['imagem'] ?? '' ?>">
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nome" class="form-label fw-semibold">Nome do Produto <span class="text-danger">*</span></label>
                                        <input type="text" id="nome" name="nome" class="form-control form-control-lg <?= isset($form_errors['nome']) ? 'is-invalid' : '' ?>"
                                            placeholder="Digite o nome do produto"
                                            value="<?= htmlspecialchars($form_data['nome'] ?? '') ?>"
                                            <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                        <?php if (isset($form_errors['nome'])): ?>
                                            <div class="invalid-feedback"><?= $form_errors['nome'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sku" class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                                        <input type="text" id="sku" name="sku" class="form-control form-control-lg <?= isset($form_errors['sku']) ? 'is-invalid' : '' ?>"
                                            placeholder="Código único do produto"
                                            value="<?= htmlspecialchars($form_data['sku'] ?? '') ?>"
                                            <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                        <?php if (isset($form_errors['sku'])): ?>
                                            <div class="invalid-feedback"><?= $form_errors['sku'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="descricao" class="form-label fw-semibold">Descrição</label>
                                    <textarea id="descricao" name="descricao" class="form-control <?= isset($form_errors['descricao']) ? 'is-invalid' : '' ?>" rows="4"
                                        placeholder="Descreva o produto..."
                                        <?= $modo === 'visualizar' ? 'readonly' : '' ?>><?= htmlspecialchars($form_data['descricao'] ?? '') ?></textarea>
                                    <?php if (isset($form_errors['descricao'])): ?>
                                        <div class="invalid-feedback"><?= $form_errors['descricao'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="preco" class="form-label fw-semibold">Preço <span class="text-danger">*</span></label>
                                        <input type="text" id="preco" name="preco" class="form-control form-control-lg money <?= isset($form_errors['preco']) ? 'is-invalid' : '' ?>"
                                            placeholder="0,00"
                                            value="<?= $modo !== 'visualizar' ? ($form_data['preco'] ?? '') : ($form_data['preco'] ?? '') ?>"
                                            <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                        <?php if (isset($form_errors['preco'])): ?>
                                            <div class="invalid-feedback"><?= $form_errors['preco'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="quantidade" class="form-label fw-semibold">Quantidade <span class="text-danger">*</span></label>
                                        <input type="number" id="quantidade" name="quantidade" class="form-control form-control-lg <?= isset($form_errors['quantidade']) ? 'is-invalid' : '' ?>"
                                            placeholder="0"
                                            value="<?= htmlspecialchars($form_data['quantidade'] ?? '') ?>"
                                            <?= $modo === 'visualizar' ? 'readonly' : 'required' ?> min="0">
                                        <?php if (isset($form_errors['quantidade'])): ?>
                                            <div class="invalid-feedback"><?= $form_errors['quantidade'] ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="categoria" class="form-label fw-semibold">Categoria</label>
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
                                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                        <?php if ($modo === 'editar'): ?>
                                            <a href="/produtos" class="btn btn-outline-secondary btn-lg px-4">Cancelar</a>
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <span class="iconify" data-icon="mdi:check" data-width="20" data-height="20"></span>
                                            <?= $modo === 'editar' ? 'ATUALIZAR' : 'SALVAR PRODUTO' ?>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                        <a href="/produtos" class="btn btn-outline-secondary btn-lg px-4">Voltar</a>
                                        <a href="/produtos/editar/<?= $form_data['id'] ?>" class="btn btn-primary btn-lg px-4">
                                            <span class="iconify" data-icon="mdi:pencil" data-width="20" data-height="20"></span>
                                            Editar Produto
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
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
    </main>

    <?php 
    $this->renderComponent('footer', ['nome_usuario' => $nome_usuario]);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($modo !== 'visualizar'): ?>
                const moneyInputs = document.querySelectorAll('.money');
                moneyInputs.forEach(input => {
                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        value = (value / 100).toFixed(2);
                        e.target.value = 'R$ ' + value.replace('.', ',');
                    });

                    if (input.value && !input.value.includes('R$')) {
                        let value = parseFloat(input.value).toFixed(2);
                        input.value = 'R$ ' + value.replace('.', ',');
                    }
                });

                const imageInput = document.getElementById('image-input');
                const imagePreview = document.getElementById('image-preview');
                const placeholderText = document.getElementById('placeholder-text');
                const container = document.getElementById('image-container');
                const removeBtn = document.getElementById('remove-image');

                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            placeholderText.style.display = 'none';
                            container.classList.add('has-image');
                            removeBtn.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });

                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    imageInput.value = '';
                    imagePreview.style.display = 'none';
                    placeholderText.style.display = 'block';
                    container.classList.remove('has-image');
                    removeBtn.style.display = 'none';
                });

                const form = document.getElementById('form-produto');
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            <?php endif; ?>

            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>