<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@iconify/iconify@3.0.0/dist/iconify.min.js"></script>
    <link rel="stylesheet" href="/assets/css/cadastro.css">
</head>

<body>
    <?php
    $erro_cadastro = $this->getFlash('erro_cadastro');
    if ($erro_cadastro) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 500px; margin: 20px auto;">';
        echo '<span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>';
        echo htmlspecialchars($erro_cadastro);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
    ?>

    <main class="cadastro-container">

        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Criar Nova Conta</h1>
                        <p class="lead mb-3 opacity-75">Preencha os dados abaixo para se cadastrar no sistema</p>
                    </div>
                    <div class="header-actions">
                        <a href="/login" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                            Voltar para Login
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="cadastro-layout">

                <div class="cadastro-sidebar">

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                Informações Importantes
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="iconify text-primary" data-icon="mdi:shield-check" data-width="20" data-height="20"></span>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Conta Segura</h6>
                                        <p class="text-muted small mb-0">Suas informações estão protegidas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="iconify text-success" data-icon="mdi:account-multiple" data-width="20" data-height="20"></span>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Multiplos Acessos</h6>
                                        <p class="text-muted small mb-0">Diferentes tipos de usuário</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="iconify text-warning" data-icon="mdi:clock-fast" data-width="20" data-height="20"></span>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Cadastro Rápido</h6>
                                        <p class="text-muted small mb-0">Apenas alguns minutos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:account-group" data-width="20" data-height="20"></span>
                                Tipos de Usuário
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="user-type-item mb-3">
                                <h6 class="fw-semibold mb-1 text-primary">Visualizador</h6>
                                <p class="text-muted small mb-0">Acesso apenas para visualização</p>
                            </div>
                            <div class="user-type-item mb-3">
                                <h6 class="fw-semibold mb-1 text-success">Vendedor</h6>
                                <p class="text-muted small mb-0">Pode realizar vendas</p>
                            </div>
                            <div class="user-type-item mb-3">
                                <h6 class="fw-semibold mb-1 text-warning">Estoque</h6>
                                <p class="text-muted small mb-0">Gerencia produtos</p>
                            </div>
                            <div class="user-type-item">
                                <h6 class="fw-semibold mb-1 text-danger">Gerente</h6>
                                <p class="text-muted small mb-0">Acesso completo</p>
                            </div>
                        </div>
                    </div>


                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:help-circle" data-width="20" data-height="20"></span>
                                Precisa de Ajuda?
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="/sobre" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:information" data-width="18" data-height="18"></span>
                                    Sobre o Sistema
                                </a>
                                <a href="/contato" class="btn btn-outline-success text-start">
                                    <span class="iconify" data-icon="mdi:email" data-width="18" data-height="18"></span>
                                    Entrar em Contato
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cadastro-content">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card profile-card">
                                    <div class="card-body">
                                        <form method="POST" action="/processa_cadastro" id="cadastroForm" class="needs-validation" novalidate>
                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="form-section">
                                                        <h5 class="fw-bold mb-4">
                                                            <span class="iconify" data-icon="mdi:account-details" data-width="20" data-height="20"></span>
                                                            Informações Pessoais
                                                        </h5>

                                                        <div class="mb-3">
                                                            <label for="nome" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:account" data-width="16" data-height="16"></span>
                                                                Nome Completo <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" id="nome" name="nome" class="form-control form-control-lg"
                                                                placeholder="Seu nome completo" required
                                                                value="<?php echo htmlspecialchars($form_data['nome'] ?? ''); ?>">
                                                            <div class="invalid-feedback">
                                                                Por favor, informe seu nome completo.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:email" data-width="16" data-height="16"></span>
                                                                E-mail <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="email" id="email" name="email" class="form-control form-control-lg"
                                                                placeholder="seu.email@if.com.br" required
                                                                value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                                                            <div class="invalid-feedback">
                                                                Por favor, informe um e-mail válido.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="telefone" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:phone" data-width="16" data-height="16"></span>
                                                                Telefone
                                                            </label>
                                                            <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg"
                                                                placeholder="(00) 00000-0000"
                                                                value="<?php echo htmlspecialchars($form_data['telefone'] ?? ''); ?>">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="data_nascimento" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:cake" data-width="16" data-height="16"></span>
                                                                Data de Nascimento
                                                            </label>
                                                            <input type="date" id="data_nascimento" name="data_nascimento" class="form-control form-control-lg"
                                                                value="<?php echo htmlspecialchars($form_data['data_nascimento'] ?? ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="form-section">
                                                        <h5 class="fw-bold mb-4">
                                                            <span class="iconify" data-icon="mdi:shield-account" data-width="20" data-height="20"></span>
                                                            Configurações da Conta
                                                        </h5>

                                                        <div class="mb-3">
                                                            <label for="senha" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:lock" data-width="16" data-height="16"></span>
                                                                Senha <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="password" id="senha" name="senha" class="form-control form-control-lg"
                                                                placeholder="Crie uma senha segura" required minlength="6">
                                                            <div class="form-text">
                                                                <span class="iconify" data-icon="mdi:information" data-width="16" data-height="16"></span>
                                                                Mínimo 6 caracteres
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                A senha deve ter pelo menos 6 caracteres.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="confirmar_senha" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:lock-check" data-width="16" data-height="16"></span>
                                                                Confirmar Senha <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control form-control-lg"
                                                                placeholder="Digite a senha novamente" required>
                                                            <div class="invalid-feedback">
                                                                As senhas devem ser iguais.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="tipo_usuario" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:account-tie" data-width="16" data-height="16"></span>
                                                                Tipo de Usuário
                                                            </label>
                                                            <select id="tipo_usuario" name="tipo_usuario" class="form-select form-select-lg">
                                                                <option value="visualizador" <?php echo ($form_data['tipo_usuario'] ?? 'visualizador') === 'visualizador' ? 'selected' : ''; ?>> Visualizador</option>
                                                                <option value="vendedor" <?php echo ($form_data['tipo_usuario'] ?? '') === 'vendedor' ? 'selected' : ''; ?>>Vendedor</option>
                                                                <option value="estoque" <?php echo ($form_data['tipo_usuario'] ?? '') === 'estoque' ? 'selected' : ''; ?>>Estoque</option>
                                                                <option value="gerente" <?php echo ($form_data['tipo_usuario'] ?? '') === 'gerente' ? 'selected' : ''; ?>>Gerente</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="departamento" class="form-label fw-semibold">
                                                                <span class="iconify" data-icon="mdi:office-building" data-width="16" data-height="16"></span>
                                                                Departamento
                                                            </label>
                                                            <input type="text" id="departamento" name="departamento" class="form-control form-control-lg"
                                                                placeholder="Seu departamento"
                                                                value="<?php echo htmlspecialchars($form_data['departamento'] ?? ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-12">
                                                    <div class="form-section border-top pt-4 mt-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="termos" name="termos" required>
                                                            <label class="form-check-label" for="termos">
                                                                <span class="iconify" data-icon="mdi:file-document" data-width="16" data-height="16"></span>
                                                                Concordo com os
                                                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#termosUsoModal">Termos de Uso</a>
                                                                e
                                                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#politicaPrivacidadeModal">Política de Privacidade</a>
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="invalid-feedback">
                                                                Você deve concordar com os termos para continuar.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-section border-top pt-4 mt-4">
                                                        <div class="d-flex justify-content-between align-items-center gap-3">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    if (!function_exists('ModaisTermos')) {
        require_once __DIR__ . '/../components/ModaisTermos.php';
    }
    echo ModaisTermos();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/cadastro.js"></script>
</body>

</html>