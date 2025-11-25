<?php
namespace App\Middleware;

class AuthMiddleware
{
    public static function checkAuth()
    {
        if (!isset($_COOKIE['nome_usuario'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function redirectIfAuthenticated()
    {
        if (isset($_COOKIE['nome_usuario'])) {
            header('Location: /home');
            exit;
        }
    }
}