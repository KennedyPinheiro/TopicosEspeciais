<?php
if (!isset($_COOKIE['nome_usuario'])) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /produtos');
    exit;
}

require_once __DIR__ . '/../config/db.php';

$camposObrigatorios = ['nome', 'preco', 'quantidade', 'sku'];
foreach ($camposObrigatorios as $campo) {
    if (empty($_POST[$campo])) {
        header('Location: /produtos/adicionar?erro=campos_obrigatorios');
        exit;
    }
}

$nome = trim($_POST['nome']);
$descricao = trim($_POST['descricao'] ?? '');
$preco = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco']));
$quantidade = intval($_POST['quantidade']); 
$sku = trim($_POST['sku']);
$categoria = trim($_POST['categoria'] ?? '');
$imagem = null;

if ($preco <= 0) {
    header('Location: /produtos/adicionar?erro=preco_invalido');
    exit;
}

if ($quantidade < 0) {
    header('Location: /produtos/adicionar?erro=quantidade_invalida');
    exit;
}

error_log("DEBUG - Arquivo de imagem recebido: " . print_r($_FILES['imagem'] ?? 'Nenhum arquivo', true));

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    error_log("DEBUG - Processando upload de imagem...");
    
    $pasta = __DIR__ . '/../../assets/imagens/produtos/';
    error_log("DEBUG - Pasta de destino: " . $pasta);
    
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
        error_log("DEBUG - Pasta criada: " . $pasta);
    }

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $tipoArquivo = mime_content_type($_FILES['imagem']['tmp_name']);
    error_log("DEBUG - Tipo MIME do arquivo: " . $tipoArquivo);
    
    if (in_array($tipoArquivo, $tiposPermitidos)) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid() . '.' . $extensao;
        $caminhoFinal = $pasta . $nomeImagem;

        error_log("DEBUG - Tentando mover arquivo para: " . $caminhoFinal);
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFinal)) {
            $imagem = 'assets/imagens/produtos/' . $nomeImagem;
            error_log("DEBUG - Imagem salva com sucesso: " . $imagem);
        } else {
            error_log("DEBUG - ERRO: Falha ao mover arquivo uploadado");
            $erroUpload = error_get_last();
            error_log("DEBUG - Erro do sistema: " . print_r($erroUpload, true));
        }
    } else {
        error_log("DEBUG - Tipo de arquivo não permitido: " . $tipoArquivo);
    }
} else {
    $erroUpload = $_FILES['imagem']['error'] ?? 'Nenhum arquivo';
    error_log("DEBUG - Erro no upload ou nenhum arquivo: " . $erroUpload);
}

error_log("DEBUG - Valor da imagem para o banco: " . ($imagem ?? 'NULL'));

try {
    $sqlVerifica = "SELECT id FROM produtos WHERE sku = :sku";
    $stmtVerifica = $pdo->prepare($sqlVerifica);
    $stmtVerifica->execute([':sku' => $sku]);
    
    if ($stmtVerifica->fetch()) {
        header('Location: /produtos/adicionar?erro=sku_existente');
        exit;
    }

    $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade, sku, categoria, imagem)
            VALUES (:nome, :descricao, :preco, :quantidade, :sku, :categoria, :imagem)";

    $stmt = $pdo->prepare($sql);
    
    error_log("DEBUG - Dados para inserção: " . print_r([
        'nome' => $nome,
        'descricao' => $descricao,
        'preco' => $preco,
        'quantidade' => $quantidade,
        'sku' => $sku,
        'categoria' => $categoria,
        'imagem' => $imagem
    ], true));
    
    $resultado = $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':preco' => $preco,
        ':quantidade' => $quantidade,
        ':sku' => $sku,
        ':categoria' => $categoria,
        ':imagem' => $imagem
    ]);

    if ($resultado) {
        error_log("DEBUG - Produto inserido com sucesso no banco");
        header("Location: /produtos?sucesso=produto_adicionado");
    } else {
        error_log("DEBUG - ERRO: Falha na execução do SQL");
        header('Location: /produtos/adicionar?erro=erro_banco_dados&msg=Falha+na+inserção');
    }
    exit();

} catch (PDOException $e) {
    error_log("Erro ao adicionar produto: " . $e->getMessage());
    
    header('Location: /produtos/adicionar?erro=erro_banco_dados&msg=' . urlencode($e->getMessage()));
    exit();
}
?>