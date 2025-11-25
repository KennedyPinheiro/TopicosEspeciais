<?php
namespace App\Services;

use App\Models\User;
use Exception;

class AuthService
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function login($nome, $senha, $lembrar = false)
    {
        $user = $this->userModel->findByEmail($nome);
        
        if (!$user) {
            throw new Exception("Nome de usuário não encontrado!");
        }

        if (!password_verify($senha, $user['senha'])) {
            throw new Exception("Nome de usuário ou senha incorretos!");
        }

        $this->setUserSession($user);
        $this->setUserCookies($user, $lembrar, $nome, $senha);

        return true;
    }

    public function register($data)
    {
        $existingUser = $this->userModel->findByEmail($data['email']);
        if ($existingUser) {
            throw new Exception('E-mail já cadastrado.');
        }

        $data['senha_hash'] = password_hash($data['senha'], PASSWORD_DEFAULT);

        $result = $this->userModel->create($data);
        
        if (!$result) {
            throw new Exception('Erro ao cadastrar usuário. Tente novamente.');
        }

        return true;
    }

    private function setUserSession($user)
    {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        
        unset($_SESSION['erro_login']);
        unset($_SESSION['usuario_digitado']);
    }

    private function setUserCookies($user, $lembrar, $nome, $senha)
    {
        setcookie('nome_usuario', $user['nome'], [
            'expires' => time() + (2 * 3600),
            'path' => '/',
            'domain' => '',
            'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        if ($lembrar) {
            $dados_login = ['usuario' => $nome, 'senha' => $senha];
            setcookie('ultimo_login', json_encode($dados_login), [
                'expires' => time() + (30 * 24 * 60 * 60),
                'path' => '/',
                'domain' => '',
                'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        } else {
            $this->clearRememberCookie();
        }
    }

    private function clearRememberCookie()
    {
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

    public function isLoggedIn()
    {
        return isset($_SESSION['usuario_id']);
    }

    public function hasUserCookie()
    {
        return isset($_COOKIE['nome_usuario']);
    }
}