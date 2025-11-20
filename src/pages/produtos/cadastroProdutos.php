<?php
$pageTitle = "Cadastro de Produtos - Sistema IF";
$currentPage = 'produtos';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
?>

<main style="min-height: calc(100vh - 120px); padding: 20px 0;">
    <div class="container mt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <a href="/produtos" class="btn btn-light">&larr;</a>
            </div>
            <div class="col">
                <div class="d-flex align-items-center">
                    <div class="badge bg-primary py-2 px-4 rounded-pill">Cadastro de Produtos</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="/processa_produto" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control" placeholder="Exemplo" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea id="descricao" name="descricao" class="form-control" rows="3" placeholder="Descrição do produto"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="preco" class="form-label">Preço</label>
                                    <input type="text" id="preco" name="preco" class="form-control" placeholder="0.00">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="categoria" class="form-label">Categoria</label>
                                    <input type="text" id="categoria" name="categoria" class="form-control" placeholder="Ex: Eletrônicos">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" id="sku" name="sku" class="form-control" placeholder="Código do produto">
                            </div>

                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">SALVAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <label class="w-100 text-center mb-2">Imagem do Produto</label>
                        <div style="width: 260px; height: 260px; border: 2px dashed #d3d3d3; display:flex; align-items:center; justify-content:center; color:#6c757d;">
                            IMG
                        </div>
                        <div class="mt-3 w-100 text-center">
                            <input type="file" name="imagem" accept="image/*" class="form-control">
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