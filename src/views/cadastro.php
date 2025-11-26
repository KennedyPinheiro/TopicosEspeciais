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

                                    <div class="mb-3">
                                        <label for="departamento" class="form-label fw-semibold">Departamento</label>
                                        <input type="text" id="departamento" name="departamento" class="form-control form-control-lg"
                                            placeholder="Seu departamento"
                                            value="<?php echo htmlspecialchars($form_data['departamento'] ?? ''); ?>">
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

    <?php
    if (method_exists($this, 'renderModaisTermos')) {
        $this->renderModaisTermos();
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/cadastro.js"></script>
       
    
</body>

</html>