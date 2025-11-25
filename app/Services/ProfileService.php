<?php
namespace App\Services;

use App\Models\User;

class ProfileService
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUserProfileData(): array
    {
        $usuario_id = $_SESSION['usuario_id'] ?? null;

        error_log("=== ProfileService Debug ===");
        error_log("SESSION usuario_id: " . ($_SESSION['usuario_id'] ?? 'NULL'));

        if (!$usuario_id) {
            error_log("ERRO: Usuário não autenticado");
            throw new \Exception('Usuário não autenticado.');
        }

        $usuario = $this->userModel->findById($usuario_id);

        error_log("Resultado da busca no banco: " . ($usuario ? 'ENCONTRADO' : 'NÃO ENCONTRADO'));
        if ($usuario) {
            error_log("Dados do usuário: " . print_r($usuario, true));
        }

        if (!$usuario) {
            error_log("ERRO: Usuário não encontrado no banco de dados");
            throw new \Exception('Usuário não encontrado.');
        }

        $formatted = $this->formatUserData($usuario);
        error_log("Dados formatados: " . print_r($formatted, true));

        return $formatted;
    }

    private function formatUserData(array $usuario): array
    {
        $tipos_usuario = [
            'gerente' => 'Gerente',
            'vendedor' => 'Vendedor',
            'estoque' => 'Estoque',
            'visualizador' => 'Visualizador'
        ];

        $formatted = [
            'id' => $usuario['id'] ?? 'N/A',
            'nome' => htmlspecialchars($usuario['nome'] ?? 'Usuário'),
            'email' => htmlspecialchars($usuario['email'] ?? 'Não disponível'),
            'telefone' => isset($usuario['telefone']) && $usuario['telefone'] ? htmlspecialchars($usuario['telefone']) : 'Não informado',
            'data_nascimento' => $usuario['data_nascimento'] ?? '',
            'data_nascimento_formatada' => $this->formatDate($usuario['data_nascimento'] ?? null),
            'tipo_usuario' => $usuario['tipo_usuario'] ?? 'visualizador',
            'tipo_usuario_formatado' => $tipos_usuario[$usuario['tipo_usuario'] ?? 'visualizador'] ?? 'Visualizador',
            'departamento' => isset($usuario['departamento']) && $usuario['departamento'] ? htmlspecialchars($usuario['departamento']) : 'Não informado',
            'status' => $usuario['status'] ?? 'ativo',
            'data_cadastro' => $usuario['criado_em'] ?? date('Y-m-d H:i:s'),
            'ultimo_acesso' => $this->formatDateTime($usuario['atualizado_em'] ?? null)
        ];

        error_log("Dados formatados para view:");
        error_log("Nome: " . $formatted['nome']);
        error_log("Email: " . $formatted['email']);
        error_log("Telefone: " . $formatted['telefone']);
        error_log("Data Nascimento: " . $formatted['data_nascimento']);

        return $formatted;
    }

    private function formatDate(?string $date): string
    {
        if (!$date) {
            return 'Não informada';
        }
        
        try {
            $timestamp = strtotime($date);
            return $timestamp !== false ? date('d/m/Y', $timestamp) : 'Data inválida';
        } catch (\Exception $e) {
            error_log("Erro ao formatar data: " . $e->getMessage());
            return 'Data inválida';
        }
    }

    private function formatDateTime(?string $datetime): string
    {
        if (!$datetime) {
            return 'Nunca';
        }
        
        try {
            $timestamp = strtotime($datetime);
            return $timestamp !== false ? date('d/m/Y H:i:s', $timestamp) : 'Data/hora inválida';
        } catch (\Exception $e) {
            error_log("Erro ao formatar data/hora: " . $e->getMessage());
            return 'Data/hora inválida';
        }
    }

    public function updateProfile(array $data): bool
    {
        $usuario_id = $_SESSION['usuario_id'] ?? null;

        if (!$usuario_id) {
            throw new \Exception('Usuário não autenticado.');
        }

        $existingUser = $this->userModel->findByEmail($data['email']);
        if ($existingUser && $existingUser['id'] != $usuario_id) {
            throw new \Exception('Este e-mail já está em uso por outro usuário.');
        }

        return $this->userModel->updateProfile($usuario_id, $data);
    }

    public function changePassword(string $senhaAtual, string $novaSenha): bool
    {
        $usuario_id = $_SESSION['usuario_id'] ?? null;

        if (!$usuario_id) {
            throw new \Exception('Usuário não autenticado.');
        }

        $usuario = $this->userModel->findById($usuario_id);
        if (!$usuario || !password_verify($senhaAtual, $usuario['senha'])) {
            throw new \Exception('Senha atual incorreta.');
        }

        return $this->userModel->updatePassword($usuario_id, $novaSenha);
    }

    public function canEditProfile($user_id): bool
    {
        $current_user_id = $_SESSION['usuario_id'] ?? null;
        return $current_user_id && $current_user_id == $user_id;
    }

    public function getUserStats($user_id): array
    {
        try {
            return $this->userModel->getUserStats($user_id);
        } catch (\Exception $e) {
            error_log("Erro ao buscar estatísticas: " . $e->getMessage());
            return [];
        }
    }
}
?>