<?php

namespace App\Services;

use App\Models\User;
use App\Requests\UserRequest;

class UserService
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createUser(array $data): array
    {
        try {
            $request = new UserRequest($data);
            
            if (!$request->validate()) {
                return [
                    'success' => false,
                    'errors' => $request->getErrors(),
                    'old_data' => $request->getOldData()
                ];
            }

            if ($this->userModel->findByEmail($data['email'])) {
                return [
                    'success' => false,
                    'errors' => ['email' => 'Este e-mail já está cadastrado'],
                    'old_data' => $request->getOldData()
                ];
            }

            $validatedData = $request->getValidatedData();

            $userId = $this->userModel->create($validatedData);
            
            if ($userId) {
                return [
                    'success' => true,
                    'message' => 'Usuário cadastrado com sucesso!',
                    'user_id' => $userId
                ];
            } else {
                throw new \Exception('Erro ao criar usuário no banco de dados');
            }
            
        } catch (\Exception $e) {
            error_log('Erro ao criar usuário: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['general' => 'Erro interno do sistema. Tente novamente.'],
                'old_data' => $data
            ];
        }
    }

    public function updateUser(int $id, array $data): array
    {
        try {
            $request = new UserRequest($data);
            
            if (empty($data['senha'])) {
                unset($data['senha']);
                unset($data['confirmar_senha']);
            }

            if (!$request->validate()) {
                return [
                    'success' => false,
                    'errors' => $request->getErrors(),
                    'old_data' => $request->getOldData()
                ];
            }

            $existingUser = $this->userModel->findByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $id) {
                return [
                    'success' => false,
                    'errors' => ['email' => 'Este e-mail já está cadastrado'],
                    'old_data' => $request->getOldData()
                ];
            }

            $validatedData = $request->getValidatedData();

            $result = $this->userModel->update($id, $validatedData);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Usuário atualizado com sucesso!'
                ];
            } else {
                throw new \Exception('Erro ao atualizar usuário no banco de dados');
            }
            
        } catch (\Exception $e) {
            error_log('Erro ao atualizar usuário: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['general' => 'Erro interno do sistema. Tente novamente.'],
                'old_data' => $data
            ];
        }
    }

    public function getUserById(int $id): ?array
    {
        try {
            return $this->userModel->findById($id);
        } catch (\Exception $e) {
            error_log('Erro ao buscar usuário por ID: ' . $e->getMessage());
            return null;
        }
    }

    public function getUserByEmail(string $email): ?array
    {
        try {
            return $this->userModel->findByEmail($email);
        } catch (\Exception $e) {
            error_log('Erro ao buscar usuário por email: ' . $e->getMessage());
            return null;
        }
    }
}