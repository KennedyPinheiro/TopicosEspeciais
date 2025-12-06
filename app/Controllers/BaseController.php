<?php

namespace App\Controllers;

use App\Services\EncryptionService;
use App\Services\ProductService;

class BaseController
{
    protected $pdo;
    protected $encryptionService;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->encryptionService = new EncryptionService();
    }

    protected function render(string $view, array $data = [])
    {
        try {
            extract($data);

            $viewPath = __DIR__ . '/../../src/views/' . $view . '.php';

            error_log("Tentando carregar view: " . $viewPath);
            error_log("View existe: " . (file_exists($viewPath) ? 'SIM' : 'NÃO'));

            if (!file_exists($viewPath)) {
                $this->showErrorPage(404, "View {$view} não encontrada");
                return;
            }

            require $viewPath;
        } catch (\Exception $e) {
            $this->handleError($e, "Erro ao renderizar view: {$view}");
        }
    }

    protected function renderComponent(string $component, array $data = [])
    {
        try {
            $componentPath = __DIR__ . '/../../src/components/' . $component . '.php';

            if (!file_exists($componentPath)) {
                throw new \Exception("Componente {$component} não encontrado");
            }

            extract($data);
            require $componentPath;
        } catch (\Exception $e) {
            $this->handleError($e, "Erro ao renderizar componente: {$component}");
        }
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
    protected function encryptId($id)
    {
        return $this->encryptionService->encryptId($id);
    }
    protected function decryptId($encryptedId)
    {
        $id = $this->encryptionService->decryptId($encryptedId);
        if (!$id) {
            throw new \Exception('ID inválido ou corrompido');
        }
        return $id;
    }

    protected function isEncryptedId($string)
    {
        return $this->encryptionService->isEncryptedId($string);
    }
    protected function processId($id)
{
    error_log("=== PROCESS ID DEBUG ===");
    error_log("Input: " . $id);
    error_log("Type: " . gettype($id));
    
    if ($this->isEncryptedId($id)) {
        error_log("É criptografado - descriptografando...");
        $decrypted = $this->decryptId($id);
        error_log("Resultado descriptografado: " . $decrypted);
        return $decrypted;
    }
    
    if (is_numeric($id)) {
        error_log("É numérico - convertendo para int");
        return (int)$id;
    }
    
    error_log("ERRO: ID inválido");
    throw new \Exception('ID inválido');
}
    protected function redirect(string $url)
    {
        try {
            header('Location: ' . $url);
            exit;
        } catch (\Exception $e) {
            $this->handleError($e, "Erro ao redirecionar para: {$url}");
        }
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


    protected function handleError(\Exception $e, string $context = 'Erro')
    {
        error_log("{$context}: " . $e->getMessage() . " em " . $e->getFile() . ":" . $e->getLine());

        $message = urlencode("{$context}: " . $e->getMessage());

        if (
            strpos($e->getMessage(), 'not found') !== false ||
            strpos($e->getMessage(), 'não encontrado') !== false ||
            strpos($e->getMessage(), 'não encontrada') !== false
        ) {
            $this->showErrorPage(404, $message);
        } elseif (
            strpos($e->getMessage(), 'permission') !== false ||
            strpos($e->getMessage(), 'acesso negado') !== false ||
            strpos($e->getMessage(), 'não autorizado') !== false
        ) {
            $this->showErrorPage(403, $message);
        } elseif (
            strpos($e->getMessage(), 'validation') !== false ||
            strpos($e->getMessage(), 'validação') !== false
        ) {
            $this->showErrorPage(400, $message);
        } else {
            $this->showErrorPage(500, $message);
        }
    }


    protected function showErrorPage(int $errorCode = 500, string $message = '')
    {
        $errorFile = __DIR__ . '/../../src/views/erros/' . $errorCode . '.php';

        if (!file_exists($errorFile)) {
            $errorFile = __DIR__ . '/../../src/views/erros/geral.php';
        }

        $httpCodes = [
            400 => 400,
            403 => 403,
            404 => 404,
            500 => 500
        ];

        if (isset($httpCodes[$errorCode])) {
            http_response_code($httpCodes[$errorCode]);
        }

        include $errorFile;
        exit;
    }

    protected function redirectToError(int $errorCode = 500, string $message = '')
    {
        $queryString = $message ? '?message=' . urlencode($message) : '';
        $this->redirect("/erro/{$errorCode}{$queryString}");
    }

    protected function validateId($id): int
    {
        if (!$id || !is_numeric($id) || $id <= 0) {
            $this->redirectToError(400, 'ID inválido');
        }
        return (int) $id;
    }


    protected function validateMethod(string $expectedMethod)
    {
        if ($_SERVER['REQUEST_METHOD'] !== strtoupper($expectedMethod)) {
            $this->redirectToError(405, 'Método não permitido');
        }
    }


    protected function requireAuth()
    {
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirectToError(403, 'Acesso não autorizado. Faça login para continuar.');
        }
    }


    protected function validateRequiredFields(array $data, array $requiredFields)
    {
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field] ?? '')) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            $this->setFlash('erro', 'campos_obrigatorios');
            $this->setFlash('form_errors', array_fill_keys($missingFields, 'Campo obrigatório'));
            $this->setFlash('form_data', $data);
            return false;
        }

        return true;
    }


    protected function jsonResponse(array $data, int $statusCode = 200)
    {
        try {
            http_response_code($statusCode);
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao gerar resposta JSON');
        }
    }

    protected function jsonSuccess(string $message = '', array $data = [])
    {
        $this->jsonResponse([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function jsonError(string $message = '', int $statusCode = 400)
    {
        $this->jsonResponse([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }

    protected function sanitizeInput($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }

        return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
    }

    protected function getPostData()
    {
        return $this->sanitizeInput($_POST);
    }

    protected function getQueryParams()
    {
        return $this->sanitizeInput($_GET);
    }

    protected function isAjaxRequest(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
