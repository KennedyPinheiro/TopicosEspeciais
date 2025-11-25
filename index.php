<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AboutController;
use App\Controllers\AuthController;
use App\Controllers\ContactController;
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
    die("Erro de conexão com o banco: " . $e->getMessage());
}

$authController = new AuthController($pdo);
$productController = new ProductController($pdo);
$homeController = new HomeController($pdo);
$profileController = new ProfileController($pdo);
$contactController = new ContactController($pdo);
$aboutController = new AboutController($pdo);
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
        $productController->visualizar($id);
        break;

    case 'produtos/editar':
        AuthMiddleware::checkAuth();
        $id = $_GET['id'] ?? null;
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
    $aboutController = new AboutController($pdo);
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
        $contactController = new ContactController($pdo);
        $contactController->contato();
        break;

    case 'contato/processar':
        AuthMiddleware::checkAuth();
        $contactController = new ContactController($pdo);
        $contactController->processarContato();
        break;

    case 'logout':
        $homeController->logout();
        break;

    default:
        http_response_code(404);
        echo "<h1>Página não encontrada</h1>";
        echo "<p>A página '$clean_path' não foi encontrada.</p>";
        break;
}
