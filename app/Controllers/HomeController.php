<?php
namespace App\Controllers;

use App\Models\Product;
use PDO;

class HomeController extends BaseController
{

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo); 
    }

    public function index()
    {
        $productModel = new Product($this->pdo); 
        
        try {
            $produtos = $productModel->findAll(); 
            $totalProdutos = count($produtos);
            $comEstoque = 0;
            $semEstoque = 0;
            
            foreach ($produtos as $produto) {
                if ($produto['quantidade'] > 0) {
                    $comEstoque++;
                } else {
                    $semEstoque++;
                }
            }
        } catch (\Exception $e) {
            error_log("Erro ao buscar dados: " . $e->getMessage());
            $produtos = [];
            $totalProdutos = $comEstoque = $semEstoque = 0;
        }

        $this->render('home', [
            'currentPage' => 'home',
            'pageTitle' => 'Home - Sistema IF',
            'produtos' => $produtos,
            'totalProdutos' => $totalProdutos,
            'comEstoque' => $comEstoque,
            'semEstoque' => $semEstoque
        ]);
    }

    public function sobre()
    {
        $this->render('sobre', [
            'currentPage' => 'sobre',
            'pageTitle' => 'Sobre - Sistema IF'
        ]);
    }

    public function perfil()
    {
        $this->render('perfil', [
            'currentPage' => 'perfil',
            'pageTitle' => 'Perfil - Sistema IF'
        ]);
    }

    public function logout()
    {
        setcookie('nome_usuario', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
        ]);
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function telaLogout()
    {
        $this->render('tela-logout', [
            'currentPage' => 'logout',
            'pageTitle' => 'Sair - Sistema IF'
        ]);
    }
}