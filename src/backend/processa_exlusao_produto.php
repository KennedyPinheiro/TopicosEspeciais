<?php
if (!isset($_COOKIE['nome_usuario'])) {
    header('Location: /login');
    exit;
}

require_once __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /produtos?erro=id_nao_informado');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT imagem FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$produto) {
        header('Location: /produtos?erro=produto_nao_encontrado');
        exit;
    }
    
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $resultado = $stmt->execute([$id]);
    
    if ($resultado) {
        if ($produto['imagem'] && file_exists(__DIR__ . '/../../' . $produto['imagem'])) {
            unlink(__DIR__ . '/../../' . $produto['imagem']);
        }
        
        header('Location: /produtos?sucesso=produto_excluido');
        exit;
    } else {
        header('Location: /produtos?erro=erro_exclusao');
        exit;
    }
    
} catch (PDOException $e) {
    error_log("Erro ao excluir produto: " . $e->getMessage());
    header('Location: /produtos?erro=erro_banco_dados&msg=' . urlencode($e->getMessage()));
    exit;
}
?>