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
    public function dashboard()
    {
        try {
            $totalProducts = $this->productService->getProductsCount();
            $withStock = $this->productService->getProductsWithStockCount();
            $withoutStock = $this->productService->getProductsWithoutStockCount();
            $recentProducts = $this->productService->getRecentProducts(5);

            $pageTitle = 'Dashboard de Produtos - Sistema IF';
            $currentPage = 'dashboard';

            $this->render('produtos/dashboard', compact(
                'totalProducts',
                'withStock',
                'withoutStock',
                'recentProducts',
                'pageTitle',
                'currentPage'
            ));
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao carregar dashboard');
        }
    }
    public function index()
    {
        try {
            $produtos = $this->productService->getAllProducts();
            $pageTitle = 'Produtos - Sistema IF';
            $currentPage = 'produtos';

            $this->render('produtos/index', compact('produtos', 'pageTitle', 'currentPage'));
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao carregar produtos');
        }
    }

    public function adicionar()
    {
        try {
            $pageTitle = 'Cadastrar Produto - Sistema IF';
            $currentPage = 'produtos';
            $modo = 'cadastro';
            $produto = null;

            $this->render('produtos/form', compact('pageTitle', 'currentPage', 'modo', 'produto'));
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao carregar formulário de cadastro');
        }
    }

    public function visualizar($id = null)
    {
        try {
            if (!$id) {
                header('Location: /erro/400?message=' . urlencode('ID do produto não informado'));
                exit;
            }

            $produto = $this->productService->getProductById($id);
            if (!$produto) {
                header('Location: /erro/404?message=' . urlencode('Produto não encontrado'));
                exit;
            }

            $pageTitle = 'Visualizar Produto - Sistema IF';
            $currentPage = 'produtos';
            $modo = 'visualizar';

            $this->render('produtos/form', compact('pageTitle', 'currentPage', 'modo', 'produto'));
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao visualizar produto');
        }
    }

    public function editar($id = null)
    {
        try {
            if (!$id) {
                header('Location: /erro/400?message=' . urlencode('ID do produto não informado'));
                exit;
            }

            $produto = $this->productService->getProductById($id);
            if (!$produto) {
                header('Location: /erro/404?message=' . urlencode('Produto não encontrado'));
                exit;
            }

            $pageTitle = 'Editar Produto - Sistema IF';
            $currentPage = 'produtos';
            $modo = 'editar';

            $this->render('produtos/form', compact('pageTitle', 'currentPage', 'modo', 'produto'));
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao carregar edição de produto');
        }
    }

    public function processar()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: /erro/405?message=' . urlencode('Método não permitido'));
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
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao processar produto');
        }
    }

    public function processarEdicao()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: /erro/405?message=' . urlencode('Método não permitido'));
                exit;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: /erro/400?message=' . urlencode('ID do produto não informado'));
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
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao atualizar produto');
        }
    }

    public function excluir()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: /erro/405?message=' . urlencode('Método não permitido'));
                exit;
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: /erro/400?message=' . urlencode('ID do produto não informado'));
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
        } catch (\Exception $e) {
            $this->handleException($e, 'Erro ao excluir produto');
        }
    }


    private function handleException(\Exception $e, string $context = 'Erro')
    {
        error_log("{$context}: " . $e->getMessage());

        $message = urlencode("{$context}: " . $e->getMessage());

        if (
            strpos($e->getMessage(), 'not found') !== false ||
            strpos($e->getMessage(), 'não encontrado') !== false
        ) {
            header('Location: /erro/404?message=' . $message);
        } elseif (
            strpos($e->getMessage(), 'permission') !== false ||
            strpos($e->getMessage(), 'acesso negado') !== false
        ) {
            header('Location: /erro/403?message=' . $message);
        } elseif (
            strpos($e->getMessage(), 'validation') !== false ||
            strpos($e->getMessage(), 'validação') !== false
        ) {
            header('Location: /erro/400?message=' . $message);
        } else {
            header('Location: /erro/500?error=' . $message);
        }
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
