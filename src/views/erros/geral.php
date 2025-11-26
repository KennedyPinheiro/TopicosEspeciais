<?php
$errorCode = $_GET['code'] ?? '500';
$errorMessage = $_GET['message'] ?? 'Ocorreu um erro inesperado no sistema.';
$errorTitle = $_GET['title'] ?? 'Erro';

$title = htmlspecialchars($errorTitle);
$code = htmlspecialchars($errorCode);
$subtitle = 'Algo deu errado';
$icon = '❌';
$message = htmlspecialchars($errorMessage);

$iconMap = [
    '404' => '🔍',
    '500' => '⚙️',
    '403' => '🚫',
    '400' => '📝',
    '503' => '🛠️'
];

if (isset($iconMap[$errorCode])) {
    $icon = $iconMap[$errorCode];
}

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
        'text' => 'Suporte'
    ]
];

$debug = '';
if (defined('APP_DEBUG') && APP_DEBUG) {
    $debug = $_GET['debug'] ?? '';
}

include 'layout.php';
?>