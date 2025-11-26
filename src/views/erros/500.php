<?php
$title = 'Erro Interno do Servidor';
$code = '500';
$subtitle = 'Erro do Servidor';
$icon = '⚙️';
$message = 'Ocorreu um erro interno no servidor. Nossa equipe técnica já foi notificada e está trabalhando para resolver o problema.';

$debug = '';
if (defined('APP_DEBUG') && APP_DEBUG) {
    $debug = "Erro: " . ($_GET['error'] ?? 'Erro desconhecido') . "\n";
    $debug .= "URL: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
    $debug .= "Data: " . date('Y-m-d H:i:s') . "\n";
}

$actions = [
    [
        'url' => '/',
        'icon' => 'fas fa-home',
        'text' => 'Página Inicial'
    ],
    [
        'url' => 'javascript:location.reload()',
        'icon' => 'fas fa-redo',
        'text' => 'Tentar Novamente'
    ]
];

// Log do erro 500
if (function_exists('logError')) {
    logError("500 - Erro interno: " . ($_GET['error'] ?? 'Unknown'));
}

include 'layout.php';
?>