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
                    <h1>Acesso ao Sistema</h1>
                    <p>Entre com suas credenciais</p>
                </div>
            </div>

            <div class="login-body">
                <?php
                $erro_login = $this->getFlash('erro_login');
                $success_message = $this->getFlash('success_message');
                ?>
                <?php if ($erro_login): ?>
                    <div class="alert alert-danger" role="alert">
                        <span class="iconify" data-icon="mdi:alert-circle" data-width="24" data-height="24"></span>
                        <?php echo htmlspecialchars($erro_login); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="alert alert-success" role="alert">
                        <span class="iconify" data-icon="mdi:check-circle" data-width="24" data-height="24"></span>
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <form action="/processa_login" method="POST">
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($usuario_salvo); ?>"
                            placeholder="Digite seu e-mail"
                            required>
                    </div>

                    <div class="mb-2">
                        <label for="senha" class="form-label">Senha</label>
                        <input
                            type="password"
                            class="form-control"
                            id="senha"
                            name="senha"
                            placeholder="Digite sua senha"
                            required />
                    </div>

                    <div class="lembrar-container">
                        <div class="checkbox-group">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="lembrar"
                                name="lembrar"
                                <?php echo $lembrar_checked; ?> />
                            <label for="lembrar" class="form-check-label">
                                Lembre de mim
                            </label>
                        </div>

                        <div class="esqueci-senha">
                            <a href="/tela-logout">Esqueci minha senha</a>
                        </div>
                    </div>

                    <div class="login-button-container">
                        <button type="submit" class="btn btn-primary btn-custom">
                            <span class="iconify" data-icon="mdi:login" data-width="20" data-height="20"></span>
                            Entrar no Sistema
                        </button>
                    </div>
                </form>

                <div class="cadastro-link">
                    Novo por aqui?
                    <a href="/cadastro">Criar uma conta</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/login.js"></script>
</body>

</html>