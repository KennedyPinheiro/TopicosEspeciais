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

    <main style="min-height: calc(100vh - 120px); background: white;">
        <div class="full-width-header">
            <div class="container-fluid">
                <div class="p-4 bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-6 fw-bold">Sobre o Sistema</h1>
                            <p class="lead mb-0 opacity-75">Conheça mais sobre nossa aplicação e sua arquitetura</p>
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

        <div class="container-fluid px-4 py-5" style="background: white;">
            <div class="content-wrapper">
                <div class="row mb-5">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                    Sobre o Projeto
                                </h5>
                            </div>
                            <div class="card-body">
                                <h4 class="fw-bold text-primary mb-3">Sistema de Gerenciamento</h4>
                                <p class="lead">
                                    Esta aplicação web foi desenvolvida como parte de uma atividade acadêmica para demonstrar
                                    a implementação de um sistema completo com autenticação de usuários e gerenciamento de produtos.
                                </p>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">🎯 Objetivos do Sistema</h6>
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
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">🏗️ Arquitetura</h6>
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

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:chip" data-width="20" data-height="20"></span>
                                    Informações Técnicas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-muted mb-2">Versão do Sistema</h6>
                                    <span class="badge bg-primary fs-6">v<?= $infoSistema['versao'] ?></span>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold text-muted mb-2">Desenvolvedor</h6>
                                    <p class="mb-1"><?= $infoSistema['desenvolvedor'] ?></p>
                                    <small class="text-muted"><?= $infoSistema['instituicao'] ?></small>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold text-muted mb-3">Tecnologias Utilizadas</h6>
                                    <div class="d-flex flex-wrap">
                                        <?php foreach ($infoSistema['tecnologias'] as $tech): ?>
                                            <span class="badge tech-badge bg-light text-dark border">
                                                <?= $tech ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <small class="text-muted">
                                        <span class="iconify" data-icon="mdi:calendar" data-width="16" data-height="16"></span>
                                        Desenvolvido em <?= $infoSistema['ano'] ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:feature-search" data-width="20" data-height="20"></span>
                                    Funcionalidades Principais
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card card border-0 p-4 text-center">
                                            <div class="feature-icon bg-gradient-blue text-white">
                                                <span class="iconify" data-icon="mdi:login" data-width="32" data-height="32"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Sistema de Login</h6>
                                            <p class="text-muted small mb-0">
                                                Autenticação segura com verificação no banco de dados e sessões PHP.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card card border-0 p-4 text-center">
                                            <div class="feature-icon bg-gradient-green text-white">
                                                <span class="iconify" data-icon="mdi:account-plus" data-width="32" data-height="32"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Cadastro de Usuários</h6>
                                            <p class="text-muted small mb-0">
                                                Registro de novos usuários com senhas criptografadas em SHA512.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card card border-0 p-4 text-center">
                                            <div class="feature-icon bg-gradient-purple text-white">
                                                <span class="iconify" data-icon="mdi:package-variant" data-width="32" data-height="32"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Gerenciar Produtos</h6>
                                            <p class="text-muted small mb-0">
                                                CRUD completo para produtos: Cadastrar, Listar e Excluir.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="feature-card card border-0 p-4 text-center">
                                            <div class="feature-icon bg-gradient-orange text-white">
                                                <span class="iconify" data-icon="mdi:shield-account" data-width="32" data-height="32"></span>
                                            </div>
                                            <h6 class="fw-bold mb-2">Interface Segura</h6>
                                            <p class="text-muted small mb-0">
                                                Design responsivo com Bootstrap 5 e validações de segurança.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <span class="iconify" data-icon="mdi:folder-structure" data-width="20" data-height="20"></span>
                                    Estrutura do Projeto
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="fw-bold mb-3">📁 Organização de Arquivos</h6>
                                        <div class="timeline">
                                            <div class="timeline-item">
                                                <h6 class="fw-bold">/app/Controllers/</h6>
                                                <p class="text-muted small mb-0">
                                                    Controladores que processam as requisições e interagem com os modelos
                                                </p>
                                            </div>
                                            <div class="timeline-item">
                                                <h6 class="fw-bold">/app/Models/</h6>
                                                <p class="text-muted small mb-0">
                                                    Modelos que representam as entidades do banco de dados
                                                </p>
                                            </div>
                                            <div class="timeline-item">
                                                <h6 class="fw-bold">/app/Services/</h6>
                                                <p class="text-muted small mb-0">
                                                    Serviços com a lógica de negócio da aplicação
                                                </p>
                                            </div>
                                            <div class="timeline-item">
                                                <h6 class="fw-bold">/src/views/</h6>
                                                <p class="text-muted small mb-0">
                                                    Telas e interfaces do usuário
                                                </p>
                                            </div>
                                            <div class="timeline-item">
                                                <h6 class="fw-bold">/src/components/</h6>
                                                <p class="text-muted small mb-0">
                                                    Componentes reutilizáveis (header, footer, etc)
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <h6 class="fw-bold mb-3">🗃️ Estrutura do Banco</h6>
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="fw-bold text-primary">📊 Tabela: usuarios</h6>
                                                <ul class="list-unstyled small mb-3">
                                                    <li>• id (PK, Auto Increment)</li>
                                                    <li>• nome (VARCHAR)</li>
                                                    <li>• email (VARCHAR, Unique)</li>
                                                    <li>• senha (VARCHAR - SHA512)</li>
                                                    <li>• tipo_usuario (ENUM)</li>
                                                    <li>• criado_em (TIMESTAMP)</li>
                                                </ul>

                                                <h6 class="fw-bold text-primary">📦 Tabela: produtos</h6>
                                                <ul class="list-unstyled small mb-0">
                                                    <li>• id (PK, Auto Increment)</li>
                                                    <li>• nome (VARCHAR)</li>
                                                    <li>• descricao (TEXT)</li>
                                                    <li>• preco (DECIMAL)</li>
                                                    <li>• quantidade (INT)</li>
                                                    <li>• criado_em (TIMESTAMP)</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
                                    <span class="iconify" data-icon="mdi:link" data-width="20" data-height="20"></span>
                                    Links e Contatos
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4 mb-3">
                                        <a href="https://www.ifnmg.edu.br/" class="btn btn-outline-primary btn-lg w-100" target="_blank">
                                            <span class="iconify" data-icon="mdi:school" data-width="20" data-height="20"></span>
                                            Site IFNMG
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="https://github.com/KennedyPinheiro" class="btn btn-outline-dark btn-lg w-100" target="_blank">
                                            <span class="iconify" data-icon="mdi:github" data-width="20" data-height="20"></span>
                                            GitHub
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="/contato" class="btn btn-outline-success btn-lg w-100">
                                            <span class="iconify" data-icon="mdi:email" data-width="20" data-height="20"></span>
                                            Contato
                                        </a>
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