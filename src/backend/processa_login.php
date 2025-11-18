<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/db.php';
if (isset($_COOKIE["nome_usuario"])) {
    error_log("Já logado: " . $_COOKIE["nome_usuario"]);
    header('Location: /home');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $lembrar_dados = isset($_POST['lembrar']) && $_POST['lembrar'] == 'on';
    error_log("Tentativa de login: nome=$nome");
    if (empty($nome) || empty($senha)) {
        $_SESSION['erro_login'] = "Todos os campos são obrigatórios!";
        $_SESSION['usuario_digitado'] = $nome;
        header('Location: /login');
        exit();
    }
    try {
        $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE nome = ?");
        $stmt->bind_param('s', $nome);
        $stmt->execute();
        $result = $stmt->get_result();
        error_log("Usuários encontrados: " . $result->num_rows);
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            error_log("Usuário encontrado: " . $user['nome']);
            if (password_verify($senha, $user['senha'])) {
                error_log("Senha válida - definindo cookie");
                setcookie('nome_usuario', $user['nome'], [
                    'expires' => time() + (2 * 3600),
                    'path' => '/',
                    'domain' => '',
                    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
                if ($lembrar_dados) {
                    error_log("Salvando dados de login no cookie");
                    $dados_login = [
                        'usuario' => $nome,
                        'senha' => $senha
                    ];

                    setcookie('ultimo_login', json_encode($dados_login), [
                        'expires' => time() + (30 * 24 * 60 * 60),
                        'path' => '/',
                        'domain' => '',
                        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                } else {

                    if (isset($_COOKIE['ultimo_login'])) {
                        setcookie('ultimo_login', '', [
                            'expires' => time() - 3600,
                            'path' => '/',
                            'domain' => '',
                            'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                            'httponly' => true,
                            'samesite' => 'Lax'
                        ]);
                    }
                }

                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];

                unset($_SESSION['erro_login']);
                unset($_SESSION['usuario_digitado']);

                error_log("Cookie definido, redirecionando para /home");
                header('Location: /home');
                exit();
            } else {
                error_log("Senha inválida");
                throw new Exception("Nome de usuário ou senha incorretos!");
            }
        } else {
            error_log("Usuário não encontrado no banco");
            throw new Exception("Nome de usuário não encontrado!");
        }
    } catch (Exception $e) {
        error_log("Erro no login: " . $e->getMessage());
        $_SESSION['erro_login'] = $e->getMessage();
        $_SESSION['usuario_digitado'] = $nome;
        header('Location: /login');
        exit();
    }
} else {
    header('Location: /login');
    exit();
}
