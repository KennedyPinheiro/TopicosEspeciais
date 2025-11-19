<?php

session_start();

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
        if (isset($_COOKIE['nome_usuario'])) {
            header('Location: /home');
            exit;
        }
        require 'src/pages/login.php';
        break;

    case 'home':
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
        require 'src/pages/home.php';
        break;

    case 'cadastro':
        if (isset($_COOKIE['nome_usuario'])) {
            header('Location: /home');
            exit;
        }
        require 'src/pages/cadastro.php';
        break;

    case 'processa_cadastro':
        if (isset($_COOKIE['nome_usuario'])) {
            header('Location: /home');
            exit;
        }
        require 'src/backend/processa_cadastro.php';
        break;

    case 'produtos':
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
        require 'src/pages/produtos/index.php';
        break;

    case 'produtos/cadastroProdutos':
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
        require 'src/pages/produtos/cadastroProdutos.php';
        break;

    case 'processa_produto':
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
        require 'src/backend/processa_produto.php';
        break;

    case 'sobre':
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
        require 'src/pages/sobre.php';
        break;

    case 'perfil':
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
        require 'src/pages/perfil.php';
        break;

    case 'processa_login':
        require 'src/backend/processa_login.php';
        break;

    case 'tela-logout':
        require 'src/pages/tela-logout.html';
        break;

    case 'logout':
        setcookie('nome_usuario', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
        ]);
        session_destroy();
        header('Location: /login');
        exit;

    default:
        http_response_code(404);
        echo "<h1>Página não encontrada</h1>";
        break;
}
