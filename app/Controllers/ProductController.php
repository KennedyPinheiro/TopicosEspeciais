<?php

namespace App\Controllers;

use App\Models\Product;
use App\Services\ProductService;

class ProductController extends BaseController
{
    private $productService;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $productModel = new Product($pdo);
        $this->productService = new ProductService($productModel);
    }

    public function index()
    {
        $produtos = $this->productService->getAllProducts();
        $pageTitle = 'Produtos - Sistema IF';
        $currentPage = 'produtos';

        $this->render('produtos/index', compact('produtos', 'pageTitle', 'currentPage'));
    }

    public function adicionar()
    {
        $pageTitle = 'Cadastrar Produto - Sistema IF';
        $currentPage = 'produtos';
        $modo = 'cadastro';
        $produto = null;

        $this->render('produtos/form', compact('pageTitle', 'currentPage', 'modo', 'produto'));
    }

    public function visualizar($id = null)
    {
        if (!$id) {
            $this->setFlash('erro', 'id_nao_informado');
            header('Location: /produtos');
            exit;
        }

        $produto = $this->productService->getProductById($id);
        if (!$produto) {
            $this->setFlash('erro', 'produto_nao_encontrado');
            header('Location: /produtos');
            exit;
        }

        $pageTitle = 'Visualizar Produto - Sistema IF';
        $currentPage = 'produtos';
        $modo = 'visualizar';

        $this->render('produtos/form', compact('pageTitle', 'currentPage', 'modo', 'produto'));
    }

    public function editar($id = null)
    {
        if (!$id) {
            $this->setFlash('erro', 'id_nao_informado');
            header('Location: /produtos');
            exit;
        }

        $produto = $this->productService->getProductById($id);
        if (!$produto) {
            $this->setFlash('erro', 'produto_nao_encontrado');
            header('Location: /produtos');
            exit;
        }

        $pageTitle = 'Editar Produto - Sistema IF';
        $currentPage = 'produtos';
        $modo = 'editar';

        $this->render('produtos/form', compact('pageTitle', 'currentPage', 'modo', 'produto'));
    }

    public function processar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlash('erro', 'metodo_nao_permitido');
            header('Location: /produtos/adicionar');
            exit;
        }

        $file = $_FILES['imagem'] ?? null;
        $result = $this->productService->createProduct($_POST, $file);

        if ($result['success']) {
            $this->setFlash('sucesso', 'produto_adicionado');
            header('Location: /produtos');
            exit;
        } else {
            $this->setFlash('erro', 'campos_obrigatorios');
            $this->setFlash('form_errors', $result['errors']);
            $this->setFlash('form_data', $result['old_data']);
            $this->setFlash('msg', implode(', ', $result['errors']));
            
            header('Location: /produtos/adicionar');
            exit;
        }
    }

    public function processarEdicao()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlash('erro', 'metodo_nao_permitido');
            header('Location: /produtos');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->setFlash('erro', 'id_nao_informado');
            header('Location: /produtos');
            exit;
        }

        $file = $_FILES['imagem'] ?? null;
        $result = $this->productService->updateProduct($id, $_POST, $file);

        if ($result['success']) {
            $this->setFlash('sucesso', 'produto_editado');
            header('Location: /produtos');
            exit;
        } else {
            $this->setFlash('erro', 'campos_obrigatorios');
            $this->setFlash('form_errors', $result['errors']);
            $this->setFlash('form_data', $result['old_data']);
            $this->setFlash('msg', implode(', ', $result['errors']));
            
            header("Location: /produtos/editar?id={$id}");
            exit;
        }
    }

    public function excluir()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlash('erro', 'metodo_nao_permitido');
            header('Location: /produtos');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->setFlash('erro', 'id_nao_informado');
            header('Location: /produtos');
            exit;
        }

        $result = $this->productService->deleteProduct($id);

        if ($result['success']) {
            $this->setFlash('sucesso', 'produto_excluido');
        } else {
            $this->setFlash('erro', 'erro_exclusao');
            $this->setFlash('msg', $result['error']);
        }

        header('Location: /produtos');
        exit;
    }

    public function renderModaisTermos()
    {
        echo '
        <!-- Modal Termos de Uso -->
        <div class="modal fade" id="termosUsoModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Termos de Uso - Produtos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Termos de uso específicos para o gerenciamento de produtos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Política de Privacidade -->
        <div class="modal fade" id="politicaPrivacidadeModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Política de Privacidade - Produtos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Política de privacidade para dados de produtos...</p>
                    </div>
                </div>
            </div>
        </div>';
    }
}
?>