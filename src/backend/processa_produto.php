<?php
// Processa produto (placeholder)
// Atualmente apenas redireciona de volta para a listagem de produtos.

if (!isset($_COOKIE['nome_usuario'])) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /produtos');
    exit;
}

// Aqui você pode adicionar validação, salvamento no banco e upload de arquivo.
// Exemplo rápido de leitura dos campos (sem validação):
// $nome = $_POST['nome'] ?? '';
// $descricao = $_POST['descricao'] ?? '';

// Para manter o preview simples, apenas redireciona de volta.
header('Location: /produtos');
exit;
