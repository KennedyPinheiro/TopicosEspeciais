<?php
function setupPagination(array $dados, int $limite = 15, string $termoBusca = ''): array 
{
    $paginaAtual = (int) ($_GET['pagina'] ?? 1);
    $offset = ($paginaAtual - 1) * $limite;

    if (!empty($termoBusca)) {
        $dadosFiltrados = array_filter($dados, function($item) use ($termoBusca) {
            return stripos($item['nome'] ?? '', $termoBusca) !== false || 
                   stripos($item['descricao'] ?? '', $termoBusca) !== false ||
                   stripos($item['sku'] ?? '', $termoBusca) !== false;
        });
    } else {
        $dadosFiltrados = $dados;
    }

    $totalItens = count($dadosFiltrados);
    $totalPaginas = $limite > 0 ? ceil($totalItens / $limite) : 1;
    $dadosPaginados = array_slice($dadosFiltrados, $offset, $limite);

    return [
        'dadosPaginados' => $dadosPaginados,
        'paginaAtual' => $paginaAtual,
        'totalPaginas' => $totalPaginas,
        'totalItens' => $totalItens,
        'limite' => $limite,
        'termoBusca' => $termoBusca
    ];
}

function renderPagination(array $paginacao): void 
{
    if ($paginacao['totalPaginas'] <= 1) {
        return;
    }
    
    $paginaAtual = $paginacao['paginaAtual'];
    $totalPaginas = $paginacao['totalPaginas'];
    $queryParams = $_GET;
    ?>
    <nav aria-label="Navegação de páginas">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $paginaAtual <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($queryParams, ['pagina' => $paginaAtual - 1])) ?>" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $paginaAtual ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($queryParams, ['pagina' => $i])) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            
            <li class="page-item <?= $paginaAtual >= $totalPaginas ? 'disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($queryParams, ['pagina' => $paginaAtual + 1])) ?>" aria-label="Próximo">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php
}

function getTermoBusca(): string 
{
    return $_GET['busca'] ?? '';
}