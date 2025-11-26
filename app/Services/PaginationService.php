<?php

class PaginationService
{
    public static function paginar(
        array $dados, 
        int $limite = 15, 
        string $termoBusca = '', 
        ?callable $filtro = null
    ): array {
        $paginaAtual = (int) ($_GET['pagina'] ?? 1);
        $offset = ($paginaAtual - 1) * $limite;
        if ($filtro !== null) {
            $dadosFiltrados = array_filter($dados, $filtro);
        } elseif (!empty($termoBusca)) {
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
            'dados' => $dadosPaginados,
            'paginaAtual' => $paginaAtual,
            'totalPaginas' => $totalPaginas,
            'totalItens' => $totalItens,
            'limite' => $limite,
            'termoBusca' => $termoBusca
        ];
    }

    public static function gerarLinksPaginacao(array $paginacao): string
    {
        $paginaAtual = $paginacao['paginaAtual'];
        $totalPaginas = $paginacao['totalPaginas'];
        
        if ($totalPaginas <= 1) {
            return '';
        }

        $queryParams = $_GET;
        $html = '<nav aria-label="Navegação de páginas"><ul class="pagination justify-content-center">';
        
        $disabledAnterior = $paginaAtual <= 1 ? 'disabled' : '';
        $html .= '<li class="page-item ' . $disabledAnterior . '">';
        $html .= '<a class="page-link" href="?' . http_build_query(array_merge($queryParams, ['pagina' => $paginaAtual - 1])) . '" aria-label="Anterior">';
        $html .= '<span aria-hidden="true">&laquo;</span></a></li>';

        for ($i = 1; $i <= $totalPaginas; $i++) {
            $active = $i == $paginaAtual ? 'active' : '';
            $html .= '<li class="page-item ' . $active . '">';
            $html .= '<a class="page-link" href="?' . http_build_query(array_merge($queryParams, ['pagina' => $i])) . '">' . $i . '</a></li>';
        }

        $disabledProximo = $paginaAtual >= $totalPaginas ? 'disabled' : '';
        $html .= '<li class="page-item ' . $disabledProximo . '">';
        $html .= '<a class="page-link" href="?' . http_build_query(array_merge($queryParams, ['pagina' => $paginaAtual + 1])) . '" aria-label="Próximo">';
        $html .= '<span aria-hidden="true">&raquo;</span></a></li>';

        $html .= '</ul></nav>';
        return $html;
    }

    public static function getTermoBusca(): string
    {
        return $_GET['busca'] ?? '';
    }

    public static function getPaginaAtual(): int
    {
        return (int) ($_GET['pagina'] ?? 1);
    }
    public static function getProdutosMaisCaros(array $produtos, int $limite = 8): array
{
    usort($produtos, function($a, $b) {
        return ($b['preco'] ?? 0) <=> ($a['preco'] ?? 0);
    });

    return array_slice($produtos, 0, $limite);
}
}