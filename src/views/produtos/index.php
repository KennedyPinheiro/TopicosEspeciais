<?php
$sucesso = $this->getFlash('sucesso') ?? '';
$erro = $this->getFlash('erro') ?? '';
$msg = $this->getFlash('msg') ?? '';
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
        
        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <span class="iconify" data-icon="mdi:package-variant" data-width="24" data-height="24"></span>
                            Lista de Produtos
                        </h5>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border">
                            <?= count($produtos) ?> produtos
                        </span>
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
                                <?php if (empty($produtos)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <div class="py-4">
                                                <span class="iconify" data-icon="mdi:package-variant-remove" data-width="64" data-height="64" style="color: #6c757d;"></span>
                                                <h5 class="mt-3 text-muted">Nenhum produto cadastrado</h5>
                                                <p class="text-muted mb-0">Comece adicionando produtos ao sistema.</p>
                                                <a href="/produtos/adicionar" class="btn btn-primary mt-3">
                                                    <span class="iconify" data-icon="mdi:plus" data-width="18" data-height="18"></span>
                                                    Adicionar Primeiro Produto
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($produtos as $produto): ?>
                                        <?php $this->renderComponent('produto', ['produto' => $produto]); ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <?php if (!empty($produtos)): ?>
                    <div class="card-footer bg-light border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Mostrando <?= count($produtos) ?> produto(s)
                            </small>
                            <small class="text-muted">
                                Última atualização: <?= date('d/m/Y H:i') ?>
                            </small>
                        </div>
                    </div>
                <?php endif; ?>
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