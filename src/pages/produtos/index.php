<?php
$pageTitle = "Produtos - Sistema IF";
$currentPage = 'produtos';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
include_once 'src/config/db.php';

$sucesso = $_GET['sucesso'] ?? '';
$erro = $_GET['erro'] ?? '';
$msg = $_GET['msg'] ?? '';
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

        <!-- Mensagens -->
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
                    'erro_banco_dados' => '❌ Erro no banco de dados: ' . htmlspecialchars($msg)
                ];
                echo $mensagens[$erro] ?? '❌ Erro desconhecido.';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar produtos: " . $e->getMessage());
            $produtos = [];
        }
        ?>

        <!-- Card de Conteúdo -->
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
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($produtos as $produto): ?>
                                    <?php include 'src/components/produto.php'; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
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
</style>

<?php include_once 'src/components/Footer.php'; ?>