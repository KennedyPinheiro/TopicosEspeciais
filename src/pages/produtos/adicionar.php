<?php
$pageTitle = "Cadastro de Produtos - Sistema IF";
$currentPage = 'produtos';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';

require_once __DIR__ . '/../../config/db.php';

$modo = 'adicionar';
$produto = null;
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $path = $_SERVER['REQUEST_URI'];
            if (strpos($path, 'visualizar') !== false) {
                $modo = 'visualizar';
                $pageTitle = "Visualizar Produto - Sistema IF";
            } else if (strpos($path, 'editar') !== false || strpos($path, 'adicionar') !== false) {
                $modo = 'editar';
                $pageTitle = "Editar Produto - Sistema IF";
            }
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar produto: " . $e->getMessage());
    }
}

$erro = $_GET['erro'] ?? '';
$msg = $_GET['msg'] ?? '';
$sucesso = $_GET['sucesso'] ?? '';
?>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<main style="min-height: calc(100vh - 120px); padding: 20px 30px;">
    <div class="mt-4">
        <!-- Header Moderno -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 bg-gradient-dark text-white rounded-3 shadow">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-6 fw-bold">
                                <?php
                                echo match ($modo) {
                                    'visualizar' => 'Visualizar Produto',
                                    'editar' => 'Editar Produto',
                                    default => 'Cadastrar Produto'
                                };
                                ?>
                            </h1>
                            <p class="lead mb-0 opacity-75">
                                <?php
                                echo match ($modo) {
                                    'visualizar' => 'Visualize os detalhes do produto',
                                    'editar' => 'Edite as informações do produto',
                                    default => 'Adicione um novo produto ao sistema'
                                };
                                ?>
                            </p>
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

        <!-- Mensagens -->
        <?php if ($sucesso): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                $mensagensSucesso = [
                    'produto_adicionado' => '✅ Produto cadastrado com sucesso!',
                    'produto_editado' => '✅ Produto atualizado com sucesso!'
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
                    'erro_banco_dados' => '❌ Erro ao salvar produto: ' . htmlspecialchars($msg)
                ];
                echo $mensagens[$erro] ?? '❌ Erro desconhecido.';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Formulário -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                            Informações do Produto
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo $modo === 'editar' ? '/processa_edicao_produto' : '/processa_produto'; ?>" method="POST" enctype="multipart/form-data" id="form-produto">
                            <?php if ($modo === 'editar' && $produto): ?>
                                <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label fw-semibold">Nome do Produto <span class="text-danger">*</span></label>
                                    <input type="text" id="nome" name="nome" class="form-control form-control-lg"
                                        placeholder="Digite o nome do produto"
                                        value="<?= htmlspecialchars($produto['nome'] ?? $_POST['nome'] ?? '') ?>"
                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sku" class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                                    <input type="text" id="sku" name="sku" class="form-control form-control-lg"
                                        placeholder="Código único do produto"
                                        value="<?= htmlspecialchars($produto['sku'] ?? $_POST['sku'] ?? '') ?>"
                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label fw-semibold">Descrição</label>
                                <textarea id="descricao" name="descricao" class="form-control" rows="4"
                                    placeholder="Descreva o produto..."
                                    <?= $modo === 'visualizar' ? 'readonly' : '' ?>><?= htmlspecialchars($produto['descricao'] ?? $_POST['descricao'] ?? '') ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="preco" class="form-label fw-semibold">Preço <span class="text-danger">*</span></label>
                                    <input type="text" id="preco" name="preco" class="form-control form-control-lg money"
                                        placeholder="0,00"
                                        value="<?= $modo !== 'visualizar' ? htmlspecialchars($produto['preco'] ?? $_POST['preco'] ?? '') : 'R$ ' . number_format($produto['preco'] ?? 0, 2, ',', '.') ?>"
                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?>>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="quantidade" class="form-label fw-semibold">Quantidade <span class="text-danger">*</span></label>
                                    <input type="number" id="quantidade" name="quantidade" class="form-control form-control-lg"
                                        placeholder="0"
                                        value="<?= htmlspecialchars($produto['quantidade'] ?? $_POST['quantidade'] ?? '') ?>"
                                        <?= $modo === 'visualizar' ? 'readonly' : 'required' ?> min="0">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="categoria" class="form-label fw-semibold">Categoria</label>
                                    <input type="text" id="categoria" name="categoria" class="form-control form-control-lg"
                                        placeholder="Ex: Eletrônicos"
                                        value="<?= htmlspecialchars($produto['categoria'] ?? $_POST['categoria'] ?? '') ?>"
                                        <?= $modo === 'visualizar' ? 'readonly' : '' ?>>
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
                                    <a href="/produtos/editar?id=<?= $produto['id'] ?>" class="btn btn-primary btn-lg px-4">
                                        <span class="iconify" data-icon="mdi:pencil" data-width="20" data-height="20"></span>
                                        Editar Produto
                                    </a>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Imagem do Produto -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <span class="iconify" data-icon="mdi:image" data-width="20" data-height="20"></span>
                            Imagem do Produto
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div id="image-container" class="image-preview-container mb-3">
                            <span id="placeholder-text">
                                <span class="iconify" data-icon="mdi:image-area" data-width="48" data-height="48" style="color: #6c757d;"></span>
                                <div class="mt-2 text-muted">Clique para adicionar imagem</div>
                            </span>
                            <img id="image-preview" src="<?= $produto['imagem'] ?? '' ?>" alt="Preview da imagem do produto" style="<?= isset($produto['imagem']) && $produto['imagem'] ? 'display: block;' : 'display: none;' ?>">
                        </div>
                        
                        <div class="w-100 text-center">
                            <?php if ($modo !== 'visualizar'): ?>
                                <input type="file" name="imagem" id="image-input" accept="image/*" class="form-control d-none">
                                <button type="button" class="btn btn-outline-primary btn-lg w-100 mb-2" onclick="document.getElementById('image-input').click()">
                                    <span class="iconify" data-icon="mdi:upload" data-width="18" data-height="18"></span>
                                    Escolher Imagem
                                </button>
                                <button type="button" id="remove-image" class="btn btn-outline-danger btn-lg w-100" style="display: none;">
                                    <span class="iconify" data-icon="mdi:trash-can" data-width="18" data-height="18"></span>
                                    Remover Imagem
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (isset($produto['imagem']) && $produto['imagem']): ?>
                            <div class="mt-3 text-center">
                                <small class="text-muted">Imagem atual do produto</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="/assets/css/image-preview.css">
    <script src="/assets/js/image-preview.js"></script>

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
            <?php endif; ?>

            <?php if (isset($produto['imagem']) && $produto['imagem']): ?>
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('placeholder-text');
                const container = document.getElementById('image-container');
                const removeBtn = document.getElementById('remove-image');

                preview.style.display = 'block';
                placeholder.style.display = 'none';
                container.classList.add('has-image');
                if (removeBtn) removeBtn.style.display = 'block';
            <?php endif; ?>
        });
    </script>
</main>

<style>
.bg-gradient-dark {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    border: none;
}

.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

.card {
    border: 1px solid rgba(0,0,0,0.08);
}

.image-preview-container {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 2rem;
}

.image-preview-container.has-image {
    border: 2px solid #007bff;
    padding: 0.5rem;
}
</style>

<?php
include_once 'src/components/Footer.php';
?>