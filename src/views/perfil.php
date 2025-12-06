<?php
$currentPage = 'perfil';

$success_perfil = $this->getFlash('success_perfil') ?? '';
$erro_perfil = $this->getFlash('erro_perfil') ?? '';
$success_senha = $this->getFlash('success_senha') ?? '';
$erro_senha = $this->getFlash('erro_senha') ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/perfil.css">
</head>

<body>
    <?php $this->renderComponent('header'); ?>

    <main class="perfil-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Meu Perfil</h1>
                        <p class="lead mb-3 opacity-75">Gerencie suas informações pessoais e preferências</p>
                    </div>
                    <div class="header-actions">
                        <a href="/home" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                            Voltar para Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="perfil-layout">
                <div class="perfil-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:account-circle" data-width="20" data-height="20"></span>
                                Foto do Perfil
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="avatar-container mb-3">
                                <div class="avatar-placeholder">
                                    <span class="iconify" data-icon="mdi:account" data-width="48" data-height="48"></span>
                                </div>
                            </div>
                            <div class="user-info mb-3">
                                <h6 class="fw-bold mb-1"><?= $usuario['nome'] ?></h6>
                                <p class="text-muted small mb-0"><?= $usuario['tipo_usuario_formatado'] ?></p>
                                <p class="text-muted small mb-0"><?= $usuario['departamento'] ?? 'Não informado' ?></p>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary">
                                    <span class="iconify" data-icon="mdi:camera" data-width="18" data-height="18"></span>
                                    Alterar Foto
                                </button>
                                <button type="button" class="btn btn-outline-danger">
                                    <span class="iconify" data-icon="mdi:trash-can" data-width="18" data-height="18"></span>
                                    Remover Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:chart-box" data-width="20" data-height="20"></span>
                                Estatísticas da Conta
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">ID do Usuário</span>
                                    <span class="fw-semibold">#<?= $usuario['id'] ?? 'N/A' ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Data de Cadastro</span>
                                    <span class="fw-semibold"><?= $this->formatDate($usuario['data_cadastro'] ?? null) ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Último Acesso</span>
                                    <span class="fw-semibold"><?= $usuario['ultimo_acesso'] ?></span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Status da Conta</span>
                                    <span class="badge bg-<?= $usuario['status'] === 'ativo' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($usuario['status']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:rocket-launch" data-width="20" data-height="20"></span>
                                Ações Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary text-start" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal">
                                    <span class="iconify" data-icon="mdi:lock" data-width="18" data-height="18"></span>
                                    Alterar Senha
                                </button>
                                <button type="button" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:bell" data-width="18" data-height="18"></span>
                                    Notificações
                                </button>
                                <button type="button" class="btn btn-outline-primary text-start">
                                    <span class="iconify" data-icon="mdi:palette" data-width="18" data-height="18"></span>
                                    Aparência
                                </button>
                                <button type="button" class="btn btn-outline-warning text-start">
                                    <span class="iconify" data-icon="mdi:download" data-width="18" data-height="18"></span>
                                    Exportar Dados
                                </button>
                                <button type="button" class="btn btn-outline-info text-start">
                                    <span class="iconify" data-icon="mdi:help-circle" data-width="18" data-height="18"></span>
                                    Ajuda & Suporte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="perfil-content">
                    <div class="content-wrapper">
                        <div class="alerts-container mb-4">
                            <?php if (!empty($success_perfil)): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                                    <?= $success_perfil ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($erro_perfil)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                                    <?= $erro_perfil ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($success_senha)): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                                    <?= $success_senha ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($erro_senha)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                                    <?= $erro_senha ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card profile-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:account-details" data-width="20" data-height="20"></span>
                                            Informações Pessoais
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="/perfil/atualizar" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                                            <div class="row g-4">
                                                <div class="col-md-6 col-lg-4">
                                                    <label for="nome" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:account" data-width="16" data-height="16"></span>
                                                        Nome Completo
                                                    </label>
                                                    <input type="text" id="nome" name="nome" class="form-control form-control-lg"
                                                        value="<?= $form_data['nome'] ?? $usuario['nome'] ?>"
                                                        placeholder="Seu nome completo" required>
                                                </div>

                                                <div class="col-md-6 col-lg-4">
                                                    <label for="email" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:email" data-width="16" data-height="16"></span>
                                                        E-mail
                                                    </label>
                                                    <input type="email" id="email" name="email" class="form-control form-control-lg"
                                                        value="<?= $form_data['email'] ?? $usuario['email'] ?>"
                                                        placeholder="seu.email@if.com.br" required>
                                                </div>

                                                <div class="col-md-6 col-lg-4">
                                                    <label for="telefone" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:phone" data-width="16" data-height="16"></span>
                                                        Telefone
                                                    </label>
                                                    <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg"
                                                        value="<?= $form_data['telefone'] ?? $usuario['telefone'] ?>"
                                                        placeholder="(00) 00000-0000">
                                                </div>

                                                <div class="col-md-6 col-lg-4">
                                                    <label for="data_nascimento" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:cake" data-width="16" data-height="16"></span>
                                                        Data de Nascimento
                                                    </label>
                                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control form-control-lg"
                                                        value="<?= $form_data['data_nascimento'] ?? ($usuario['data_nascimento'] ? date('Y-m-d', strtotime($usuario['data_nascimento'])) : '') ?>">
                                                </div>

                                                <div class="col-md-6 col-lg-4">
                                                    <label for="tipo_usuario" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:account-tie" data-width="16" data-height="16"></span>
                                                        Tipo de Usuário
                                                    </label>
                                                    <input type="text" id="tipo_usuario" class="form-control form-control-lg"
                                                        value="<?= $usuario['tipo_usuario_formatado'] ?>"
                                                        readonly>
                                                </div>

                                                <div class="col-md-6 col-lg-4">
                                                    <label for="departamento" class="form-label fw-semibold">
                                                        <span class="iconify" data-icon="mdi:office-building" data-width="16" data-height="16"></span>
                                                        Departamento
                                                    </label>
                                                    <input type="text" id="departamento" class="form-control form-control-lg"
                                                        value="<?= $usuario['departamento'] ?? 'Não informado' ?>"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end gap-3 pt-4 mt-4 border-top">
                                                <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="resetForm()">
                                                    <span class="iconify" data-icon="mdi:close" data-width="18" data-height="18"></span>
                                                    Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                                    <span class="iconify" data-icon="mdi:content-save" data-width="18" data-height="18"></span>
                                                    Salvar Alterações
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card profile-card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:shield-account" data-width="20" data-height="20"></span>
                                            Segurança da Conta
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="security-item p-3 border rounded mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="security-icon me-3">
                                                            <span class="iconify text-success" data-icon="mdi:lock-check" data-width="32" data-height="32"></span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="fw-semibold mb-1">Senha Forte</h6>
                                                            <p class="text-muted small mb-0">Sua senha atende aos requisitos de segurança</p>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal">
                                                            Alterar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="security-item p-3 border rounded mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="security-icon me-3">
                                                            <span class="iconify text-warning" data-icon="mdi:two-factor-authentication" data-width="32" data-height="32"></span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="fw-semibold mb-1">Autenticação 2 Fatores</h6>
                                                            <p class="text-muted small mb-0">Não ativado</p>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary">Ativar</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="security-item p-3 border rounded">
                                                    <div class="d-flex align-items-center">
                                                        <div class="security-icon me-3">
                                                            <span class="iconify text-info" data-icon="mdi:history" data-width="32" data-height="32"></span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="fw-semibold mb-1">Atividade Recente</h6>
                                                            <p class="text-muted small mb-0">Último acesso: <?= date('d/m/Y H:i:s') ?></p>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary">Ver Logs</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card profile-card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <span class="iconify" data-icon="mdi:cog" data-width="20" data-height="20"></span>
                                            Preferências do Sistema
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="preferences-grid">
                                            <div class="preference-item d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Tema Escuro</h6>
                                                    <p class="text-muted small mb-0">Interface com cores escuras</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                                                    <label class="form-check-label" for="darkModeSwitch"></label>
                                                </div>
                                            </div>

                                            <div class="preference-item d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Notificações por Email</h6>
                                                    <p class="text-muted small mb-0">Receber alertas importantes</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="emailNotifications" checked>
                                                    <label class="form-check-label" for="emailNotifications"></label>
                                                </div>
                                            </div>

                                            <div class="preference-item d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Idioma do Sistema</h6>
                                                    <p class="text-muted small mb-0">Português Brasileiro</p>
                                                </div>
                                                <select class="form-select form-select-sm" style="width: 140px;">
                                                    <option selected>Português</option>
                                                    <option>English</option>
                                                    <option>Español</option>
                                                </select>
                                            </div>

                                            <div class="preference-item d-flex align-items-center justify-content-between p-3 border rounded">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Fuso Horário</h6>
                                                    <p class="text-muted small mb-0">America/Sao_Paulo</p>
                                                </div>
                                                <select class="form-select form-select-sm" style="width: 160px;">
                                                    <option selected>GMT-3 (Brasília)</option>
                                                    <option>GMT-4 (Manaus)</option>
                                                    <option>GMT-5 (Acre)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="alterarSenhaModal" tabindex="-1" aria-labelledby="alterarSenhaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="alterarSenhaModalLabel">
                        <span class="iconify" data-icon="mdi:lock" data-width="20" data-height="20"></span>
                        Alterar Senha
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/perfil/alterar-senha" method="POST" id="form-alterar-senha">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        
                        <div class="mb-3">
                            <label for="senha_atual" class="form-label fw-semibold">Senha Atual</label>
                            <input type="password" class="form-control" id="senha_atual" name="senha_atual" required
                                   placeholder="Digite sua senha atual">
                        </div>
                        
                        <div class="mb-3">
                            <label for="nova_senha" class="form-label fw-semibold">Nova Senha</label>
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" required 
                                   minlength="6" placeholder="Mínimo 6 caracteres">
                            <div class="form-text">A senha deve ter pelo menos 6 caracteres.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirmar_nova_senha" class="form-label fw-semibold">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirmar_nova_senha" name="confirmar_nova_senha" required
                                   placeholder="Digite a nova senha novamente">
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Alterar Senha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script src="/assets/js/perfil.js"></script>

    <?php $this->renderComponent('footer'); ?>
</body>
</html>