<?php

$pageTitle = "Sobre - Sistema IF";
$currentPage = "sobre";
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
    <link rel="stylesheet" href="/assets/css/sobre.css">
</head>

<body>
    <?php
    $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $this->renderComponent('header', ['currentPage' => $currentPage, 'nome_usuario' => $nome_usuario]);
    ?>

    <main class="sobre-container">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="display-6 fw-bold">Sobre o Sistema</h1>
                        <p class="lead mb-3 opacity-75">Conheça mais sobre nossa aplicação e sua arquitetura</p>
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
            <div class="sobre-layout">
                <div class="sobre-sidebar">
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:chip" data-width="20" data-height="20"></span>
                                Informações Técnicas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Versão</span>
                                    <span class="fw-semibold">v<?= $infoSistema['versao'] ?? '1.0.0' ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Desenvolvedor</span>
                                    <span class="fw-semibold"><?= $infoSistema['desenvolvedor'] ?? 'Kennedy Pinheiro' ?></span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Instituição</span>
                                    <span class="fw-semibold"><?= $infoSistema['instituicao'] ?? 'IFNMG' ?></span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Ano</span>
                                    <span class="fw-semibold"><?= $infoSistema['ano'] ?? date('Y') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:tools" data-width="20" data-height="20"></span>
                                Tecnologias
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <?php
                                $tecnologias = $infoSistema['tecnologias'] ?? ['PHP', 'MySQL', 'Bootstrap 5', 'JavaScript', 'jQuery', 'Select2'];
                                foreach ($tecnologias as $tech):
                                ?>
                                    <span class="tech-badge badge bg-light text-dark border text-start">
                                        <span class="iconify me-2" data-icon="mdi:check" data-width="16" data-height="16" style="color: #10b981;"></span>
                                        <?= $tech ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <span class="iconify" data-icon="mdi:link" data-width="20" data-height="20"></span>
                                Links Rápidos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="https://www.ifnmg.edu.br/" class="btn btn-outline-primary text-start" target="_blank">
                                    <span class="iconify" data-icon="mdi:school" data-width="18" data-height="18"></span>
                                    Site IFNMG
                                </a>
                                <a href="https://github.com/KennedyPinheiro" class="btn btn-outline-dark text-start" target="_blank">
                                    <span class="iconify" data-icon="mdi:github" data-width="18" data-height="18"></span>
                                    GitHub
                                </a>
                                <a href="/contato" class="btn btn-outline-success text-start">
                                    <span class="iconify" data-icon="mdi:email" data-width="18" data-height="18"></span>
                                    Contato
                                </a>
                                <a href="/documentacao" class="btn btn-outline-info text-start">
                                    <span class="iconify" data-icon="mdi:file-document" data-width="18" data-height="18"></span>
                                    Documentação
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sobre-content">
                    <div class="content-wrapper">
                        <div class="card profile-card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                    Sobre o Projeto
                                </h5>
                            </div>
                            <div class="card-body">
                                <h4 class="fw-bold text-primary mb-3">Sistema de Gerenciamento</h4>
                                <p class="lead mb-4">
                                    Esta aplicação web foi desenvolvida como parte de uma atividade acadêmica para demonstrar
                                    a implementação de um sistema completo com autenticação de usuários e gerenciamento de produtos.
                                </p>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="feature-highlight p-3 border rounded">
                                            <h6 class="fw-bold mb-3">
                                                <span class="iconify" data-icon="mdi:target" data-width="20" data-height="20"></span>
                                                Objetivos do Sistema
                                            </h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:check" style="color: #10b981;"></span>
                                                    Autenticação segura de usuários
                                                </li>
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:check" style="color: #10b981;"></span>
                                                    Cadastro e gerenciamento de produtos
                                                </li>
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:check" style="color: #10b981;"></span>
                                                    Interface responsiva e intuitiva
                                                </li>
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:check" style="color: #10b981;"></span>
                                                    Arquitetura em duas camadas
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="feature-highlight p-3 border rounded">
                                            <h6 class="fw-bold mb-3">
                                                <span class="iconify" data-icon="mdi:architecture" data-width="20" data-height="20"></span>
                                                Arquitetura
                                            </h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:database" style="color: #3b82f6;"></span>
                                                    <strong>Camada 1:</strong> Banco de Dados MySQL
                                                </li>
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:application" style="color: #8b5cf6;"></span>
                                                    <strong>Camada 2:</strong> Aplicação PHP
                                                </li>
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:security" style="color: #f59e0b;"></span>
                                                    Sessões PHP para autenticação
                                                </li>
                                                <li class="mb-2">
                                                    <span class="iconify me-2" data-icon="mdi:responsive" style="color: #10b981;"></span>
                                                    Interface com Bootstrap 5
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card profile-card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <span class="iconify" data-icon="mdi:feature-search" data-width="20" data-height="20"></span>
                                    Funcionalidades Principais
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card text-center p-3 border rounded h-100">
                                            <div class="feature-icon bg-primary mb-3">
                                                <span class="iconify" data-icon="mdi:login" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Sistema de Login</h6>
                                            <p class="text-muted small mb-0">
                                                Autenticação segura com verificação no banco de dados e sessões PHP.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card text-center p-3 border rounded h-100">
                                            <div class="feature-icon bg-success mb-3">
                                                <span class="iconify" data-icon="mdi:account-plus" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Cadastro de Usuários</h6>
                                            <p class="text-muted small mb-0">
                                                Registro de novos usuários com senhas criptografadas em SHA512.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card text-center p-3 border rounded h-100">
                                            <div class="feature-icon bg-purple mb-3">
                                                <span class="iconify" data-icon="mdi:package-variant" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Gerenciar Produtos</h6>
                                            <p class="text-muted small mb-0">
                                                CRUD completo para produtos: Cadastrar, Listar e Excluir.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card text-center p-3 border rounded h-100">
                                            <div class="feature-icon bg-warning mb-3">
                                                <span class="iconify" data-icon="mdi:cash-register" data-width="24" data-height="24"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Sistema de Vendas</h6>
                                            <p class="text-muted small mb-0">
                                                Registro de vendas, histórico e estornos com controle completo.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <span class="iconify" data-icon="mdi:folder-structure" data-width="20" data-height="20"></span>
                                    Estrutura do Projeto
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="structure-section">
                                            <h6 class="fw-bold mb-3">
                                                <span class="iconify" data-icon="mdi:folder" data-width="20" data-height="20"></span>
                                                Organização de Arquivos
                                            </h6>
                                            <div class="timeline">
                                                <div class="timeline-item">
                                                    <h6 class="fw-bold text-primary">/app/Controllers/</h6>
                                                    <p class="text-muted small mb-0">
                                                        Controladores que processam as requisições e interagem com os modelos
                                                    </p>
                                                </div>
                                                <div class="timeline-item">
                                                    <h6 class="fw-bold text-primary">/app/Models/</h6>
                                                    <p class="text-muted small mb-0">
                                                        Modelos que representam as entidades do banco de dados
                                                    </p>
                                                </div>
                                                <div class="timeline-item">
                                                    <h6 class="fw-bold text-primary">/app/Services/</h6>
                                                    <p class="text-muted small mb-0">
                                                        Serviços com a lógica de negócio da aplicação
                                                    </p>
                                                </div>
                                                <div class="timeline-item">
                                                    <h6 class="fw-bold text-primary">/src/views/</h6>
                                                    <p class="text-muted small mb-0">
                                                        Telas e interfaces do usuário
                                                    </p>
                                                </div>
                                                <div class="timeline-item">
                                                    <h6 class="fw-bold text-primary">/src/components/</h6>
                                                    <p class="text-muted small mb-0">
                                                        Componentes reutilizáveis (header, footer, etc)
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="structure-section">
                                            <h6 class="fw-bold mb-3">
                                                <span class="iconify" data-icon="mdi:database" data-width="20" data-height="20"></span>
                                                Estrutura do Banco
                                            </h6>
                                            <div class="database-structure">
                                                <div class="table-card mb-3">
                                                    <h6 class="fw-bold text-success mb-2">
                                                        <span class="iconify" data-icon="mdi:account" data-width="16" data-height="16"></span>
                                                        Tabela: usuarios
                                                    </h6>
                                                    <ul class="list-unstyled small mb-0">
                                                        <li>• id (PK, Auto Increment)</li>
                                                        <li>• nome (VARCHAR)</li>
                                                        <li>• email (VARCHAR, Unique)</li>
                                                        <li>• senha (VARCHAR - SHA512)</li>
                                                        <li>• tipo_usuario (ENUM)</li>
                                                        <li>• criado_em (TIMESTAMP)</li>
                                                    </ul>
                                                </div>

                                                <div class="table-card mb-3">
                                                    <h6 class="fw-bold text-success mb-2">
                                                        <span class="iconify" data-icon="mdi:package" data-width="16" data-height="16"></span>
                                                        Tabela: produtos
                                                    </h6>
                                                    <ul class="list-unstyled small mb-0">
                                                        <li>• id (PK, Auto Increment)</li>
                                                        <li>• nome (VARCHAR)</li>
                                                        <li>• descricao (TEXT)</li>
                                                        <li>• preco (DECIMAL)</li>
                                                        <li>• quantidade (INT)</li>
                                                        <li>• criado_em (TIMESTAMP)</li>
                                                    </ul>
                                                </div>

                                                <div class="table-card">
                                                    <h6 class="fw-bold text-success mb-2">
                                                        <span class="iconify" data-icon="mdi:cash-register" data-width="16" data-height="16"></span>
                                                        Tabela: vendas
                                                    </h6>
                                                    <ul class="list-unstyled small mb-0">
                                                        <li>• id (PK, Auto Increment)</li>
                                                        <li>• produto_id (INT, FK produtos)</li>
                                                        <li>• quantidade (INT)</li>
                                                        <li>• preco_unitario (DECIMAL)</li>
                                                        <li>• total_venda (DECIMAL)</li>
                                                        <li>• data_venda (DATETIME)</li>
                                                        <li>• usuario_id (INT)</li>
                                                        <li>• observacoes (TEXT)</li>
                                                        <li>• estornada (TINYINT)</li>
                                                        <li>• usuario_estorno (INT)</li>
                                                        <li>• data_estorno (DATETIME)</li>
                                                    </ul>
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
        </div>
    </main>

    <?php $this->renderComponent('footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</body>

</html>