<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Não autenticado'
            ], 401);
        }

        $user = Auth::user();
        
        if ($user->role_id !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso restrito a administradores'
            ], 403);
        }

        if ($user->primeiro_acesso && !$request->is('api/auth/first-access*')) {
            return response()->json([
                'success' => false,
                'message' => 'É necessário alterar a senha antes de acessar o sistema',
                'requires_password_change' => true
            ], 403);
        }

        return $next($request);
    }
}