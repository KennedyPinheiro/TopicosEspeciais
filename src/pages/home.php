<?php
$pageTitle = "Home - Sistema IF";
$currentPage = 'home';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
?>

<main style="min-height: calc(100vh - 120px); padding: 20px 0;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 bg-primary text-white rounded-3">
                    <h1 class="display-6">Bem-vindo ao Sistema!</h1>
                    <p class="lead mb-0">Você está logado como: <strong><?php echo htmlspecialchars($nome_usuario); ?></strong></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Informações de Sessão</h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded small">
                            <strong>Cookie nome_usuario:</strong> 
                            <?php echo isset($_COOKIE['nome_usuario']) ? htmlspecialchars($_COOKIE['nome_usuario']) : 'NÃO DEFINIDO'; ?>
                            <br><br>
                            <strong>SESSION usuario_nome:</strong> 
                            <?php echo isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'NÃO DEFINIDO'; ?>
                            <br><br>
                            <strong>SESSION usuario_id:</strong> 
                            <?php echo isset($_SESSION['usuario_id']) ? htmlspecialchars($_SESSION['usuario_id']) : 'NÃO DEFINIDO'; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Ações Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="/produtos" class="btn btn-primary btn-lg">Ver Produtos</a>
                            <a href="/contato" class="btn btn-outline-primary btn-lg">Contato</a>
                            <a href="/logout" class="btn btn-outline-danger btn-lg">Sair do Sistema</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once 'src/components/Footer.php';
?>