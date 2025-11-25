<?php
function Button($config) {
    $text = $config['text'] ?? '';
    $type = $config['type'] ?? 'button';
    $style = $config['style'] ?? 'primary';
    $class = $config['class'] ?? '';
    $icon = $config['icon'] ?? '';
    
    $buttonClass = "btn btn-{$style}";
    if ($class) {
        $buttonClass .= " {$class}";
    }
    
    ob_start();
    ?>
    <button type="<?php echo $type; ?>" class="<?php echo $buttonClass; ?>">
        <?php if ($icon): ?>
            <span class="iconify" data-icon="<?php echo $icon; ?>" data-width="20" data-height="20"></span>
        <?php endif; ?>
        <?php echo htmlspecialchars($text); ?>
    </button>
    <?php
    return ob_get_clean();
}
?>