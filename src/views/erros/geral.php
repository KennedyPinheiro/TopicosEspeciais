<?php
$errorCode = $_GET['code'] ?? 'Erro';
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
    ]
];

include 'layout.php';
?>