<?php
$title = 'Página Não Encontrada';
$code = '404';
$subtitle = 'Página Não Encontrada';
$icon = '🔍';
$message = 'A página que você está procurando não foi encontrada. Ela pode ter sido movida, renomeada ou não existe mais.';
$actions = [
    [
        'url' => '/',
        'icon' => 'fas fa-home',
        'text' => 'Página Inicial'
    ],
    [
        'url' => 'javascript:history.back()',
        'icon' => 'fas fa-arrow-left',
        'text' => 'Voltar'
    ],
    [
        'url' => '/contato',
        'icon' => 'fas fa-envelope',
        'text' => 'Reportar Problema'
    ]
];

if (function_exists('logError')) {
    logError("404 - Página não encontrada: " . ($_SERVER['REQUEST_URI'] ?? 'Unknown'));
}

include 'layout.php';
?>