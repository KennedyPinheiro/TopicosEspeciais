<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar se já está logado - se estiver, redirecionar para home
if (isset($_COOKIE["nome_usuario"])) {
    header('Location: /home');
    exit();
}

// Incluir o componente Toast
require_once __DIR__ . '/../components/Toast.php';
require_once __DIR__ . '/../components/ModaisTermos.php';

$pageTitle = "Cadastro - Sistema IF";
$currentPage = 'cadastro';

$form_data = $_SESSION['form_data'] ?? [];
$toastError = '';

if (isset($_SESSION['erro_cadastro'])) {
    $toastError = Toast([
        'type' => 'error',
        'message' => $_SESSION['erro_cadastro'],
        'duration' => 8000,
        'position' => 'top-right'
    ]);
    unset($_SESSION['erro_cadastro']);
}

if (isset($_SESSION['form_data'])) {
    unset($_SESSION['form_data']);
}
?>

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
            padding: 2rem 0;
        }

        .cadastro-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            width: 100%;
        }

        .cadastro-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
            color: var(--text-light);
            padding: 2.5rem;
            border-radius: 16px 16px 0 0;
        }

        .cadastro-container {
            background-color: white;
            border-radius: 0 0 16px 16px;
            box-shadow: var(--shadow-dark);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .cadastro-body {
            padding: 2.5rem;
        }

        .logo-container {
            margin-bottom: 1.0rem;
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: fill;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
            font-weight: bold;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-hover) 0%, #1d4ed8 100%);
            transform: translateY(-1px);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .was-validated .form-control:invalid~.invalid-tooltip {
            display: block;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .cadastro-body {
                padding: 2rem 1.5rem;
            }

            .cadastro-header {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .cadastro-body {
                padding: 1.5rem;
            }

            .cadastro-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <?php echo $toastError; ?>

    <div class="cadastro-wrapper">
        <div class="cadastro-container">
            <div class="cadastro-header">
                <div class="header-content">
                    <div style="display: flex; flex-direction: row; gap: 30px;">
                        <div class="logo-container">
                            <img src="/assets/img/logo_IF2.png" alt="Logo IF" class="logo" />
                        </div>
                        <div class="title-section">
                            <h1 class="display-6 fw-bold">Criar Nova Conta</h1>
                            <p class="lead mb-0 opacity-75">Preencha os dados abaixo para se cadastrar no sistema</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="cadastro-body">
                <form method="POST" action="/processa_cadastro" id="cadastroForm" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-light border-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <span class="iconify" data-icon="mdi:account-details" data-width="20" data-height="20"></span>
                                        Informações Pessoais
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nome" class="form-label fw-semibold required-field">Nome Completo</label>
                                        <input type="text" id="nome" name="nome" class="form-control form-control-lg"
                                            placeholder="Seu nome completo" required
                                            value="<?php echo htmlspecialchars($form_data['nome'] ?? ''); ?>">
                                        <div class="invalid-feedback">
                                            Por favor, informe seu nome completo.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold required-field">E-mail</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                                            placeholder="seu.email@if.com.br" required
                                            value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                                        <div class="invalid-feedback">
                                            Por favor, informe um e-mail válido.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                        <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg"
                                            placeholder="(00) 00000-0000"
                                            value="<?php echo htmlspecialchars($form_data['telefone'] ?? ''); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="data_nascimento" class="form-label fw-semibold">Data de Nascimento</label>
                                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control form-control-lg"
                                            value="<?php echo htmlspecialchars($form_data['data_nascimento'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-light border-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <span class="iconify" data-icon="mdi:shield-account" data-width="20" data-height="20"></span>
                                        Configurações da Conta
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="senha" class="form-label fw-semibold required-field">Senha</label>
                                        <input type="password" id="senha" name="senha" class="form-control form-control-lg"
                                            placeholder="Crie uma senha segura" required minlength="6">
                                        <div class="invalid-feedback">
                                            A senha deve ter pelo menos 6 caracteres.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirmar_senha" class="form-label fw-semibold required-field">Confirmar Senha</label>
                                        <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control form-control-lg"
                                            placeholder="Digite a senha novamente" required>
                                        <div class="invalid-feedback">
                                            As senhas devem ser iguais.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipo_usuario" class="form-label fw-semibold">Tipo de Usuário</label>
                                        <select id="tipo_usuario" name="tipo_usuario" class="form-select form-select-lg">
                                            <option value="visualizador" <?php echo ($form_data['tipo_usuario'] ?? 'visualizador') === 'visualizador' ? 'selected' : ''; ?>>Visualizador</option>
                                            <option value="vendedor" <?php echo ($form_data['tipo_usuario'] ?? '') === 'vendedor' ? 'selected' : ''; ?>>Vendedor</option>
                                            <option value="estoque" <?php echo ($form_data['tipo_usuario'] ?? '') === 'estoque' ? 'selected' : ''; ?>>Estoque</option>
                                            <option value="gerente" <?php echo ($form_data['tipo_usuario'] ?? '') === 'gerente' ? 'selected' : ''; ?>>Gerente</option>
                                        </select>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="termos" name="termos" required>
                                <label class="form-check-label" for="termos">
                                    Concordo com os
                                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#termosUsoModal">Termos de Uso</a>
                                    e
                                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#politicaPrivacidadeModal">Política de Privacidade</a>
                                </label>
                                <div class="invalid-feedback">
                                    Você deve concordar com os termos para continuar.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center gap-3 pt-4 mt-4 border-top">
                        <div>
                            <span class="text-muted">Já possui uma conta?</span>
                            <a href="/login" class="btn btn-outline-primary btn-lg ms-2">
                                <span class="iconify" data-icon="mdi:login" data-width="20" data-height="20"></span>
                                Fazer Login
                            </a>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="window.location.href='/login'">
                                <span class="iconify" data-icon="mdi:cancel" data-width="20" data-height="20"></span>
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <span class="iconify" data-icon="mdi:account-plus" data-width="20" data-height="20"></span>
                                Criar Conta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('cadastroForm');
            const senha = document.getElementById('senha');
            const confirmarSenha = document.getElementById('confirmar_senha');

            function validatePassword() {
                if (senha.value !== confirmarSenha.value) {
                    confirmarSenha.setCustomValidity('As senhas devem ser iguais.');
                } else {
                    confirmarSenha.setCustomValidity('');
                }
            }

            senha.addEventListener('change', validatePassword);
            confirmarSenha.addEventListener('keyup', validatePassword);

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    </script>
    <?php echo ModaisTermos(); ?>
</body>

</html>