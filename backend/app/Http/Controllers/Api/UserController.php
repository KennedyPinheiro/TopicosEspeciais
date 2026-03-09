<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Display a listing of users.
     */
    public function index(): UserCollection
    {
        $users = $this->userService->getAllUsers();
        return new UserCollection($users);
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request->validated());
            
            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'data' => new UserResource($user)
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        }
        
        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->userService->updateUser($id, $request->validated());
            
            if (!$updated) {
                return response()->json([
                    'message' => 'Usuário não encontrado'
                ], 404);
            }
            
            $user = $this->userService->getUserById($id);
            
            return response()->json([
                'message' => 'Usuário atualizado com sucesso',
                'data' => new UserResource($user)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->userService->deleteUser($id);
            
            if (!$deleted) {
                return response()->json([
                    'message' => 'Usuário não encontrado'
                ], 404);
            }
            
            return response()->json([
                'message' => 'Usuário deletado com sucesso'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
