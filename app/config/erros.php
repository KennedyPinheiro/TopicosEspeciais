<?php
define('APP_DEBUG', true); 

function logError($message) {
    $logFile = __DIR__ . '/../logs/errors.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

if (!APP_DEBUG) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $errorMessage = "{$error['message']} in {$error['file']} on line {$error['line']}";
        logError("Erro Fatal: $errorMessage");
        
        if (!APP_DEBUG) {
            header('Location: /erro/500?error=' . urlencode($errorMessage));
            exit;
        }
    }
});

set_exception_handler(function($exception) {
    logError("Exceção não capturada: " . $exception->getMessage());
    
    if (!APP_DEBUG) {
        header('Location: /erro/500?error=' . urlencode($exception->getMessage()));
        exit;
    }
});
?>