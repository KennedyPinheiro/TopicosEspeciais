<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\HomeController;
use App\Controllers\ProfileController;
use App\Middleware\AuthMiddleware;

$host = 'localhost';
$dbname = 'Site2';
$username = 'root';
$password = 'Senha@123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Location: /erro/500?error=' . urlencode($e->getMessage()));
    exit;
}

$authController = new AuthController($pdo);
$productController = new ProductController($pdo);
$homeController = new HomeController($pdo);
$profileController = new ProfileController($pdo);

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$clean_path = trim($path, '/');

if ($clean_path === '' || $clean_path === 'index.php') {
    if (isset($_COOKIE['nome_usuario'])) {
        header('Location: /home');
        exit;
    } else {
        header('Location: /login');
        exit;
    }
}

switch ($clean_path) {
    case 'login':
        AuthMiddleware::redirectIfAuthenticated();
        $authController->login();
        break;

    case 'home':
        AuthMiddleware::checkAuth();
        $homeController->index();
        break;

    case 'cadastro':
        AuthMiddleware::redirectIfAuthenticated();
        $authController->cadastro();
        break;

    case 'processa_cadastro':
        AuthMiddleware::redirectIfAuthenticated();
        $authController->processarCadastro();
        break;

    case 'produtos':
        AuthMiddleware::checkAuth();
        $productController->index();
        break;

    case 'produtos/adicionar':
        AuthMiddleware::checkAuth();
        $productController->adicionar();
        break;

    case 'produtos/visualizar':
        AuthMiddleware::checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /erro/400?message=' . urlencode('ID do produto não informado'));
            exit;
        }
        $productController->visualizar($id);
        break;

    case 'produtos/editar':
        AuthMiddleware::checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /erro/400?message=' . urlencode('ID do produto não informado'));
            exit;
        }
        $productController->editar($id);
        break;

    case 'produtos/processar':
        AuthMiddleware::checkAuth();
        $productController->processar();
        break;

    case 'produtos/processar-edicao':
        AuthMiddleware::checkAuth();
        $productController->processarEdicao();
        break;

    case 'produtos/excluir':
        AuthMiddleware::checkAuth();
        $productController->excluir();
        break;

    case 'sobre':
        AuthMiddleware::checkAuth();
        $aboutController = new HomeController($pdo);
        $aboutController->sobre();
        break;

    case 'perfil':
        AuthMiddleware::checkAuth();
        $profileController->perfil();
        break;

    case 'perfil/atualizar':
        AuthMiddleware::checkAuth();
        $profileController->atualizarPerfil();
        break;

    case 'perfil/alterar-senha':
        AuthMiddleware::checkAuth();
        $profileController->alterarSenha();
        break;

    case 'processa_login':
        $authController->processarLogin();
        break;

    case 'tela-logout':
        AuthMiddleware::checkAuth();
        $homeController->telaLogout();
        break;

    case 'contato':
        AuthMiddleware::checkAuth();
        $contactController = new HomeController($pdo);
        $contactController->contato();
        break;

    case 'contato/processar':
        AuthMiddleware::checkAuth();
        $contactController = new HomeController($pdo);
        $contactController->processarContato();
        break;

    case 'logout':
        $homeController->logout();
        break;

    case 'erro/404':
        $this->showErrorPage(404);
        break;

    case 'erro/500':
        $this->showErrorPage(500);
        break;

    case 'erro/403':
        $this->showErrorPage(403);
        break;

    case 'erro/400':
        $this->showErrorPage(400);
        break;

    case 'erro/geral':
        $this->showErrorPage('geral');
        break;

    default:
        header('Location: /erro/404');
        exit;
}


function showErrorPage($errorCode = 500) {
    $errorFile = __DIR__ . "/src/views/erros/{$errorCode}.php";
    
    if (!file_exists($errorFile)) {
        $errorFile = __DIR__ . "/src/views/erros/geral.php";
    }
    
    $httpCodes = [
        400 => 400,
        403 => 403,
        404 => 404,
        500 => 500
    ];
    
    if (isset($httpCodes[$errorCode])) {
        http_response_code($httpCodes[$errorCode]);
    }
    
    include $errorFile;
    exit;
}
?>