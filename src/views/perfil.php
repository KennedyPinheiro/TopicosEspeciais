<?php
$pageTitle = "Perfil - Sistema IF";

$success_perfil = $this->getFlash('success_perfil') ?? '';
$erro_perfil = $this->getFlash('erro_perfil') ?? '';
$success_senha = $this->getFlash('success_senha') ?? '';
$erro_senha = $this->getFlash('erro_senha') ?? '';

$form_data = $this->getFlash('form_data') ?? [];

if (!isset($usuario)) {
    $usuario = [
        'nome' => $_COOKIE['nome_usuario'] ?? 'Usuário',
        'email' => $_COOKIE['usuario_email'] ?? 'Não disponível',
        'telefone' => 'Não informado',
        'data_nascimento' => '',
        'tipo_usuario_formatado' => 'Usuário',
        'status' => 'ativo',
        'data_cadastro' => date('Y-m-d'),
        'ultimo_acesso' => date('d/m/Y H:i:s'),
        'id' => $_SESSION['usuario_id'] ?? 'N/A',
        'departamento' => 'Não informado'
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%) !important;
            border: none;
        }

        .avatar-container {
            display: flex;
            justify-content: center;
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .user-info {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .info-item {
            padding: 0.5rem 0;
        }

        .info-item:not(:last-child) {
            border-bottom: 1px solid #e9ecef;
        }

        .security-item {
            transition: all 0.2s ease;
        }

        .security-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn.text-start {
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #6c757d;
        }

        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php $this->renderComponent('header'); ?>

    <main style="min-height: calc(100vh - 120px); padding: 20px 0;">
        <div class="container mt-4">
            <?php if ($success_perfil): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                    <?= $success_perfil ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($erro_perfil): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                    <?= $erro_perfil ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($success_senha): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                    <?= $success_senha ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($erro_senha): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                    <?= $erro_senha ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-4 bg-gradient-primary text-white rounded-3 shadow">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-6 fw-bold">Meu Perfil</h1>
                                <p class="lead mb-0 opacity-75">Gerencie suas informações pessoais e preferências</p>
                            </div>
                            <div class="text-end">
                                <a href="/home" class="btn btn-light btn-lg px-4">
                                    <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:account-details" data-width="20" data-height="20"></span>
                                Informações Pessoais
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="/perfil/atualizar" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nome" class="form-label fw-semibold">Nome Completo</label>
                                        <input type="text" id="nome" name="nome" class="form-control form-control-lg"
                                            value="<?= $form_data['nome'] ?? $usuario['nome'] ?>"
                                            placeholder="Seu nome completo" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-semibold">E-mail</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                                            value="<?= $form_data['email'] ?? $usuario['email'] ?>"
                                            placeholder="seu.email@if.com.br" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                        <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg"
                                            value="<?= $form_data['telefone'] ?? $usuario['telefone'] ?>"
                                            placeholder="(00) 00000-0000">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="data_nascimento" class="form-label fw-semibold">Data de Nascimento</label>
                                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control form-control-lg"
                                            value="<?= $form_data['data_nascimento'] ?? ($usuario['data_nascimento'] ? date('Y-m-d', strtotime($usuario['data_nascimento'])) : '') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_usuario" class="form-label fw-semibold">Tipo de Usuário</label>
                                        <input type="text" id="tipo_usuario" class="form-control form-control-lg"
                                            value="<?= $usuario['tipo_usuario_formatado'] ?>"
                                            readonly>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="resetForm()">Cancelar</button>
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <span class="iconify" data-icon="mdi:content-save" data-width="20" data-height="20"></span>
                                        Salvar Alterações
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
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

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
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

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:cog" data-width="20" data-height="20"></span>
                                Configurações Rápidas
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:shield-account" data-width="20" data-height="20"></span>
                                Segurança da Conta
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="security-item text-center p-3 border rounded">
                                        <span class="iconify text-success mb-2" data-icon="mdi:lock-check" data-width="32" data-height="32"></span>
                                        <h6 class="fw-semibold">Senha Forte</h6>
                                        <p class="text-muted small mb-0">Sua senha atende aos requisitos de segurança</p>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal">
                                            Alterar Senha
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="security-item text-center p-3 border rounded">
                                        <span class="iconify text-warning mb-2" data-icon="mdi:two-factor-authentication" data-width="32" data-height="32"></span>
                                        <h6 class="fw-semibold">Autenticação 2 Fatores</h6>
                                        <p class="text-muted small mb-0">Não ativado</p>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-2">Ativar</button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="security-item text-center p-3 border rounded">
                                        <span class="iconify text-info mb-2" data-icon="mdi:history" data-width="32" data-height="32"></span>
                                        <h6 class="fw-semibold">Atividade Recente</h6>
                                        <p class="text-muted small mb-0">Último acesso: <?= date('d/m/Y') ?></p>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-2">Ver Logs</button>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="alterarSenhaModalLabel">
                        <span class="iconify" data-icon="mdi:lock" data-width="20" data-height="20"></span>
                        Alterar Senha
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/perfil/alterar-senha" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <div class="mb-3">
                            <label for="senha_atual" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                        </div>
                        <div class="mb-3">
                            <label for="nova_senha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_nova_senha" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirmar_nova_senha" name="confirmar_nova_senha" required>
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

    <script>
        let originalFormData = {};

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                originalFormData[key] = value;
            }

            const telefoneInput = document.getElementById('telefone');
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length <= 11) {
                        if (value.length <= 2) {
                            value = value.replace(/^(\d{0,2})/, '($1');
                        } else if (value.length <= 6) {
                            value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
                        } else if (value.length <= 10) {
                            value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                        } else {
                            value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                        }
                        e.target.value = value;
                    }
                });
            }
        });

        function resetForm() {
            const form = document.querySelector('form');
            for (let [key, value] of Object.entries(originalFormData)) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = value;
                }
            }
        }
    </script>

    <?php $this->renderComponent('footer'); ?>
</body>

</html>