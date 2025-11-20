<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_COOKIE["nome_usuario"])) {
    header('Location: /home');
    exit();
}

require_once __DIR__ . '/../config/db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    $required_fields = ['nome', 'email', 'senha', 'confirmar_senha'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception('Preencha todos os campos obrigatórios.');
        }
    }

    if (!isset($_POST['termos']) || $_POST['termos'] !== 'on') {
        throw new Exception('Você deve aceitar os termos de uso.');
    }

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : null;
    $data_nascimento = isset($_POST['data_nascimento']) ? trim($_POST['data_nascimento']) : null;
    $tipo_usuario = isset($_POST['tipo_usuario']) ? trim($_POST['tipo_usuario']) : 'visualizador';
    $departamento = isset($_POST['departamento']) ? trim($_POST['departamento']) : null;

    // Validações
    if (strlen($nome) < 3) throw new Exception('O nome deve ter pelo menos 3 caracteres.');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception('E-mail inválido.');
    if (strlen($senha) < 6) throw new Exception('A senha deve ter pelo menos 6 caracteres.');
    if ($senha !== $confirmar_senha) throw new Exception('As senhas não coincidem.');

    if ($data_nascimento) {
        $data_timestamp = strtotime($data_nascimento);
        if (!$data_timestamp) {
            throw new Exception('Data de nascimento inválida.');
        }
        if ($data_timestamp > time()) {
            throw new Exception('Data de nascimento não pode ser futura.');
        }
    }

    $tipos_permitidos = ['gerente', 'vendedor', 'estoque', 'visualizador'];
    if (!in_array($tipo_usuario, $tipos_permitidos)) {
        $tipo_usuario = 'visualizador';
    }

    $check_stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check_stmt->execute([$email]);
    
    if ($check_stmt->fetch()) {
        throw new Exception('E-mail já cadastrado.');
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    $insert_stmt = $pdo->prepare("INSERT INTO usuarios 
        (nome, email, senha, telefone, data_nascimento, tipo_usuario, departamento, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'ativo')");
    
    $result = $insert_stmt->execute([
        $nome,
        $email,
        $senha_hash,
        $telefone,
        $data_nascimento ?: null,
        $tipo_usuario,
        $departamento
    ]);

    if ($result) {
        $_SESSION['success_message'] = 'Cadastro realizado com sucesso! Você já pode fazer login.';
        header('Location: /login');
        exit;
    } else {
        throw new Exception('Erro ao cadastrar usuário. Tente novamente.');
    }

} catch (PDOException $e) {
    error_log("Erro PDO no cadastro: " . $e->getMessage());
    $_SESSION['erro_cadastro'] = 'Erro no servidor. Tente novamente mais tarde.';
    
    $_SESSION['form_data'] = [
        'nome' => $_POST['nome'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefone' => $_POST['telefone'] ?? '',
        'data_nascimento' => $_POST['data_nascimento'] ?? '',
        'tipo_usuario' => $_POST['tipo_usuario'] ?? 'visualizador',
        'departamento' => $_POST['departamento'] ?? ''
    ];
    
    header("Location: /cadastro");
    exit;

} catch (Exception $e) {
    $_SESSION['erro_cadastro'] = $e->getMessage();
    
    $_SESSION['form_data'] = [
        'nome' => $_POST['nome'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefone' => $_POST['telefone'] ?? '',
        'data_nascimento' => $_POST['data_nascimento'] ?? '',
        'tipo_usuario' => $_POST['tipo_usuario'] ?? 'visualizador',
        'departamento' => $_POST['departamento'] ?? ''
    ];
    
    header("Location: /cadastro");
    exit;
}