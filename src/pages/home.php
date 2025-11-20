<?php
$pageTitle = "Home - Sistema IF";
$currentPage = 'home';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
include_once 'src/config/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC LIMIT 12");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao buscar produtos: " . $e->getMessage());
    $produtos = [];
}
?>

<main style="min-height: calc(100vh - 120px);">
    <div class="full-width-header">
        <div class="container-fluid">
            <div class="p-4 bg-gradient-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-6 fw-bold">Bem-vindo ao Sistema!</h1>
                        <p class="lead mb-0 opacity-75">Você está logado como: <strong><?php echo htmlspecialchars($nome_usuario); ?></strong></p>
                    </div>
                    <div class="text-end">
                        <a href="/produtos" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:view-grid" data-width="20" data-height="20"></span>
                            Ver Todos os Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 py-5">
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0 fw-bold text-dark">Produtos em Destaque</h2>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary fs-6 border">
                        <?= count($produtos) ?> produtos
                    </span>
                </div>
                
                <?php if (empty($produtos)): ?>
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
                    <div class="row g-4">
                        <?php foreach ($produtos as $produto): ?>
                            <?php include 'src/components/card-produto.php'; ?>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($produtos) >= 12): ?>
                        <div class="text-center mt-5">
                            <a href="/produtos" class="btn btn-outline-primary btn-lg">
                                <span class="iconify" data-icon="mdi:arrow-right" data-width="16" data-height="16"></span>
                                Ver Todos os Produtos
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xxl-10 col-12">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                    Informações do Sistema
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="border-end">
                                            <div class="h3 text-primary fw-bold mb-1">
                                                <?php
                                                try {
                                                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produtos");
                                                    $total = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    echo $total['total'];
                                                } catch (PDOException $e) {
                                                    echo '0';
                                                }
                                                ?>
                                            </div>
                                            <small class="text-muted">Total Produtos</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border-end">
                                            <div class="h3 text-success fw-bold mb-1">
                                                <?php
                                                try {
                                                    $stmt = $pdo->query("SELECT COUNT(*) as estoque FROM produtos WHERE quantidade > 0");
                                                    $estoque = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    echo $estoque['estoque'];
                                                } catch (PDOException $e) {
                                                    echo '0';
                                                }
                                                ?>
                                            </div>
                                            <small class="text-muted">Em Estoque</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="h3 text-warning fw-bold mb-1">
                                            <?php
                                            try {
                                                $stmt = $pdo->query("SELECT COUNT(*) as sem_estoque FROM produtos WHERE quantidade = 0");
                                                $sem_estoque = $stmt->fetch(PDO::FETCH_ASSOC);
                                                echo $sem_estoque['sem_estoque'];
                                            } catch (PDOException $e) {
                                                echo '0';
                                            }
                                            ?>
                                        </div>
                                        <small class="text-muted">Sem Estoque</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:rocket-launch" data-width="20" data-height="20"></span>
                                    Ações Rápidas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-3">
                                    <a href="/produtos/adicionar" class="btn btn-primary py-3">
                                        <span class="iconify" data-icon="mdi:plus" data-width="18" data-height="18"></span>
                                        Adicionar Novo Produto
                                    </a>
                                    <a href="/produtos" class="btn btn-outline-primary py-3">
                                        <span class="iconify" data-icon="mdi:view-list" data-width="18" data-height="18"></span>
                                        Gerenciar Produtos
                                    </a>
                                    <a href="/logout" class="btn btn-outline-danger py-3">
                                        <span class="iconify" data-icon="mdi:logout" data-width="18" data-height="18"></span>
                                        Sair do Sistema
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    /* Header com largura total */
    .full-width-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
        margin-bottom: 2rem;
    }

    .full-width-header .container-fluid {
        padding: 0;
    }

    .full-width-header .bg-gradient-primary {
        background: transparent !important;
        border-radius: 0 !important;
    }

    /* Gradiente consistente */
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%) !important;
        border: none;
    }

    /* Cards de produtos */
    .product-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .card-img-container {
        overflow: hidden;
        border-radius: 8px 8px 0 0;
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .bg-gradient-dark {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border: none;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    }

    @media (min-width: 1400px) {
        .container-fluid.px-4 {
            padding-left: 3rem !important;
            padding-right: 3rem !important;
        }
    }

    @media (min-width: 1200px) {
        .container-fluid.px-4 {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }
    }
</style>

<?php
include_once 'src/components/Footer.php';
?>