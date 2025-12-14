<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data): User
    {
        DB::beginTransaction();
        
        try {
            $user = $this->userRepository->create($data);
            
            // Adicione lógica adicional aqui (enviar email, logs, etc)
            // event(new UserCreated($user));
            
            DB::commit();
            return $user;
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateUser(int $id, array $data): bool
    {
        DB::beginTransaction();
        
        try {
            $updated = $this->userRepository->update($id, $data);
            
            if ($updated) {
               
            }
            
            DB::commit();
            return $updated;
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}