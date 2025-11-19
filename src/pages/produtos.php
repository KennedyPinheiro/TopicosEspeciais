<?php
$pageTitle = "Produtos - Sistema IF";
$currentPage = 'produtos';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
?>

<main style="min-height: calc(100vh - 120px); padding: 20px 0;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 bg-primary text-white rounded-3">
                    <h1 class="display-6">Nossos Produtos</h1>
                    <p class="lead mb-0">Confira nossa linha completa de produtos e serviços</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Produto 1</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Descrição detalhada do primeiro produto oferecido pelo sistema.</p>
                        <div class="bg-light p-3 rounded small mb-3">
                            <strong>Características:</strong><br>
                            • Alta qualidade<br>
                            • Suporte 24/7<br>
                            • Garantia estendida
                        </div>
                        <div class="d-grid">
                            <a href="#" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Produto 2</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Descrição detalhada do segundo produto oferecido pelo sistema.</p>
                        <div class="bg-light p-3 rounded small mb-3">
                            <strong>Características:</strong><br>
                            • Tecnologia avançada<br>
                            • Interface intuitiva<br>
                            • Atualizações frequentes
                        </div>
                        <div class="d-grid">
                            <a href="#" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Produto 3</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Descrição detalhada do terceiro produto oferecido pelo sistema.</p>
                        <div class="bg-light p-3 rounded small mb-3">
                            <strong>Características:</strong><br>
                            • Melhor custo-benefício<br>
                            • Fácil integração<br>
                            • Documentação completa
                        </div>
                        <div class="d-grid">
                            <a href="#" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Informações Adicionais</h5>
                    </div>
                    <div class="card-body">
                        <p>Todos os nossos produtos incluem suporte técnico especializado e atualizações regulares. Entre em contato para mais informações sobre preços e planos personalizados.</p>
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="/contato" class="btn btn-outline-primary">Fale Conosco</a>
                            <a href="/home" class="btn btn-outline-secondary">Voltar ao Início</a>
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
