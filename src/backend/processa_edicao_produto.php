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

$camposObrigatorios = ['id', 'nome', 'preco', 'quantidade', 'sku'];
foreach ($camposObrigatorios as $campo) {
    if (empty($_POST[$campo])) {
        header('Location: /produtos/editar?id=' . $_POST['id'] . '&erro=campos_obrigatorios');
        exit;
    }
}

$id = intval($_POST['id']);
$nome = trim($_POST['nome']);
$descricao = trim($_POST['descricao'] ?? '');
$preco = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco']));
$quantidade = intval($_POST['quantidade']); 
$sku = trim($_POST['sku']);
$categoria = trim($_POST['categoria'] ?? '');
$imagem = $_POST['imagem_atual'] ?? null;

if ($preco <= 0) {
    header('Location: /produtos/editar?id=' . $id . '&erro=preco_invalido');
    exit;
}

if ($quantidade < 0) {
    header('Location: /produtos/editar?id=' . $id . '&erro=quantidade_invalida');
    exit;
}

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $pasta = __DIR__ . '/../../assets/imagens/produtos/';
    
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $tipoArquivo = mime_content_type($_FILES['imagem']['tmp_name']);
    
    if (in_array($tipoArquivo, $tiposPermitidos)) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid() . '.' . $extensao;
        $caminhoFinal = $pasta . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFinal)) {
            if ($imagem) {
                $imagemAntiga = __DIR__ . '/../../' . $imagem;
                if (file_exists($imagemAntiga)) {
                    unlink($imagemAntiga);
                }
            }
            $imagem = 'assets/imagens/produtos/' . $nomeImagem;
        }
    }
}

try {
    $sqlVerifica = "SELECT id FROM produtos WHERE sku = :sku AND id != :id";
    $stmtVerifica = $pdo->prepare($sqlVerifica);
    $stmtVerifica->execute([':sku' => $sku, ':id' => $id]);
    
    if ($stmtVerifica->fetch()) {
        header('Location: /produtos/editar?id=' . $id . '&erro=sku_existente');
        exit;
    }

    $sql = "UPDATE produtos SET 
            nome = :nome, 
            descricao = :descricao, 
            preco = :preco, 
            quantidade = :quantidade, 
            sku = :sku, 
            categoria = :categoria, 
            imagem = :imagem 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':preco' => $preco,
        ':quantidade' => $quantidade,
        ':sku' => $sku,
        ':categoria' => $categoria,
        ':imagem' => $imagem,
        ':id' => $id
    ]);

    header("Location: /produtos?sucesso=produto_editado");
    exit();

} catch (PDOException $e) {
    error_log("Erro ao editar produto: " . $e->getMessage());
    
    header('Location: /produtos/editar?id=' . $id . '&erro=erro_banco_dados&msg=' . urlencode($e->getMessage()));
    exit();
}
?>