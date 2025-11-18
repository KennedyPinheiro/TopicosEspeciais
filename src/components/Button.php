<?php
function Button($props = []) {
    $text = $props['text'] ?? 'Botão';
    $type = $props['type'] ?? 'button';
    $style = $props['style'] ?? 'primary';
    $onclick = $props['onclick'] ?? '';
    $class = $props['class'] ?? '';
    $disabled = isset($props['disabled']) && $props['disabled'] ? 'disabled' : '';
    
    $bootstrapStyles = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary', 
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'link' => 'btn-link'
    ];
    
    $btnClass = $bootstrapStyles[$style] ?? $bootstrapStyles['primary'];
    $fullClass = "btn $btnClass $class";
    
    return "
        <button type='" . htmlspecialchars($type) . "' 
                class='" . trim($fullClass) . "' 
                onclick='" . htmlspecialchars($onclick) . "'
                $disabled>
            $text
        </button>
    ";
}
