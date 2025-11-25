<?php

namespace App\Controllers;

class BaseController
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function render(string $view, array $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../../src/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} não encontrada");
        }

        require $viewPath;
    }

    protected function renderComponent(string $component, array $data = [])
    {
        $componentPath = __DIR__ . '/../../src/components/' . $component . '.php';

        if (!file_exists($componentPath)) {
            throw new \Exception("Componente {$component} não encontrada");
        }

        extract($data);

        require $componentPath;
    }

    protected function setFlash(string $key, $value)
    {
        $_SESSION['flash_messages'][$key] = $value;
    }

    protected function getFlash(string $key)
    {
        $value = $_SESSION['flash_messages'][$key] ?? null;
        unset($_SESSION['flash_messages'][$key]);
        return $value;
    }

    protected function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }

    protected function formatDate($date)
    {
        if (!$date) return '01/01/1970';

        try {
            $timestamp = strtotime($date);
            return $timestamp !== false ? date('d/m/Y', $timestamp) : '01/01/1970';
        } catch (\Exception $e) {
            return '01/01/1970';
        }
    }
}
