
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@iconify/iconify@3.0.0/dist/iconify.min.js"></script>
    <style>
        :root {
            --primary-dark: #0f172a;
            --primary-medium: #1e293b;
            --primary-light: #334155;
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --shadow-dark: 0 4px 12px rgba(2, 6, 23, 0.3);
            --shadow-light: 0 2px 8px rgba(2, 6, 23, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .login-wrapper {
            max-width: 500px;
            margin: 0 auto;
            padding: 0 1rem;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
            color: var(--text-light);
            padding: 2.5rem;
            border-radius: 16px 16px 0 0;
            text-align: center;
        }

        .login-container {
            background-color: white;
            border-radius: 0 0 16px 16px;
            box-shadow: var(--shadow-dark);
            overflow: hidden;
        }

        .login-body {
            padding: 2.5rem;
        }

        .logo-container {
            margin-bottom: 1.5rem;
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .title-section h1 {
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .title-section p {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .form-label {
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            transition: all 0.3s;
            font-size: 1.05rem;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.3rem rgba(59, 130, 246, 0.25);
        }

        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 2rem;
            padding: 1.25rem 1.5rem;
            font-size: 1.05rem;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background-color: #f0f9ff;
            color: #0369a1;
            border-left: 4px solid var(--accent-color);
        }

        .lembrar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1.5rem 0;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
            border: 2px solid #cbd5e1;
            border-radius: 5px;
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-check-label {
            cursor: pointer;
            color: var(--primary-dark);
            font-weight: 500;
            font-size: 1.05rem;
        }

        .esqueci-senha a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            transition: color 0.3s;
        }

        .esqueci-senha a:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }

        .btn-custom {
            border-radius: 10px;
            font-weight: 600;
            padding: 1rem 2rem;
            transition: all 0.3s;
            border: none;
            font-size: 1.1rem;
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-hover) 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .login-button-container {
            margin: 2rem 0;
        }

        .cadastro-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
            color: #64748b;
            font-size: 1.1rem;
        }

        .cadastro-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
            margin-left: 0.5rem;
        }

        .cadastro-link a:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                max-width: 100%;
                padding: 0 1.5rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }

            .login-header {
                padding: 2rem 1.5rem;
            }

            .lembrar-container {
                flex-direction: column;
                gap: 1.5rem;
                align-items: flex-start;
            }

            .esqueci-senha {
                align-self: flex-end;
            }
        }

        @media (max-width: 576px) {
            .login-body {
                padding: 1.5rem;
            }

            .login-header {
                padding: 1.5rem;
            }

            .btn-custom {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
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
                            value="<?php echo htmlspecialchars($senha_salva); ?>"
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
</body>

</html>