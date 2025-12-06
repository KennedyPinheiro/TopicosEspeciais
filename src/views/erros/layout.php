<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Erro' ?> - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/erros/layout.css">
</head>
<body>
    <div class="error-page">
        <div class="error-card <?= 'error-' . ($code ?? '500') ?>">
            <div class="error-header">
                <div class="error-icon">
                    <?= $icon ?? '❌' ?>
                </div>
                <h1 class="error-title"><?= $code ?? 'Erro' ?></h1>
                <p class="error-subtitle"><?= $subtitle ?? 'Algo deu errado' ?></p>
            </div>
            <div class="error-body">
                <p class="error-message"><?= $message ?? 'Ocorreu um erro inesperado.' ?></p>
                
                <div class="error-actions">
                    <?php if (!empty($actions)): ?>
                        <?php foreach ($actions as $action): ?>
                            <a href="<?= $action['url'] ?>" class="btn-error" <?= isset($action['target']) ? 'target="' . $action['target'] . '"' : '' ?>>
                                <?php if (!empty($action['icon'])): ?>
                                    <i class="<?= $action['icon'] ?> me-2"></i>
                                <?php endif; ?>
                                <?= $action['text'] ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <a href="/" class="btn-error">
                            <i class="fas fa-home me-2"></i>
                            Página Inicial
                        </a>
                        <a href="javascript:history.back()" class="btn-error">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar
                        </a>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($debug) && (APP_DEBUG ?? false)): ?>
                    <div class="debug-info">
                        <small>
                            <strong>Debug Info:</strong><br>
                            <?= nl2br(htmlspecialchars($debug)) ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-error');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === 'javascript:history.back()') {
                        return;
                    }
                    
                    if (!this.getAttribute('href').startsWith('javascript:')) {
                        this.classList.add('loading');
                        setTimeout(() => {
                            this.classList.remove('loading');
                        }, 2000);
                    }
                });
            });
        });
    </script>
</body>
</html>