<?php
$pageTitle = "Produtos - Sistema IF";
$currentPage = 'produtos';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
?>

<main style="min-height: calc(100vh - 120px); padding: 20px 0;">
    <div class="container mt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <a href="/home" class="btn btn-light">&larr;</a>
            </div>
            <div class="col">
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary py-2 px-4 rounded-pill">Produtos</div>
                    <div class="ms-auto">
                        <a href="/produtos/cadastroProdutos" class="btn btn-outline-primary">ADICIONAR +</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Exemplo</td>
                                        <td>Defsdgsgfadhjfghja</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-outline-secondary" title="Visualizar">👁️</a>
                                            <a href="/produtos/cadastroProdutos?id=1" class="btn btn-sm btn-outline-primary" title="Editar">✏️</a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir">🗑️</a>
                                        </td>
                                    </tr>
                                    <!-- Mais linhas de produtos viriam aqui -->
                                </tbody>
                            </table>
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