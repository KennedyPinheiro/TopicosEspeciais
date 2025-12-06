 <?php
    if (!function_exists('TabelaRelatorioVendas')) {
        require_once __DIR__ . '/../../components/tabela_relatorio_vendas.php';
    }

    ?>
 <!DOCTYPE html>
 <html lang="pt-br">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Relatório de Vendas - Sistema</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
     <link rel="stylesheet" href="/assets/css/relatorio.css">
 </head>

 <body>
     <?php
        $nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário';
        $this->renderComponent('header', ['currentPage' => 'vendas', 'nome_usuario' => $nome_usuario]);
        ?>

     <main class="relatorio-container">
         <div class="full-width-header">
             <div class="container-fluid">
                 <div class="header-content">
                     <div class="header-text">
                         <h1 class="display-6 fw-bold">Relatórios de Vendas</h1>
                         <p class="lead mb-3 opacity-75">Análise e relatórios detalhados das vendas</p>
                     </div>
                     <div class="header-actions">
                         <a href="/vendas" class="btn btn-light btn-lg px-4">
                             <span class="iconify" data-icon="mdi:arrow-left" data-width="20" data-height="20"></span>
                             Voltar para Vendas
                         </a>
                     </div>
                 </div>
             </div>
         </div>

         <div class="container-fluid px-0">
             <div class="relatorio-layout">
                 <div class="relatorio-sidebar">
                     <div class="card profile-card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">
                                 <span class="iconify" data-icon="mdi:calendar" data-width="20" data-height="20"></span>
                                 Períodos Rápidos
                             </h5>
                         </div>
                         <div class="card-body">
                             <div class="d-grid gap-2">
                                 <a href="/vendas/relatorio?data_inicio=<?= date('Y-m-01') ?>&data_fim=<?= date('Y-m-t') ?>"
                                     class="btn btn-outline-primary text-start">
                                     <span class="iconify" data-icon="mdi:calendar-month" data-width="18" data-height="18"></span>
                                     Este Mês
                                 </a>
                                 <a href="/vendas/relatorio?data_inicio=<?= date('Y-m-d', strtotime('-7 days')) ?>&data_fim=<?= date('Y-m-d') ?>"
                                     class="btn btn-outline-primary text-start">
                                     <span class="iconify" data-icon="mdi:calendar-week" data-width="18" data-height="18"></span>
                                     Últimos 7 Dias
                                 </a>
                                 <a href="/vendas/relatorio?data_inicio=<?= date('Y-m-d', strtotime('-30 days')) ?>&data_fim=<?= date('Y-m-d') ?>"
                                     class="btn btn-outline-primary text-start">
                                     <span class="iconify" data-icon="mdi:calendar-range" data-width="18" data-height="18"></span>
                                     Últimos 30 Dias
                                 </a>
                                 <a href="/vendas/relatorio?data_inicio=<?= date('Y-01-01') ?>&data_fim=<?= date('Y-12-31') ?>"
                                     class="btn btn-outline-primary text-start">
                                     <span class="iconify" data-icon="mdi:calendar-year" data-width="18" data-height="18"></span>
                                     Este Ano
                                 </a>
                             </div>
                         </div>
                     </div>

                     <div class="card profile-card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">
                                 <span class="iconify" data-icon="mdi:chart-box" data-width="20" data-height="20"></span>
                                 Métricas do Período
                             </h5>
                         </div>
                         <div class="card-body">
                             <div class="info-item mb-3">
                                 <div class="d-flex justify-content-between align-items-center">
                                     <span class="text-muted">Período</span>
                                     <span class="fw-semibold">
                                         <?= !empty($dataInicio) ? date('d/m/Y', strtotime($dataInicio)) : date('d/m/Y') ?>
                                         a <?= !empty($dataFim) ? date('d/m/Y', strtotime($dataFim)) : date('d/m/Y') ?>
                                     </span>
                                 </div>
                             </div>
                             <div class="info-item mb-3">
                                 <div class="d-flex justify-content-between align-items-center">
                                     <span class="text-muted">Total de Vendas</span>
                                     <span class="fw-semibold text-primary"><?= count($vendas ?? []) ?></span>
                                 </div>
                             </div>
                             <div class="info-item mb-3">
                                 <div class="d-flex justify-content-between align-items-center">
                                     <span class="text-muted">Itens Vendidos</span>
                                     <span class="fw-semibold text-success"><?= $totalItens ?? 0 ?></span>
                                 </div>
                             </div>
                             <div class="info-item">
                                 <div class="d-flex justify-content-between align-items-center">
                                     <span class="text-muted">Ticket Médio</span>
                                     <span class="fw-semibold text-warning">
                                         R$ <?= number_format((($totalPeriodo ?? 0) / max(count($vendas ?? []), 1)), 2, ',', '.') ?>
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
                                 <button class="btn btn-outline-success text-start" id="btn-export-pdf">
                                     <span class="iconify" data-icon="mdi:file-pdf" data-width="18" data-height="18"></span>
                                     Exportar PDF
                                 </button>
                                 <button class="btn btn-outline-primary text-start" id="btn-export-excel">
                                     <span class="iconify" data-icon="mdi:file-excel" data-width="18" data-height="18"></span>
                                     Exportar Excel
                                 </button>
                                 <button class="btn btn-outline-info text-start">
                                     <span class="iconify" data-icon="mdi:email" data-width="18" data-height="18"></span>
                                     Enviar por Email
                                 </button>
                                 <a href="/vendas" class="btn btn-outline-warning text-start">
                                     <span class="iconify" data-icon="mdi:cart" data-width="18" data-height="18"></span>
                                     Nova Venda
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="relatorio-content">
                     <div class="content-wrapper">
                         <div class="card profile-card mb-4">
                             <div class="card-header">
                                 <h5 class="card-title mb-0">
                                     <span class="iconify" data-icon="mdi:filter" data-width="20" data-height="20"></span>
                                     Filtros do Relatório
                                 </h5>
                             </div>
                             <div class="card-body">
                                 <form method="GET" action="/vendas/relatorio" class="row g-3">
                                     <div class="col-md-5">
                                         <label for="data_inicio" class="form-label fw-semibold">
                                             <span class="iconify" data-icon="mdi:calendar-start" data-width="16" data-height="16"></span>
                                             Data Início
                                         </label>
                                         <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                             value="<?= $dataInicio ?? date('Y-m-01') ?>">
                                     </div>
                                     <div class="col-md-5">
                                         <label for="data_fim" class="form-label fw-semibold">
                                             <span class="iconify" data-icon="mdi:calendar-end" data-width="16" data-height="16"></span>
                                             Data Fim
                                         </label>
                                         <input type="date" class="form-control" id="data_fim" name="data_fim"
                                             value="<?= $dataFim ?? date('Y-m-t') ?>">
                                     </div>
                                     <div class="col-md-2 d-flex align-items-end">
                                         <button type="submit" class="btn btn-primary w-100">
                                             <span class="iconify" data-icon="mdi:chart-box" data-width="18" data-height="18"></span>
                                             Gerar
                                         </button>
                                     </div>
                                 </form>
                             </div>
                         </div>

                         <?php if (!empty($vendas)): ?>
                             <div class="card profile-card mb-4">
                                 <div class="card-header">
                                     <h5 class="card-title mb-0">
                                         <span class="iconify" data-icon="mdi:chart-pie" data-width="20" data-height="20"></span>
                                         Resumo do Período
                                     </h5>
                                 </div>
                                 <div class="card-body">
                                     <div class="row text-center">
                                         <div class="col-md-3 mb-3">
                                             <div class="metric-card p-3 border rounded">
                                                 <div class="h2 text-primary fw-bold mb-2">
                                                     <?= count($vendas) ?>
                                                 </div>
                                                 <small class="text-muted fw-semibold">Total de Vendas</small>
                                             </div>
                                         </div>
                                         <div class="col-md-3 mb-3">
                                             <div class="metric-card p-3 border rounded">
                                                 <div class="h2 text-success fw-bold mb-2">
                                                     <?= $totalItens ?? 0 ?>
                                                 </div>
                                                 <small class="text-muted fw-semibold">Itens Vendidos</small>
                                             </div>
                                         </div>
                                         <div class="col-md-3 mb-3">
                                             <div class="metric-card p-3 border rounded">
                                                 <div class="h2 text-warning fw-bold mb-2">
                                                     R$ <?= number_format($totalPeriodo ?? 0, 2, ',', '.') ?>
                                                 </div>
                                                 <small class="text-muted fw-semibold">Faturamento Total</small>
                                             </div>
                                         </div>
                                         <div class="col-md-3 mb-3">
                                             <div class="metric-card p-3 border rounded">
                                                 <div class="h2 text-info fw-bold mb-2">
                                                     R$ <?= number_format(($totalPeriodo ?? 0) / max(count($vendas), 1), 2, ',', '.') ?>
                                                 </div>
                                                 <small class="text-muted fw-semibold">Ticket Médio</small>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         <?php endif; ?>

                         <?php echo TabelaRelatorioVendas([
                                'vendas' => $vendas ?? [],
                                'dataInicio' => $dataInicio ?? '',
                                'dataFim' => $dataFim ?? '',
                                'totalPeriodo' => $totalPeriodo ?? 0,
                                'totalItens' => $totalItens ?? 0,
                                'limite' => 10
                            ]);
                            ?>
                     </div>
                 </div>
             </div>
     </main>

     <?php
        $this->renderComponent('footer');
        ?>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

     <script src="/assets/js/relatorio.js"></script>
 </body>

 </html>