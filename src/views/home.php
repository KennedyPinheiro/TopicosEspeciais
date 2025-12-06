<?php
require_once '/var/www/site2.com/public_html/app/Services/PaginationService.php';

$produtosDestaque = PaginationService::getProdutosMaisVendidos($produtos, 8);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/home.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]);
    ?>

    <main class="home-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Bem-vindo ao Sistema!</h1>
                        <p class="lead mb-3 opacity-75">Você está logado como: <strong><?php echo htmlspecialchars($nome_usuario); ?></strong></p>
                    </div>
                    <div class="header-actions">
                        <a href="/produtos" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:view-grid" data-width="20" data-height="20"></span>
                            Ver Todos os Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="home-layout">
                <div class="home-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                Resumo do Sistema
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total Produtos</span>
                                    <span class="fw-semibold text-primary"><?php echo $totalProdutos; ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Em Estoque</span>
                                    <span class="fw-semibold text-success"><?php echo $comEstoque; ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Sem Estoque</span>
                                    <span class="fw-semibold text-warning"><?php echo $semEstoque; ?></span>
                                </div>
                            </div>
                            <?php if (!empty($produtosDestaque)): ?>
                                <div class="info-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Produto Mais Caro</span>
                                        <span class="fw-semibold text-danger">
                                            R$ <?= number_format($produtosDestaque[0]['preco'] ?? 0, 2, ',', '.') ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
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
                                <a href="/produtos" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:view-list" data-width="18" data-height="18"></span>
                                    Gerenciar Produtos
                                </a>
                                <a href="/vendas" class="btn btn-outline-success text-start">
                                    <span class="iconify" data-icon="mdi:cash-register" data-width="18" data-height="18"></span>
                                    Realizar Venda
                                </a>
                                <a href="/vendas/relatorio" class="btn btn-outline-info text-start">
                                    <span class="iconify" data-icon="mdi:chart-box" data-width="18" data-height="18"></span>
                                    Relatórios
                                </a>
                                <a href="/perfil" class="btn btn-outline-warning text-start">
                                    <span class="iconify" data-icon="mdi:account" data-width="18" data-height="18"></span>
                                    Meu Perfil
                                </a>
                                <a href="/logout" class="btn btn-outline-danger text-start">
                                    <span class="iconify" data-icon="mdi:logout" data-width="18" data-height="18"></span>
                                    Sair
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:server" data-width="20" data-height="20"></span>
                                Status do Sistema
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="status-item mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Banco de Dados</span>
                                    <span class="badge bg-success">Online</span>
                                </div>
                            </div>
                            <div class="status-item mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Sessão</span>
                                    <span class="badge bg-success">Ativa</span>
                                </div>
                            </div>
                            <div class="status-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Último Acesso</span>
                                    <span class="fw-semibold small"><?= date('H:i') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="home-content">
                    <div class="content-wrapper">

                        <div class="card profile-card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <span class="iconify" data-icon="mdi:star" data-width="20" data-height="20"></span>
                                        Produtos em Destaque
                                    </h5>
                                    <span class="badge bg-warning">
                                        <span class="iconify" data-icon="mdi:crown" data-width="16" data-height="16"></span>
                                        Top 8 Mais Populares
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if (empty($produtosDestaque)): ?>
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <span class="iconify" data-icon="mdi:package-variant-remove" data-width="80" data-height="80" style="color: #6c757d;"></span>
                                        </div>
                                        <h3 class="text-muted">Nenhum produto cadastrado</h3>
                                        <p class="text-muted mb-4">Comece adicionando produtos ao sistema.</p>
                                        <a href="/produtos/adicionar" class="btn btn-primary btn-lg">
                                            <span class="iconify" data-icon="mdi:plus" data-width="20" data-height="20"></span>
                                            Adicionar Primeiro Produto
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="row g-3">
                                        <?php foreach ($produtosDestaque as $produto): ?>
                                            <?php $this->renderComponent('card-produto', ['produto' => $produto]); ?>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if (count($produtos) > 8): ?>
                                        <div class="text-center mt-4">
                                            <a href="/produtos" class="btn btn-outline-primary">
                                                <span class="iconify" data-icon="mdi:arrow-right" data-width="16" data-height="16"></span>
                                                Ver Todos os <?= count($produtos) ?> Produtos
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card profile-card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:chart-box" data-width="20" data-height="20"></span>
                                            Estatísticas do Dia
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <div class="h4 text-primary fw-bold mb-1">
                                                        <?= $estatisticasDia['total_vendas'] ?? 0 ?>
                                                    </div>
                                                    <small class="text-muted">Vendas Hoje</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <div class="h4 text-success fw-bold mb-1">
                                                        R$ <?= number_format($estatisticasDia['faturamento'] ?? 0, 2, ',', '.') ?>
                                                    </div>
                                                    <small class="text-muted">Faturamento</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <div class="h4 text-warning fw-bold mb-1">
                                                        <?= $estatisticasDia['produtos_vendidos'] ?? 0 ?>
                                                    </div>
                                                    <small class="text-muted">Produtos Vendidos</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-top text-center">
                                            <a href="/vendas/relatorio" class="btn btn-sm btn-outline-primary">
                                                <span class="iconify" data-icon="mdi:chart-bar" data-width="16" data-height="16"></span>
                                                Ver Relatório Completo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card profile-card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:alert" data-width="20" data-height="20"></span>
                                            Alertas do Sistema
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($semEstoque > 0): ?>
                                            <div class="alert alert-warning alert-sm mb-2">
                                                <span class="iconify" data-icon="mdi:package-variant-remove" data-width="16" data-height="16"></span>
                                                <strong><?= $semEstoque ?> produto(s)</strong> sem estoque
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-success alert-sm mb-2">
                                                <span class="iconify" data-icon="mdi:check-circle" data-width="16" data-height="16"></span>
                                                Todos os produtos estão em estoque
                                            </div>
                                        <?php endif; ?>

                                        <?php if (count($produtos) == 0): ?>
                                            <div class="alert alert-info alert-sm mb-2">
                                                <span class="iconify" data-icon="mdi:information" data-width="16" data-height="16"></span>
                                                Nenhum produto cadastrado
                                            </div>
                                        <?php endif; ?>

                                        <div class="alert alert-info alert-sm">
                                            <span class="iconify" data-icon="mdi:calendar" data-width="16" data-height="16"></span>
                                            Sistema atualizado em <?= date('d/m/Y') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card profile-card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <span class="iconify" data-icon="mdi:speedometer" data-width="20" data-height="20"></span>
                                    Acesso Rápido
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3 col-6">
                                        <a href="/produtos/adicionar" class="quick-action-card card border-0 text-center p-3">
                                            <div class="quick-action-icon bg-primary mb-2">
                                                <span class="iconify" data-icon="mdi:plus" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-semibold mb-1">Novo Produto</h6>
                                            <small class="text-muted">Cadastrar</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="/vendas" class="quick-action-card card border-0 text-center p-3">
                                            <div class="quick-action-icon bg-success mb-2">
                                                <span class="iconify" data-icon="mdi:cash-register" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-semibold mb-1">Nova Venda</h6>
                                            <small class="text-muted">Registrar</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="/produtos" class="quick-action-card card border-0 text-center p-3">
                                            <div class="quick-action-icon bg-info mb-2">
                                                <span class="iconify" data-icon="mdi:package-variant" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-semibold mb-1">Produtos</h6>
                                            <small class="text-muted">Gerenciar</small>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="/perfil" class="quick-action-card card border-0 text-center p-3">
                                            <div class="quick-action-icon bg-warning mb-2">
                                                <span class="iconify" data-icon="mdi:account" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-semibold mb-1">Perfil</h6>
                                            <small class="text-muted">Configurar</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modais de Venda -->
        <?php foreach ($produtos as $produto): ?>
            <?php if ($produto['quantidade'] > 0): ?>
                <?php $this->renderComponent('modal-venda', ['produto' => $produto]); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <?php $this->renderComponent('footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</body>

</html>