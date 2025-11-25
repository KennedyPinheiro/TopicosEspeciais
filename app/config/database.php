<?php
$host = 'localhost';
$db   = 'Site2';
$user = 'root';
$pass = 'Senha@123';


$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Erro na conexão com o banco: ' . $conn->connect_error);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão PDO: ' . $e->getMessage());
}
?>