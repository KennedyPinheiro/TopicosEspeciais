<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\LoginRequest;
use App\Services\UserService;

class AuthController extends BaseController
{
    private $userService;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $userModel = new User($pdo);
        $this->userService = new UserService($userModel);
    }

    public function cadastro()
    {
        $pageTitle = 'Cadastro - Sistema IF';
        $form_data = $this->getFlash('form_data') ?? [];

        $this->render('cadastro', compact('pageTitle', 'form_data'));
    }

    public function login()
    {
        $pageTitle = 'Login - Sistema IF';
        
        $form_data = $this->getFlash('form_data') ?? [];
        $usuario_salvo = $form_data['email'] ?? '';
        $senha_salva = '';
        $lembrar_checked = isset($form_data['lembrar']) && $form_data['lembrar'] ? 'checked' : '';
        
        $this->render('login', compact('pageTitle', 'usuario_salvo', 'senha_salva', 'lembrar_checked'));
    }


    public function processarCadastro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cadastro');
            exit;
        }

        $result = $this->userService->createUser($_POST);

        if ($result['success']) {
            $this->setFlash('sucesso_cadastro', $result['message']);
            header('Location: /login');
            exit;
        } else {
            $this->setFlash('erro_cadastro', 'Erro ao cadastrar. Verifique os dados informados.');
            $this->setFlash('form_errors', $result['errors']);
            $this->setFlash('form_data', $result['old_data']);
            header('Location: /cadastro');
            exit;
        }
    }

    public function processarLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $request = new LoginRequest($_POST);
        
        if (!$request->validate()) {
            $this->setFlash('erro_login', 'Por favor, corrija os erros abaixo.');
            $this->setFlash('form_data', $request->getFormData());
            header('Location: /login');
            exit;
        }

        $data = $request->getValidatedData();
        $email = $data['email'];
        $senha = $data['senha'];

        $user = $this->userService->getUserByEmail($email);

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['usuario_email'] = $user['email'];
            $_SESSION['usuario_tipo'] = $user['tipo_usuario'];
            $_SESSION['logado'] = true;

            if ($data['lembrar']) {
                setcookie('nome_usuario', $user['nome'], time() + (86400 * 30), "/");
                setcookie('usuario_email', $user['email'], time() + (86400 * 30), "/");
            }

            $this->setFlash('success_message', 'Login realizado com sucesso!');
            header('Location: /home');
            exit;
        } else {
            $this->setFlash('erro_login', 'E-mail ou senha inválidos.');
            $this->setFlash('form_data', [
                'email' => $email,
                'lembrar' => $data['lembrar']
            ]);
            header('Location: /login');
            exit;
        }
    }

    public function renderModaisTermos()
    {
        echo '
        <!-- Modal Termos de Uso -->
        <div class="modal fade" id="termosUsoModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Termos de Uso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Conteúdo dos termos de uso...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Política de Privacidade -->
        <div class="modal fade" id="politicaPrivacidadeModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Política de Privacidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Conteúdo da política de privacidade...</p>
                    </div>
                </div>
            </div>
        </div>';
    }
}
?>