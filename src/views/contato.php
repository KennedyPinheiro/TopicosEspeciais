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

        .contact-info-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border: 1px solid rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .contact-info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-dark);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .bg-gradient-blue {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .bg-gradient-green {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        .bg-gradient-purple {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-hover), #1d4ed8);
            transform: translateY(-1px);
        }

        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
        }
    </style>
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]);
    ?>

    <main style="min-height: calc(100vh - 120px); padding: 20px 0;">
        <div class="container mt-4">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-4 bg-gradient-primary text-white rounded-3 shadow">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-6 fw-bold">Entre em Contato</h1>
                                <p class="lead mb-0 opacity-75">Estamos aqui para ajudar. Envie sua mensagem!</p>
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:email-send" data-width="20" data-height="20"></span>
                                Envie sua Mensagem
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="/contato/processar" method="POST" id="form-contato">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nome" class="form-label fw-semibold">Nome Completo <span class="text-danger">*</span></label>
                                        <input type="text" id="nome" name="nome"
                                            class="form-control form-control-lg <?= hasError('nome') ?>"
                                            value="<?= getFormValue('nome') ?>"
                                            placeholder="Seu nome completo" required>
                                        <?php if (getError('nome')): ?>
                                            <div class="invalid-feedback"><?= getError('nome') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-lg <?= hasError('email') ?>"
                                            value="<?= getFormValue('email') ?>"
                                            placeholder="seu.email@exemplo.com" required>
                                        <?php if (getError('email')): ?>
                                            <div class="invalid-feedback"><?= getError('email') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="assunto" class="form-label fw-semibold">Assunto <span class="text-danger">*</span></label>
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

                                <div class="mb-3">
                                    <label for="mensagem" class="form-label fw-semibold">Mensagem <span class="text-danger">*</span></label>
                                    <textarea id="mensagem" name="mensagem"
                                        class="form-control <?= hasError('mensagem') ?>"
                                        rows="6"
                                        placeholder="Descreva sua dúvida, sugestão ou problema..."
                                        required><?= getFormValue('mensagem') ?></textarea>
                                    <?php if (getError('mensagem')): ?>
                                        <div class="invalid-feedback"><?= getError('mensagem') ?></div>
                                    <?php endif; ?>
                                    <div class="form-text">Mínimo 10 caracteres</div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
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
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                Informações de Contato
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="contact-info-card card border-0 p-4 mb-3">
                                <div class="contact-icon bg-gradient-blue text-white">
                                    <span class="iconify" data-icon="mdi:email" data-width="24" data-height="24"></span>
                                </div>
                                <h6 class="text-center fw-bold mb-2">Email</h6>
                                <p class="text-center text-muted mb-0">contato@sistemaif.edu.br</p>
                                <p class="text-center text-muted mb-0">suporte@sistemaif.edu.br</p>
                            </div>

                            <div class="contact-info-card card border-0 p-4 mb-3">
                                <div class="contact-icon bg-gradient-green text-white">
                                    <span class="iconify" data-icon="mdi:phone" data-width="24" data-height="24"></span>
                                </div>
                                <h6 class="text-center fw-bold mb-2">Telefone</h6>
                                <p class="text-center text-muted mb-0">(11) 3456-7890</p>
                                <p class="text-center text-muted mb-0">(11) 98765-4321</p>
                            </div>

                            <div class="contact-info-card card border-0 p-4">
                                <div class="contact-icon bg-gradient-purple text-white">
                                    <span class="iconify" data-icon="mdi:clock" data-width="24" data-height="24"></span>
                                </div>
                                <h6 class="text-center fw-bold mb-2">Horário de Atendimento</h6>
                                <p class="text-center text-muted mb-0">Segunda a Sexta: 8h às 18h</p>
                                <p class="text-center text-muted mb-0">Sábado: 8h às 12h</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
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
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h5 class="card-title mb-0 fw-bold">
                                <span class="iconify" data-icon="mdi:map-marker" data-width="20" data-height="20"></span>
                                Nossa Localização
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
                            <div class="p-4">
                                <h6 class="fw-bold">IFNMG - Campus Almenara</h6>
                                <p class="text-muted mb-0">Rua Um, S/N - Zona Rural, Almenara - MG, 39900-000</p>
                                <p class="text-muted mb-0">Telefone: (33) 3421-0000</p>
                                <p class="text-muted mb-0">Email: almenara@ifnmg.edu.br</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        let originalFormData = {};

        document.addEventListener('DOMContentLoaded', function() {
            // Capturar estado original do formulário
            const form = document.getElementById('form-contato');
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                originalFormData[key] = value;
            }

            // Validação em tempo real
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });

            // Validação no envio
            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Rolar para o primeiro erro
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });
        });

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;

            // Remover estado anterior
            field.classList.remove('is-invalid', 'is-valid');

            // Validações específicas
            if (field.required && !value) {
                field.classList.add('is-invalid');
                isValid = false;
            } else if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            } else if (field.name === 'mensagem' && value.length < 10) {
                field.classList.add('is-invalid');
                isValid = false;
            }

            if (isValid && value) {
                field.classList.add('is-valid');
            }

            return isValid;
        }

        function resetForm() {
            const form = document.getElementById('form-contato');
            form.reset();

            // Limpar estados de validação
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
        }

        // Contador de caracteres para mensagem
        const mensagemTextarea = document.getElementById('mensagem');
        if (mensagemTextarea) {
            mensagemTextarea.addEventListener('input', function() {
                const count = this.value.length;
                const counter = this.parentElement.querySelector('.form-text');
                if (counter) {
                    counter.textContent = `${count} caracteres${count < 10 ? ' (mínimo 10)' : ''}`;

                    if (count < 10) {
                        counter.classList.add('text-danger');
                    } else {
                        counter.classList.remove('text-danger');
                        counter.classList.add('text-success');
                    }
                }
            });
        }
    </script>

    <?php $this->renderComponent('footer'); ?>
</body>

</html>