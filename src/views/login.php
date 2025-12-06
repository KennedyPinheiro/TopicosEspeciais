<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@iconify/iconify@3.0.0/dist/iconify.min.js"></script>
    <link rel="stylesheet" href="/assets/css/login.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo-container">
                    <img src="/assets/img/logo_IF2.png" alt="Logo IF" class="logo" />
                </div>
                <div class="title-section">
                    <h1 class="display-6 fw-bold">Acesso ao Sistema</h1>
                    <p class="lead mb-0 opacity-75">Entre com suas credenciais</p>
                </div>
            </div>

            <div class="alerts-container">
                <?php
                $erro_login = $this->getFlash('erro_login');
                $success_message = $this->getFlash('success_message');
                ?>
                <?php if ($erro_login): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                        <?php echo htmlspecialchars($erro_login); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                        <?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>

         
            <div class="login-body">
                <form action="/processa_login" method="POST" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            <span class="iconify" data-icon="mdi:email" data-width="16" data-height="16"></span>
                            E-mail
                        </label>
                        <input
                            type="email"
                            class="form-control form-control-lg"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($usuario_salvo); ?>"
                            placeholder="Digite seu e-mail"
                            required>
                        <div class="invalid-feedback">
                            Por favor, informe um e-mail válido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label fw-semibold">
                            <span class="iconify" data-icon="mdi:lock" data-width="16" data-height="16"></span>
                            Senha
                        </label>
                        <div class="password-input-group">
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="senha"
                                name="senha"
                                placeholder="Digite sua senha"
                                required />
                            <button type="button" class="password-toggle" id="togglePassword">
                                <span class="iconify" data-icon="mdi:eye" data-width="20" data-height="20"></span>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Por favor, informe sua senha.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="lembrar"
                                name="lembrar"
                                <?php echo $lembrar_checked; ?> />
                            <label for="lembrar" class="form-check-label">
                                <span class="iconify" data-icon="mdi:bookmark" data-width="16" data-height="16"></span>
                                Lembre de mim
                            </label>
                        </div>

                        <div class="esqueci-senha">
                            <a href="/tela-logout" class="text-primary">
                                <span class="iconify" data-icon="mdi:key" data-width="16" data-height="16"></span>
                                Esqueci minha senha
                            </a>
                        </div>
                    </div>

                    <div class="login-button-container mb-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                            <span class="iconify" data-icon="mdi:login" data-width="20" data-height="20"></span>
                            Entrar no Sistema
                        </button>
                    </div>

                    <div class="cadastro-link text-center pt-3 border-top">
                        <span class="text-muted">Novo por aqui?</span>
                        <a href="/cadastro" class="btn btn-outline-primary btn-lg ms-2">
                            <span class="iconify" data-icon="mdi:account-plus" data-width="18" data-height="18"></span>
                            Criar uma conta
                        </a>
                    </div>
                </form>
            </div>

          
            <div class="login-footer">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="footer-item">
                            <span class="iconify text-primary" data-icon="mdi:security" data-width="24" data-height="24"></span>
                            <small class="d-block text-muted">Seguro</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="footer-item">
                            <span class="iconify text-success" data-icon="mdi:rocket-launch" data-width="24" data-height="24"></span>
                            <small class="d-block text-muted">Rápido</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="footer-item">
                            <span class="iconify text-warning" data-icon="mdi:headset" data-width="24" data-height="24"></span>
                            <small class="d-block text-muted">Suporte</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/login.js"></script>
</body>
</html>