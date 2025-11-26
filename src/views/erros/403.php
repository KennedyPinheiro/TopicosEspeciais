<?php
$title = 'Acesso Negado';
$code = '403';
$subtitle = 'Acesso Proibido';
$icon = '🚫';
$message = 'Você não tem permissão para acessar esta página. Se você acredita que isso é um erro, entre em contato com o administrador do sistema.';

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
        'url' => '/login',
        'icon' => 'fas fa-sign-in-alt',
        'text' => 'Fazer Login'
    ]
];

if (function_exists('logError')) {
    logError("403 - Acesso negado: " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . " - IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown'));
}

include 'layout.php';
?>