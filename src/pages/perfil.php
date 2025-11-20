<?php
$pageTitle = "Perfil - Sistema IF";
$currentPage = 'perfil';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';

require_once __DIR__ . '/../config/db.php';

try {
    $usuario_id = $_SESSION['usuario_id'] ?? null;
    $usuario_email = $_COOKIE['usuario_email'] ?? $_SESSION['usuario_email'] ?? null;
    
    if (!$usuario_id && !$usuario_email) {
        throw new Exception('Usuário não identificado.');
    }
    
    if ($usuario_id) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$usuario_email]);
    }
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        throw new Exception('Usuário não encontrado.');
    }
    
    $usuario_formatado = [
        'id' => $usuario['id'],
        'nome' => htmlspecialchars($usuario['nome']),
        'email' => htmlspecialchars($usuario['email']),
        'telefone' => $usuario['telefone'] ? htmlspecialchars($usuario['telefone']) : 'Não informado',
        'data_nascimento' => $usuario['data_nascimento'] ? date('d/m/Y', strtotime($usuario['data_nascimento'])) : 'Não informada',
        'tipo_usuario' => htmlspecialchars($usuario['tipo_usuario']),
        'status' => $usuario['status'],
        'data_cadastro' => $usuario['criado_em'],
        'ultimo_acesso' => $usuario['atualizado_em'] ? date('d/m/Y H:i:s', strtotime($usuario['atualizado_em'])) : 'Nunca'
    ];
    
    $tipos_usuario = [
        'gerente' => 'Gerente',
        'vendedor' => 'Vendedor',
        'estoque' => 'Estoque',
        'visualizador' => 'Visualizador'
    ];
    
    $usuario_formatado['tipo_usuario_formatado'] = $tipos_usuario[$usuario['tipo_usuario']] ?? 'Visualizador';
    
} catch (Exception $e) {
    error_log("Erro ao carregar perfil: " . $e->getMessage());
    $usuario_formatado = [
        'nome' => $nome_usuario,
        'email' => 'Não disponível',
        'telefone' => 'Não informado',
        'data_nascimento' => 'Não informada',
        'tipo_usuario_formatado' => 'Usuário',
        'status' => 'ativo',
        'data_cadastro' => date('Y-m-d'),
        'ultimo_acesso' => date('d/m/Y H:i:s')
    ];
}
?>

<main style="min-height: calc(100vh - 120px); padding: 20px 0;">
    <div class="container mt-4">
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
                        <form action="/processa_edicao_perfil" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label fw-semibold">Nome Completo</label>
                                    <input type="text" id="nome" name="nome" class="form-control form-control-lg"
                                        value="<?= $usuario_formatado['nome'] ?>"
                                        placeholder="Seu nome completo">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-lg"
                                        value="<?= $usuario_formatado['email'] ?>"
                                        placeholder="seu.email@if.com.br">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                    <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg"
                                        value="<?= $usuario_formatado['telefone'] ?>"
                                        placeholder="(00) 00000-0000">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="data_nascimento" class="form-label fw-semibold">Data de Nascimento</label>
                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control form-control-lg"
                                        value="<?= $usuario['data_nascimento'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_usuario" class="form-label fw-semibold">Tipo de Usuário</label>
                                    <input type="text" id="tipo_usuario" name="tipo_usuario" class="form-control form-control-lg"
                                        value="<?= $usuario_formatado['tipo_usuario_formatado'] ?>"
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
                            <h6 class="fw-bold mb-1"><?= $usuario_formatado['nome'] ?></h6>
                            <p class="text-muted small mb-0"><?= $usuario_formatado['tipo_usuario_formatado'] ?></p>
                            <p class="text-muted small mb-0"><?= $usuario_formatado['departamento'] ?></p>
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
                                <span class="fw-semibold">#<?= $usuario_formatado['id'] ?? 'N/A' ?></span>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Data de Cadastro</span>
                                <span class="fw-semibold"><?= date('d/m/Y', strtotime($usuario_formatado['data_cadastro'])) ?></span>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Último Acesso</span>
                                <span class="fw-semibold"><?= $usuario_formatado['ultimo_acesso'] ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Status da Conta</span>
                                <span class="badge bg-<?= $usuario_formatado['status'] === 'ativo' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($usuario_formatado['status']) ?>
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
                <form action="/processa_alteracao_senha" method="POST">
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

<style>
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
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
</style>

<script>
    let originalFormData = {};
    
    document.addEventListener('DOMContentLoaded', function() {
        // Capturar estado original do formulário
        const form = document.querySelector('form');
        const formData = new FormData(form);
        for (let [key, value] of formData.entries()) {
            originalFormData[key] = value;
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

<?php
include_once 'src/components/Footer.php';
?>