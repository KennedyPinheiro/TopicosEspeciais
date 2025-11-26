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
        try {
            $pageTitle = 'Cadastro - Sistema IF';
            $form_data = $this->getFlash('form_data') ?? [];

            $this->render('cadastro', compact('pageTitle', 'form_data'));
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao carregar página de cadastro');
        }
    }

    public function login()
    {
        try {
            $pageTitle = 'Login - Sistema IF';

            $form_data = $this->getFlash('form_data') ?? [];
            $usuario_salvo = $form_data['email'] ?? '';
            $senha_salva = '';
            $lembrar_checked = isset($form_data['lembrar']) && $form_data['lembrar'] ? 'checked' : '';

            $this->render('login', compact('pageTitle', 'usuario_salvo', 'senha_salva', 'lembrar_checked'));
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao carregar página de login');
        }
    }

    public function processarCadastro()
    {
        try {
            $this->validateMethod('POST');

            $result = $this->userService->createUser($this->getPostData());

            if ($result['success']) {
                $this->setFlash('sucesso_cadastro', $result['message']);
                $this->redirect('/login');
            } else {
                $this->setFlash('erro_cadastro', 'Erro ao cadastrar. Verifique os dados informados.');
                $this->setFlash('form_errors', $result['errors']);
                $this->setFlash('form_data', $result['old_data']);
                $this->redirect('/cadastro');
            }
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao processar cadastro');
        }
    }

    public function processarLogin()
    {
        try {
            error_log("=== PROCESSAR LOGIN (AuthController) ===");

            $this->validateMethod('POST');

            $request = new LoginRequest($this->getPostData());

            if (!$request->validate()) {
                error_log("Validação falhou: " . print_r($request->getErrors(), true));
                $this->setFlash('erro_login', 'Por favor, corrija os erros abaixo.');
                $this->setFlash('form_data', $request->getFormData());
                $this->redirect('/login');
            }

            $data = $request->getValidatedData();
            $email = $data['email'];
            $senha = $data['senha'];
            $lembrar_dados = $data['lembrar'];

            error_log("Tentativa de login: email=$email, lembrar=$lembrar_dados");

            $user = $this->userService->getUserByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                error_log("Login válido - configurando sessão e cookies");

                setcookie('nome_usuario', $user['nome'], [
                    'expires' => time() + (2 * 3600),
                    'path' => '/',
                    'domain' => '',
                    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);

                if ($lembrar_dados) {
                    error_log("Salvando dados de login no cookie - LEMBRAR ATIVADO");
                    $dados_login = [
                        'usuario' => $email,
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
                    error_log("Limpando cookie de lembrar dados - LEMBRAR DESATIVADO");
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
                $_SESSION['usuario_email'] = $user['email'];
                $_SESSION['usuario_tipo'] = $user['tipo_usuario'];
                $_SESSION['logado'] = true;

                unset($_SESSION['erro_login']);
                unset($_SESSION['usuario_digitado']);

                $this->setFlash('success_message', 'Login realizado com sucesso!');

                error_log("Redirecionando para /home");
                $this->redirect('/home');
            } else {
                error_log("Login inválido - email ou senha incorretos");
                $this->setFlash('erro_login', 'E-mail ou senha inválidos.');
                $this->setFlash('form_data', [
                    'email' => $email,
                    'lembrar' => $lembrar_dados
                ]);
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao processar login');
        }
    }

    private function setRememberMeCookies($user)
    {
        try {
            $rememberToken = bin2hex(random_bytes(32));
            $expiry = time() + (30 * 24 * 60 * 60);

            setcookie('remember_token', $rememberToken, [
                'expires' => $expiry,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            setcookie('user_identifier', $user['email'], [
                'expires' => $expiry,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => false,
                'samesite' => 'Lax'
            ]);
        } catch (\Exception $e) {
            error_log("Erro ao configurar cookies de lembrar: " . $e->getMessage());
        }
    }

    private function clearRememberMeCookies()
    {
        try {
            if (isset($_COOKIE['remember_token'])) {
                setcookie('remember_token', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'domain' => '',
                    'secure' => isset($_SERVER['HTTPS']),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }

            if (isset($_COOKIE['user_identifier'])) {
                setcookie('user_identifier', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'domain' => '',
                    'secure' => isset($_SERVER['HTTPS']),
                    'httponly' => false,
                    'samesite' => 'Lax'
                ]);
            }
        } catch (\Exception $e) {
            error_log("Erro ao limpar cookies de lembrar: " . $e->getMessage());
        }
    }

    public function renderModaisTermos()
    {
        try {
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
        } catch (\Exception $e) {
            error_log("Erro ao renderizar modais: " . $e->getMessage());
        }
    }
}
