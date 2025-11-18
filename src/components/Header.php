<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_COOKIE['nome_usuario']) && !isset($_SESSION['usuario_nome'])) {
    header('Location: /login');
    exit();
}

$nome_usuario = $_COOKIE['nome_usuario'] ?? $_SESSION['usuario_nome'] ?? 'Usuário';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Sistema IF'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        .custom-navbar * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        
        body {
            margin: 0;
            padding: 0;
        }
    </style>
    <?php echo $additionalCSS ?? ''; ?>
</head>
<body>