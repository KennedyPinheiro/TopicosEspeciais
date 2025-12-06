<?php

$pageTitle = "Contato - Sistema IF";
$currentPage = "contato";

$sucesso = $this->getFlash('sucesso') ?? '';
$erro = $this->getFlash('erro') ?? '';
$msg = $this->getFlash('msg') ?? '';

$form_data = $this->getFlash('form_data') ?? [];
$form_errors = $this->getFlash('form_errors') ?? [];

function getFormValue($field, $default = '')
{
    global $form_data;
    return htmlspecialchars($form_data[$field] ?? $default);
}

function hasError($field)
{
    global $form_errors;
    return isset($form_errors[$field]) ? 'is-invalid' : '';
}

function getError($field)
{
    global $form_errors;
    return $form_errors[$field] ?? '';
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/contato.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]);
    ?>

    <main class="contato-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Entre em Contato</h1>
                        <p class="lead mb-3 opacity-75">Estamos aqui para ajudar. Envie sua mensagem!</p>
                    </div>
                    <div class="header-actions">
                        <a href="/home" class="btn btn-light btn-lg px-4">
                            <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="contato-layout">
                <div class="contato-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                Informações de Contato
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="contact-info-item mb-3">
                                <div class="contact-icon bg-primary">
                                    <span class="iconify" data-icon="mdi:email" data-width="20" data-height="20"></span>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-semibold mb-1">Email</h6>
                                    <p class="text-muted mb-0 small">contato@sistemaif.edu.br</p>
                                    <p class="text-muted mb-0 small">suporte@sistemaif.edu.br</p>
                                </div>
                            </div>

                            <div class="contact-info-item mb-3">
                                <div class="contact-icon bg-success">
                                    <span class="iconify" data-icon="mdi:phone" data-width="20" data-height="20"></span>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-semibold mb-1">Telefone</h6>
                                    <p class="text-muted mb-0 small">(11) 3456-7890</p>
                                    <p class="text-muted mb-0 small">(11) 98765-4321</p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon bg-warning">
                                    <span class="iconify" data-icon="mdi:clock" data-width="20" data-height="20"></span>
                                </div>
                                <div class="contact-details">
                                    <h6 class="fw-semibold mb-1">Horário de Atendimento</h6>
                                    <p class="text-muted mb-0 small">Segunda a Sexta: 8h às 18h</p>
                                    <p class="text-muted mb-0 small">Sábado: 8h às 12h</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:share-variant" data-width="20" data-height="20"></span>
                                Redes Sociais
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="https://www.instagram.com/_pinheirokennedy/"
                                    class="btn btn-outline-danger text-start" target="_blank">
                                    <span class="iconify" data-icon="mdi:instagram" data-width="18" data-height="18"></span>
                                    Instagram
                                </a>
                                <a href="https://github.com/KennedyPinheiro"
                                    class="btn btn-outline-dark text-start" target="_blank">
                                    <span class="iconify" data-icon="mdi:github" data-width="18" data-height="18"></span>
                                    GitHub
                                </a>
                                <a href="https://www.linkedin.com/in/kennedy-pinheiro-918184299/"
                                    class="btn btn-outline-primary text-start" target="_blank">
                                    <span class="iconify" data-icon="mdi:linkedin" data-width="18" data-height="18"></span>
                                    LinkedIn
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:map-marker" data-width="20" data-height="20"></span>
                                Nossa Localização
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="location-info">
                                <h6 class="fw-semibold mb-2">IFNMG - Campus Almenara</h6>
                                <p class="text-muted small mb-2">
                                    <span class="iconify" data-icon="mdi:map" data-width="16" data-height="16"></span>
                                    Rua Um, S/N - Zona Rural, Almenara - MG, 39900-000
                                </p>
                                <p class="text-muted small mb-2">
                                    <span class="iconify" data-icon="mdi:phone" data-width="16" data-height="16"></span>
                                    (33) 3421-0000
                                </p>
                                <p class="text-muted small mb-0">
                                    <span class="iconify" data-icon="mdi:email" data-width="16" data-height="16"></span>
                                    almenara@ifnmg.edu.br
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contato-content">
                    <div class="content-wrapper">
                        <div class="alerts-container mb-4">
                            <?php if ($sucesso): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:check-circle" data-width="20" data-height="20"></span>
                                    <?php
                                    $mensagensSucesso = [
                                        'mensagem_enviada' => '✅ Mensagem enviada com sucesso! Entraremos em contato em breve.'
                                    ];
                                    echo $mensagensSucesso[$sucesso] ?? '✅ Operação realizada com sucesso.';
                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if ($erro): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="iconify" data-icon="mdi:alert-circle" data-width="20" data-height="20"></span>
                                    <?php
                                    $mensagens = [
                                        'campos_invalidos' => '❌ Por favor, corrija os erros no formulário.',
                                        'erro_envio' => '❌ Erro ao enviar mensagem. Tente novamente.',
                                        'metodo_nao_permitido' => '❌ Método não permitido.'
                                    ];
                                    echo $mensagens[$erro] ?? '❌ Erro desconhecido.';
                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <span class="iconify" data-icon="mdi:email-send" data-width="20" data-height="20"></span>
                                    Envie sua Mensagem
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="/contato/processar" method="POST" id="form-contato">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nome" class="form-label fw-semibold">
                                                <span class="iconify" data-icon="mdi:account" data-width="16" data-height="16"></span>
                                                Nome Completo <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="nome" name="nome"
                                                class="form-control form-control-lg <?= hasError('nome') ?>"
                                                value="<?= getFormValue('nome') ?>"
                                                placeholder="Seu nome completo" required>
                                            <?php if (getError('nome')): ?>
                                                <div class="invalid-feedback"><?= getError('nome') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold">
                                                <span class="iconify" data-icon="mdi:email" data-width="16" data-height="16"></span>
                                                E-mail <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg <?= hasError('email') ?>"
                                                value="<?= getFormValue('email') ?>"
                                                placeholder="seu.email@exemplo.com" required>
                                            <?php if (getError('email')): ?>
                                                <div class="invalid-feedback"><?= getError('email') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12">
                                            <label for="assunto" class="form-label fw-semibold">
                                                <span class="iconify" data-icon="mdi:tag" data-width="16" data-height="16"></span>
                                                Assunto <span class="text-danger">*</span>
                                            </label>
                                            <select id="assunto" name="assunto" class="form-select form-select-lg <?= hasError('assunto') ?>" required>
                                                <option value="">Selecione um assunto</option>
                                                <option value="suporte" <?= getFormValue('assunto') === 'suporte' ? 'selected' : '' ?>>Suporte Técnico</option>
                                                <option value="vendas" <?= getFormValue('assunto') === 'vendas' ? 'selected' : '' ?>>Vendas</option>
                                                <option value="parceria" <?= getFormValue('assunto') === 'parceria' ? 'selected' : '' ?>>Parceria</option>
                                                <option value="sugestao" <?= getFormValue('assunto') === 'sugestao' ? 'selected' : '' ?>>Sugestão</option>
                                                <option value="outro" <?= getFormValue('assunto') === 'outro' ? 'selected' : '' ?>>Outro</option>
                                            </select>
                                            <?php if (getError('assunto')): ?>
                                                <div class="invalid-feedback"><?= getError('assunto') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12">
                                            <label for="mensagem" class="form-label fw-semibold">
                                                <span class="iconify" data-icon="mdi:text" data-width="16" data-height="16"></span>
                                                Mensagem <span class="text-danger">*</span>
                                            </label>
                                            <textarea id="mensagem" name="mensagem"
                                                class="form-control <?= hasError('mensagem') ?>"
                                                rows="6"
                                                placeholder="Descreva sua dúvida, sugestão ou problema..."
                                                required><?= getFormValue('mensagem') ?></textarea>
                                            <?php if (getError('mensagem')): ?>
                                                <div class="invalid-feedback"><?= getError('mensagem') ?></div>
                                            <?php endif; ?>
                                            <div class="form-text">
                                                <span class="iconify" data-icon="mdi:information" data-width="16" data-height="16"></span>
                                                Mínimo 10 caracteres
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-3 pt-4 mt-4 border-top">
                                        <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="resetForm()">
                                            <span class="iconify" data-icon="mdi:refresh" data-width="20" data-height="20"></span>
                                            Limpar
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <span class="iconify" data-icon="mdi:send" data-width="20" data-height="20"></span>
                                            Enviar Mensagem
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card profile-card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <span class="iconify" data-icon="mdi:map" data-width="20" data-height="20"></span>
                                    Localização no Mapa
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="map-container">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3789.215984665057!2d-40.68685292501944!3d-16.179221983993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb3c0b6f6a9d7a9%3A0x8a7b6c6c6c6c6c6c!2sIFNMG%20-%20Campus%20Almenara!5e0!3m2!1spt-BR!2sbr!4v1690000000000!5m2!1spt-BR!2sbr"
                                        width="100%"
                                        height="300"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script src="/assets/js/contato.js"></script>

    <?php $this->renderComponent('footer'); ?>
</body>

</html>