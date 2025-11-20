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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0f172a;
            --primary-medium: #1e293b;
            --primary-light: #334155;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --shadow-dark: 0 4px 12px rgba(2, 6, 23, 0.3);
            --shadow-light: 0 2px 8px rgba(2, 6, 23, 0.15);
        }
        
        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
    <?php echo $additionalCSS ?? ''; ?>
</head>
<body>