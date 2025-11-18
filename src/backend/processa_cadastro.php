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

    $required_fields = ['username', 'email', 'password', 'confirm', 'terms'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new Exception('Preencha todos os campos.');
        }
    }

    $nome = trim($_POST['username']);
    $email = trim($_POST['email']);
    $senha = $_POST['password'];
    $confirmaSenha = $_POST['confirm'];
    $termos = $_POST['terms'];

    if (strlen($nome) < 3) throw new Exception('O nome deve ter pelo menos 3 caracteres.');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception('E-mail inválido.');
    if (strlen($senha) < 6) throw new Exception('A senha deve ter pelo menos 6 caracteres.');
    if ($senha !== $confirmaSenha) throw new Exception('As senhas não coincidem.');
    if ($termos !== 'on') throw new Exception('Você deve aceitar os termos de uso.');

    $check_stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? OR nome = ?");
    $check_stmt->bind_param('ss', $email, $nome);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        throw new Exception('E-mail ou nome de usuário já cadastrado.');
    }
    $check_stmt->close();

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $insert_stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $insert_stmt->bind_param('sss', $nome, $email, $senhaHash);

    if ($insert_stmt->execute()) {
        $insert_stmt->close();
        $conn->close();
        header('Location: /login?success=' . urlencode('Cadastro realizado com sucesso!'));
        exit;
    } else {
        throw new Exception('Erro ao cadastrar usuário.');
    }
} catch (Exception $e) {
    if (isset($conn) && is_object($conn)) {
        $conn->close();
    }

    $error_message = urlencode($e->getMessage());
    $username = isset($nome) ? urlencode($nome) : '';
    $useremail = isset($email) ? urlencode($email) : '';

    header("Location: /cadastro?error=$error_message&username=$username&email=$useremail");
    exit;
}
