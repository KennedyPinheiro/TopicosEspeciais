<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\ProfileUpdateRequest;
use App\Requests\PasswordChangeRequest;
use App\Services\ProfileService;
use PDO;

class ProfileController extends BaseController
{
    private $profileService;
    private $userModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
        $this->profileService = new ProfileService($this->userModel);
    }

    public function perfil()
    {
        try {
            error_log("=== ProfileController Debug ===");
            error_log("SESSION: " . print_r($_SESSION, true));

            if (!isset($_SESSION['usuario_id'])) {
                error_log("REDIRECIONANDO para login - usuário não autenticado");
                $this->redirect('/login');
            }

            error_log("Tentando obter dados do perfil...");
            $usuario = $this->profileService->getUserProfileData();
            
            error_log("Sucesso! Renderizando perfil com dados:");
            error_log(print_r($usuario, true));
            
            $this->render('perfil', [
                'currentPage' => 'perfil',
                'pageTitle' => 'Perfil - Sistema IF',
                'usuario' => $usuario
            ]);
            
        } catch (\Exception $e) {
            error_log("ERRO no ProfileController: " . $e->getMessage());
            
            // Fallback seguro em caso de erro
            $usuarioFallback = [
                'nome' => $_SESSION['usuario_nome'] ?? 'Usuário',
                'email' => $_SESSION['usuario_email'] ?? 'erro@fallback.com',
                'telefone' => 'Não informado',
                'data_nascimento' => '',
                'data_nascimento_formatada' => 'Não informada',
                'tipo_usuario_formatado' => 'Usuário',
                'status' => 'ativo',
                'data_cadastro' => date('Y-m-d'),
                'data_cadastro_formatada' => date('d/m/Y'),
                'ultimo_acesso' => date('d/m/Y H:i:s'),
                'id' => $_SESSION['usuario_id'] ?? 'N/A',
                'departamento' => 'Não informado'
            ];
            
            error_log("Usando FALLBACK: " . print_r($usuarioFallback, true));
            
            $this->render('perfil', [
                'currentPage' => 'perfil',
                'pageTitle' => 'Perfil - Sistema IF',
                'usuario' => $usuarioFallback
            ]);
        }
    }

    public function atualizarPerfil()
    {
        try {
            $this->validateMethod('POST');

            if (!$this->verifyCsrfToken()) {
                $this->setFlash('erro_perfil', 'Token de segurança inválido.');
                $this->redirect('/perfil');
            }

            $request = new ProfileUpdateRequest($this->getPostData());

            if (!$request->validate()) {
                $this->setFlash('erro_perfil', $this->getFirstErrorMessage($request->getErrors()));
                $this->setFlash('form_data', $request->getFormData());
                $this->redirect('/perfil');
            }

            $data = $request->getValidatedData();

            $this->profileService->updateProfile($data);
            $this->setFlash('success_perfil', 'Perfil atualizado com sucesso!');
            
        } catch (\Exception $e) {
            error_log("Erro ao atualizar perfil: " . $e->getMessage());
            $this->setFlash('erro_perfil', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }

        $this->redirect('/perfil');
    }

    public function alterarSenha()
    {
        try {
            $this->validateMethod('POST');

            if (!$this->verifyCsrfToken()) {
                $this->setFlash('erro_senha', 'Token de segurança inválido.');
                $this->redirect('/perfil');
            }

            $request = new PasswordChangeRequest($this->getPostData());

            if (!$request->validate()) {
                $this->setFlash('erro_senha', $this->getFirstErrorMessage($request->getErrors()));
                $this->redirect('/perfil');
            }

            $data = $request->getValidatedData();

            $this->profileService->changePassword(
                $data['senha_atual'],
                $data['nova_senha']
            );

            $this->setFlash('success_senha', 'Senha alterada com sucesso!');
            
        } catch (\Exception $e) {
            error_log("Erro ao alterar senha: " . $e->getMessage());
            $this->setFlash('erro_senha', $e->getMessage());
        }

        $this->redirect('/perfil');
    }

    private function verifyCsrfToken()
    {
        try {
            return isset($_POST['csrf_token']) &&
                $_POST['csrf_token'] === ($_SESSION['csrf_token'] ?? '');
        } catch (\Exception $e) {
            error_log("Erro ao verificar CSRF token: " . $e->getMessage());
            return false;
        }
    }

    private function getFirstErrorMessage($errors)
    {
        try {
            return !empty($errors) ? current($errors) : 'Erro desconhecido';
        } catch (\Exception $e) {
            return 'Erro ao processar mensagens de erro';
        }
    }
}